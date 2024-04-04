<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneNumber\GiftAmountRequest;
use App\Http\Requests\User\AddTOBalanceRequest;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhoneNumberController extends Controller
{
    use Responses;
    public function AddToBalance(AddTOBalanceRequest $request)
    {
        // for testing purposes
        $validated = $request->validated();
        $phone_number = PhoneNumber::where('phone_number', $validated['phone_number'])->first();
        $new_balance = $phone_number->balance + $validated['amount'];
        $phone_number->forceFill(['balance' => $new_balance]);
        $phone_number->update();
        return $this->sudResponse('amount has been added to the provided number');

    }

    public function myPhoneNumbers(Request $request)
    {
        $user = PhoneNumber::where('phone_number', $request['phone_number'])->first()->user;
        $phone_numbers = $user->phoneNumbers->pluck('balance', 'phone_number');
        return $this->indexOrShowResponse('phone_numbers', ['count' => $phone_numbers->count(), 'phone_numbers' => $phone_numbers]);

    }
    public function getMyBalance(Request $request)
    {
        $balance = PhoneNumber::where('phone_number', $request['phone_number'])->first('balance');
        return $this->indexOrShowResponse('your balance', $balance);

    }

    public function Gift(GiftAmountRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $phone_number = PhoneNumber::where('phone_number', $validated['phone_number'])->first();
            $target_phone_number = PhoneNumber::where('phone_number', $validated['target_phone_number'])->first();

            if ($validated['amount'] > $phone_number->balance)
                return $this->sudResponse(
                    ['your_balance' => $phone_number->balance, 'message' => 'your balance less than the amount']
                );
            $new_balance = $phone_number->balance - $validated['amount'];
            $gift_amount = $validated['amount'] - $validated['amount'] * 0.1;
            $target_new_balance = $target_phone_number->balance + $gift_amount;

            $phone_number->forceFill(['balance' => $new_balance]);
            $phone_number->update();

            $target_phone_number->forceFill(['balance' => $target_new_balance]);
            $target_phone_number->update();
            return $this->sudResponse('amount has been gifted to the provided number');
        });


    }
}

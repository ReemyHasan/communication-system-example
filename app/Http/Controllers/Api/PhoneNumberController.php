<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddTOBalanceRequest;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
class PhoneNumberController extends Controller
{
    use Responses;
    public function AddToBalance(AddTOBalanceRequest $request)
    {
        $validated = $request->validated();
        $phone_number = PhoneNumber::where('phone_number',$validated['phone_number'])->first();
        $new_balance = $phone_number->balance + $validated['amount'];
        $phone_number->forceFill(['balance'=> $new_balance ]);
        $phone_number->update();
        return $this->sudResponse('amount has been added to the provided number');

    }

    public function myPhoneNumbers(Request $request)
    {
        $user = PhoneNumber::where('phone_number',$request['phone_number'])->first()->user;
        $phone_numbers = $user->phoneNumbers->pluck('balance','phone_number');
        return $this->indexOrShowResponse('phone_numbers',['count'=>$phone_numbers->count(),'phone_numbers'=>$phone_numbers]);

    }
    public function getMyBalance(Request $request)
    {
        $balance = PhoneNumber::where('phone_number',$request['phone_number'])->first('balance');
        return $this->indexOrShowResponse('your balance',$balance);

    }

}

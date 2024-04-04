<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddTOBalanceRequest;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Responses;
    public function AddToBalance(AddTOBalanceRequest $request)
    {
        // should be secure but here for testing purposes
        $validated = $request->validated();
        $phone_number = PhoneNumber::where('phone_number',$validated['phone_number'])->first();
        $new_balance = $phone_number->balance + $validated['amount'];
        $phone_number->forceFill(['balance'=> $new_balance ]);
        $phone_number->update();
        return $this->sudResponse('amount has been added to the provided number');

    }
}

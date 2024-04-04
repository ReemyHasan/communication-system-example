<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Responses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\send2FACode;
use App\Models\PhoneNumber;
use App\Notifications\SendTwoFactorCode;

class TwoFactorController extends Controller
{
    use Responses;
    public function send(send2FACode $request)
    {
        $validated = $request->validated();
        $user = PhoneNumber::where('phone_number',$validated['phone_number'])->first()->user;
        $user->generateTwoFactorCode();
        $user->notify(new SendTwoFactorCode());
        return $this->sudResponse('Code has been sent');
    }
}

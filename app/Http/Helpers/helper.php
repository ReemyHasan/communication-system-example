<?php

use App\Models\PhoneNumber;
use Illuminate\Http\Request;

function verify(Request $request)
{
    $validated = $request->validate([
        'phone_number' => 'required|string|exists:phone_numbers,phone_number',
        'two_factor_code' => ['integer', 'required']
    ]);
    $user = PhoneNumber::where('phone_number', $validated['phone_number'])->first()->user;
    if ($user->two_factor_expires_at < now()) {
        $user->resetTwoFactorCode();
        return false;
    }
    if ($request->input('two_factor_code') !== $user->two_factor_code)
        return false;
    return true;
}

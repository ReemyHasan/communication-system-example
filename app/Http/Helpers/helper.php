<?php

use App\Models\PhoneNumber;
use Illuminate\Http\Request;

function verify(Request $request)
{
    $validated = $request->validate([
        'phone_number' => 'required|string|exists:phone_numbers,phone_number',
        'two_factor_code' => ['integer', 'required']
    ]);
    $phone_number = PhoneNumber::where('phone_number', $validated['phone_number'])->first();
    if ($phone_number->two_factor_expires_at < now()) {
        $phone_number->resetTwoFactorCode();
        return false;
    }
    if ($request->input('two_factor_code') !== $phone_number->two_factor_code)
        return false;
    return true;
}

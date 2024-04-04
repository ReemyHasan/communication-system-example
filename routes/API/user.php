<?php
use App\Http\Controllers\Api\PhoneNumberController;
use App\Http\Controllers\Api\TwoFactorController;
use Illuminate\Support\Facades\Route;



Route::post('buy_phone_number', [PhoneNumberController::class,'buyMobileNumber']);
Route::post('send2FA', [TwoFactorController::class,'send']);


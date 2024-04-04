<?php
use App\Http\Controllers\Api\TwoFactorController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;



Route::post('buy_phone_number', [UserController::class,'buyMobileNumber']);
Route::post('send2FA', [TwoFactorController::class,'send']);


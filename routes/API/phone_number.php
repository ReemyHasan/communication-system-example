<?php

use App\Http\Controllers\Api\PhoneNumberController;
use Illuminate\Support\Facades\Route;


Route::post('add_to_balance', [PhoneNumberController::class,'AddToBalance']);
Route::get('my_phone_numbers', [PhoneNumberController::class,'myPhoneNumbers']);
Route::get('get_my_balance', [PhoneNumberController::class,'getMyBalance']);
Route::Post('gift_units', [PhoneNumberController::class,'Gift']);





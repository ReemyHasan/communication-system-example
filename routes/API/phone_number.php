<?php

use App\Http\Controllers\Api\PhoneNumberController;
use Illuminate\Support\Facades\Route;

Route::post('buy_phone_number', [PhoneNumberController::class,'buyMobileNumber']);



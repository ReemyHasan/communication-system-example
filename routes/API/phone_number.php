<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('add_to_balance', [UserController::class,'AddToBalance']);


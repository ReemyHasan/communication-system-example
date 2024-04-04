<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$dev_path = __DIR__ . '/API/';

Route::prefix('v1/')->group(function () use ($dev_path) {

    Route::middleware('twofactor')->group(function () use ($dev_path) {
        include "{$dev_path}services.php";
        include "{$dev_path}offers.php";
        include "{$dev_path}phone_number.php";

    });
    include "{$dev_path}user.php";

});

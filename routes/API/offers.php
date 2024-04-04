<?php

use App\Http\Controllers\Api\OfferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('services/{service}/offers', OfferController::class)->only('show');



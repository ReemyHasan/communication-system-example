<?php

use App\Http\Controllers\Api\OfferController;
use Illuminate\Support\Facades\Route;

Route::apiResource('services/{service}/offers', OfferController::class)->only('show');
Route::get('services/{service}/offers/{offer}/deactivate',[OfferController::class,'deactivateOffer']);
Route::get('offers/deactivate_all',[OfferController::class,'deactivateAllOffers']);
Route::get('services/{service}/offers/{offer}/activate',[OfferController::class,'activateOffer']);




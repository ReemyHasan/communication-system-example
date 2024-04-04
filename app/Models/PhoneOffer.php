<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneOffer extends Model
{
    use HasFactory;

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function phone_number()
    {
        return $this->belongsTo(PhoneNumber::class);
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleted(function ($phoneOffer) {
    //         // Check if it's the last phone_offer related to the offer
    //         $relatedOffersCount = $phoneOffer->offer->phoneOffers()->count();

    //         if ($relatedOffersCount === 0 && $phoneOffer->offer->trashed()) {
    //             // If it's the last phone_offer and offer is soft-deleted, permanently delete the offer
    //             $phoneOffer->offer->forceDelete();
    //         }
    //     });
    // }
}

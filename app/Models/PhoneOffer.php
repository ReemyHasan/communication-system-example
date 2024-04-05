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
}

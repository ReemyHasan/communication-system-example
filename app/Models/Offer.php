<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $appends = ['duration'];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // public function phoneOffers()
    // {
    //     return $this->hasMany(PhoneOffer::class);
    // }

    public function getDurationAttribute()
    {
        $duration = $this->duration_in_hours;

        $days = floor($duration / 24);
        $hours = $duration % 24;

        $durationString = '';

        if ($days > 0) {
            $durationString .= $days . ' day(s)';
        }

        if ($hours > 0) {
            $durationString .= $hours . ' hour(s)';
        }

        return $durationString;
    }
}

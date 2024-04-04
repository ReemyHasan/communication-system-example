<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phoneOffers()
    {
        return $this->hasMany(PhoneOffer::class);
    }
    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;
        $two_factor_code = rand(100000, 999999);
        $two_factor_expires_at = now()->addMinutes(10);
        $this->forceFill(['two_factor_code'=>$two_factor_code,'two_factor_expires_at'=>$two_factor_expires_at]);
        $this->save();
    }
    public function resetTwoFactorCode(): void
    {
        $this->timestamps = false;
        $two_factor_code = null;
        $two_factor_expires_at = null;
        $this->forceFill(['two_factor_code'=>$two_factor_code,'two_factor_expires_at'=>$two_factor_expires_at]);
        $this->save();
    }
}

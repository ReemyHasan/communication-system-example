<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];


    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function setFullNameAttribute($value)
    {
        $parts = explode(' ', strtolower($value));
        $formattedName = implode('.', $parts);

        $this->attributes['full_name'] = $formattedName;
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

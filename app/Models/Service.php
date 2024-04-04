<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public const SERVICE_070 = '070';
    public const SERVICE_999 = '999';
    public const SERVICE_1111 = '1111';
    public const SERVICE_606 = '606';
    public const SERVICE_666 = '666';

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'street_address',
        'locality',
        'city_town_village',
        'district',
        'state',
        'pin_code'
    ];

    public function addressable()
    {
        $this->morphTo();
    }
}

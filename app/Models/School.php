<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'is_active'
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }
}

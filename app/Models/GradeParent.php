<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeParent extends Model
{
    protected $fillable = [
        'name'
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

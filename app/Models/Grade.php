<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'name',
        'grade_parent_id',
        'is_active'
    ];

    public function parent()
    {
        return $this->belongsTo(GradeParent::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
}

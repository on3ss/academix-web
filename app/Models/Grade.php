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

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function grade_parent()
    {
        return $this->belongsTo(GradeParent::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class);
    }
}

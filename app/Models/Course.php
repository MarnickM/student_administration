<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function scopeSearchNameOrDescription($query, $search = '%') // this function will replace the duplicate code
        // used in the shop.php
    {
        return $query->where('description', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%");
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class)->withDefault();
    }

    public function studentcourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}

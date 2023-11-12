<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function programme()
    {
        return $this->belongsTo(Programme::class)->withDefault();
    }
    public function studentcourses()
    {
        return $this->hasMany(StudentCourse::class);
    }
}

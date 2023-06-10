<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'year',
        'semester',
        'program',
        'status',
        'level',
        'registered_at'
    ];
}

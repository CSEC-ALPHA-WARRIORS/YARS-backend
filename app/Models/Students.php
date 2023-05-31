<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StudentTypeEnum;

class Students extends Model
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'mname',
        'lname', 
        'profile_picture_url',
        'email', 
        'phonenumber',
        'password',
        'type'
    ];
    protected $casts = [
        'type' => StudentTypeEnum::class
    ];
}

?>
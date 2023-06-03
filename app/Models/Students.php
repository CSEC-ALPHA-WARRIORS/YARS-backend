<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StudentTypeEnum;
use Laravel\Sanctum\HasApiTokens;

class Students extends Model
{
    use HasFactory, HasApiTokens;
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
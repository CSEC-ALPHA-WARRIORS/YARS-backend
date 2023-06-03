<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AdminRoleEnum;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'fname',
        'mname',
        'lname', 
        'email', 
        'phonenumber',
        'password',
        'role'
    ];
    protected $casts = [
        'role' => AdminRoleEnum::class
    ];
}

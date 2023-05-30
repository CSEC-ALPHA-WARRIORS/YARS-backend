<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AdminRoleEnum;

class Admin extends Model
{
    use HasFactory;

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

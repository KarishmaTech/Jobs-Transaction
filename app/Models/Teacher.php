<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

     protected $fillable = [

    	'name', 
        'email',
        'password',
        'father_name',
        'class',
        'roll_number',
        'phone',
        'image',];
    protected $hidden = ['password'];
}

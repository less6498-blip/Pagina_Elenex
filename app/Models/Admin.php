<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['nombre', 'email', 'password'];
    protected $hidden   = ['password'];
}
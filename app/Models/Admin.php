<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use HasRoles, HasFactory, Notifiable;
    protected $table = 'admins';
    protected $fillable = [ 'email', 'password'];
}

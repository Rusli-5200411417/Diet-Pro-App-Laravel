<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    protected $table = 'roles';
    use HasFactory, HasFactory, Notifiable;

    protected $fillable = [
    'tipe_roles'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * User class represents the data structure of a user
 */

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'firstName',
        'email',
        'lastName',
    ];
}

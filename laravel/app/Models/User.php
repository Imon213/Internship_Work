<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";

    protected $primaryKey = 'users_id';

    protected $fillable = [
        'users_name',
        'users_email',
        'password',
        'users_username',
        'users_phone',
        'users_status',
        'users_social_profile',
        'users_social_id',
        'users_division_id',
        'users_district_id',
        'users_area_id',
        'users_track_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = 'users_id';
}

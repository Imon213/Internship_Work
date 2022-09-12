<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModel extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $guard = 'admin';

    protected $table = "admins";

    protected $primaryKey = 'admins_id';

    protected $guarded = ['admins_id'];

    protected $fillable = [
        'admins_track_id', 
        'admins_name',
        'admins_email',
        'admins_type',  
        'password',
        'admins_username', 
        'admins_mobile', 
        'admins_status', 
        'admins_division_id',
        'admins_district_id', 
        'admins_area_id', 
        'admins_address',          
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

  
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "areas";

    protected $primaryKey = 'areas_id';

    protected $fillable = [
        'areas_track_id',
        'areas_division_id',
        'areas_district_id',
        'areas_name',
        'areas_status',
    ];

    protected $guarded = 'areas_id';
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "districts";

    protected $primaryKey = 'districts_id';

    protected $fillable = [
        'districts_track_id',
        'districts_name',
        'districts_short_name',
        'districts_division_id',
        'districts_status',
    ];

    protected $guarded = 'districts_id';
}

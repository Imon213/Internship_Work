<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class DivisionModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "divisions";

    protected $primaryKey = 'divisions_id';

    protected $fillable = [
        'division_track_id',
        'division_name',
        'division_short_name',
        'division_status',
    ];

    protected $guarded = 'divisions_id';
}

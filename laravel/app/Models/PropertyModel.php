<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PropertyModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "properties";

    protected $primaryKey = 'properties_id';

    protected $fillable = [
        'properties_track_id',
        'properties_category_id',
        'properties_subcategory_id',
        'properties_name',
        'properties_status',
    ];

    protected $guarded = 'properties_id';
}

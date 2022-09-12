<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "categories";

    protected $primaryKey = 'categories_id';

    protected $fillable = [
        'categories_track_id',
        'categories_name',
        'categories_status',
        'categories_picture',
        'categories_icon',
    ];

    protected $guarded = 'categories_id';
}

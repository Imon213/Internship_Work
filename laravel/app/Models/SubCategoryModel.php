<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "subcategories";

    protected $primaryKey = 'subcategories_id';

    protected $fillable = [
        'subcategories_track_id',
        'subcategories_category_id',
        'subcategories_name',
        'subcategories_status',
        'subcategories_icon',
    ];

    protected $guarded = 'subcategories_id';
}

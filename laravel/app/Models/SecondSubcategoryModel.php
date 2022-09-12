<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SecondSubcategoryModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "second_subcategories";

    protected $primaryKey = 'second_subcategories_id';

    protected $fillable = [
        'second_subcategories_track_id',
        'second_subcategories_category_id',
        'second_subcategories_subcategories_id',
        'second_subcategories_name',
        'second_subcategories_status',
    ];

    protected $guarded = 'second_subcategories_id';
}

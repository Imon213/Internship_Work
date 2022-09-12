<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "product_image";

    protected $primaryKey = 'product_image_id';

    protected $fillable = [
        'product_image_track_id',
        'product_image_picture',
    ];

    protected $guarded = 'product_image_id';
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "reviews";

    protected $primaryKey = 'reviews_id';

    protected $fillable = [
        'reviews_track_id',
        'reviews_description',
        'reviews_percent',
        'reviews_users_id',
        'reviews_product_id',
        'reviews_status',
    ];

    protected $guarded = 'reviews_id';
}

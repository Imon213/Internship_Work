<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "comments";

    protected $primaryKey = 'comments_id';

    protected $fillable = [
        'comments_track_id',
        'comments_details',
        'comments_users_id',
        'comments_products_id',
        'comments_status',
    ];

    protected $guarded = 'comments_id';
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "messages";

    protected $primaryKey = 'messages_id';

    protected $fillable = [
        'messages_track_id',
        'messages_users_id',
        'messages_products_id',
        'messages_admins_id',
        'messages_email',
        'messages_heading',
        'messages_details',
        'messages_mobile',
        'messages_status',
    ];

    protected $guarded = 'messages_id';
}

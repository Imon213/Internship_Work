<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "products";

    protected $primaryKey = 'products_id';

    protected $fillable = [
        'products_track_id',
        'products_name',
        'products_mobile',
        'products_category_id',
        'products_subcategory_id',
        'products_second_subcategory_id',
        'products_division_id',
        'products_district_id',
        'products_area_id',
        'products_quantity',
        'products_property_id',
        'products_description',
        'products_price',
        'products_type',
        'products_view',
        'products_discount',
        'products_discount_price',
        'products_negotiable',
        'products_status',
        'products_users_id',
    ];

    protected $guarded = 'products_id';
}

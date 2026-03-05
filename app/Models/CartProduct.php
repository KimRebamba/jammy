<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'cart_product';
    protected $primaryKey = 'cart_product_id';
    public $timestamps = false;
    protected $guarded = [];
}

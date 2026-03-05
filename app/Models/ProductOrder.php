<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';
    protected $primaryKey = 'product_order_id';
    public $timestamps = true;
    protected $guarded = [];
}

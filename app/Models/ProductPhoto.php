<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $table = 'product_photos';
    protected $primaryKey = 'product_photo_id';
    public $timestamps = true;
    protected $guarded = [];
}

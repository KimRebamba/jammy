<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review';
    protected $primaryKey = 'review_id';
    public $timestamps = true;
    protected $guarded = [];
}

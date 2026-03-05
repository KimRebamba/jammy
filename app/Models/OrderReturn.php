<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $table = 'order_return';
    protected $primaryKey = 'order_return_id';
    public $timestamps = true;
    protected $guarded = [];
}

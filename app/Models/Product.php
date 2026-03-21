<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $timestamps = true;
    protected $guarded = [];

    public function toSearchableArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
        ];
    }
}

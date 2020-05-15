<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'nameProduct',
        'cost',
        'stock',
        'provider_id',
        'category_id'
    ];
    
}

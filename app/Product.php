<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'productCode', 'productDsc','vendor_id'
    ];

}

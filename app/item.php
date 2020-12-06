<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{

    protected $fillable = [
        'itemCode', 'itemDsc', 'product_id','in_stock','customer','customer_name','stock_out_date'
    ];

}

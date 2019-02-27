<?php

namespace Laravel;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
	protected $fillable = [
    	'order_id',
    	'product_id',
    	'quantity',
    	'total_price',
    	'total_weight'
    ];
    public function order(){
    	return $this->belongsTo('Laravel\Order');
    }

    public function product(){
        return $this->belongsTo('Laravel\Product');
    }
}

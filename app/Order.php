<?php

namespace Laravel;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'user_id',
    	'status',
    	'address',
    	'total_price',
    	'total_weight',
    	'shipping_fee',
    	'payment_key',
    	'total_payment'
    ];

    public function user(){
    	return $this->belongsTo('Laravel\User');
    }

    public function products(){
    	return $this->belongsToMany('Laravel\Product');
    }

    public function order_products(){
    	return $this->hasMany('Laravel\OrderProduct');
    }
}

<?php

namespace Laravel;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     protected $fillable = [
    	'user_id',
    	'product_id',
    	'quantity',
    ];

    public function user(){
    	return $this->belongsTo('Laravel\User');
    }

    public function product(){
    	return $this->belongsTo('Laravel\Product');
    }
}

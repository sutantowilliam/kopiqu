<?php

namespace Laravel;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
    	'name',
    	'description',
    	'stock',
    	'price',
    	'weight',
        'filepath'
    ];

    public function categories(){
    	return $this->belongsToMany('Laravel\Category');
    }

    public function carts(){
        return $this->hasMany('Laravel\Cart');
    }

    public function orders(){
    	return $this->belongsToMany('Laravel\Order');
    }
}

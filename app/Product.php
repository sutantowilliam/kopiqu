<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
    	'name',
    	'description',
    	'stock',
    	'price',
    	'weight'
    ];

    public function categories(){
    	return $this->belongsToMany('App\Category');
    }

    public function carts(){
        return $this->hasMany('App\Cart');
    }

    public function orders(){
    	return $this->belongsToMany('App\Order');
    }
}

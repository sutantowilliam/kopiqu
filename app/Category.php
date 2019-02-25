<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
    	'name',
    	'parent_id',
    ];

    public function products(){
    	return $this->belongsToMany('App\Product');
    }

    // public function category_products(){
    // 	return $this->hasMany('App\CategoryProduct');
    // }
}

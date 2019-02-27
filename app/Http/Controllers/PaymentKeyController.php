<?php

namespace Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\PaymentKey;

class PaymentKeyController extends Controller
{
    function unuse(Request $request){
    	$id = $request['payment_key_id'];
    	$order 
    	PaymentKey::find($id)->update(['used'=>0]);
    }
}

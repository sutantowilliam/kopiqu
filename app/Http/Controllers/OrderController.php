<?php

namespace Laravel\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cart;
use Laravel\Order;
use Laravel\OrderProduct;
use Laravel\PaymentKey;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('order.index')->with(compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_key = PaymentKey::where('used',0)->first();
        $payment_key->update(['used'=>1]); 
        $address = $request['address'];
        $user_id = $request['user_id'];
        $carts = Cart::where('user_id',$user_id)->get();
        $total_price = 0;
        $total_weight = 0;
        $order = Order::create(['user_id'=>$user_id, 'status'=>'PENDING', 'address'=>$address, 'total_price'=>$total_price, 'total_weight'=>$total_weight, 'shipping_fee'=>0,'payment_key'=>$payment_key->key,'total_payment'=>0]);

        foreach($carts as $cart) {
            $total_price += $cart->quantity*$cart->product->price;
            $total_weight += $cart->quantity*$cart->product->weight;
            $order_product = OrderProduct::create(['order_id'=>$order->id,'product_id'=>$cart->product->id,'quantity'=>$cart->quantity,'total_price'=>$total_price,'total_weight'=>$total_weight]); 
            // $order_product = OrderProduct::create(['order_id'=>1,'product_id'=>1,'quantity'=>5,'total_price'=>5000,'total_weight'=>12]); 
            $cart->destroy($cart->id);
        }
        $shipping_fee = $total_weight*5000;
        $total_payment = $shipping_fee+$total_price; 
        $order->update(['total_price'=>$total_price,'total_weight'=>$total_weight]);
        // return Response([$user_id,$address,$total_price,$total_weight,$shipping_fee,$payment_key,$total_payment]);
        return Response(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

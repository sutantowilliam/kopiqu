<?php

namespace Laravel\Http\Controllers;

use Laravel\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
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
        $carts = Cart::where('user_id', Auth::user()->id)->get()->load('product','product.product_pictures');
        return view('cart.index')->with(compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', $request['user_id'])->where('product_id', $request['product_id'])->first();
        if (isset($cart)) {
            $cart->update(['quantity' => $cart->quantity+$request['quantity']]);
        } else{
            $cart = Cart::create(['user_id' =>$request['user_id'], 'product_id' => $request['product_id'], 'quantity' =>$request['quantity']]);
        }
        return response(204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Laravel\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Laravel\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Laravel\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

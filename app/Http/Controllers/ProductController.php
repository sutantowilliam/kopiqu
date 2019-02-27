<?php

namespace Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Product;

class ProductController extends Controller
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
        
    }

    public function admin()
    {
        $products = Product::all();
        return view('products.admin')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $description = $request['description'];
        $weight = (float) $request['weight'];
        $price = (float) $request['price'];
        // $product = Product::create($request->all());
        // $product = Product::create(['name'=>'asa']);
        $product = Product::create(['stock'=>100, 'file_path'=>'test.jpg','name'=>$name,'description'=>$description,'weight'=>$weight,'price'=>$price]);
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
        $product = Product::find($id);
        return view('products.edit')->with(compact('product'));
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
        $name = $request['name'];
        $description = $request['description'];
        $weight = (float) $request['weight'];
        $price = (float) $request['price'];
        $product = Product::find($id)->update(['name'=>$name,'description'=>$description,'weight'=>$weight,'price'=>$price]);
        return Response(200);
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

@extends('layouts.app')

@section('header')
<style>
.card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
</style>
@endsection

@section('content')
<div class="row" style="padding: 15px;">
	@foreach($products as $product)
	<div class="col-lg-3 d-flex m5">
		<div class="card h-80" style="width: 200px">
		  	<img class="card-img-top img-fluid" src="{{ asset('img/'.$product->filepath) }}" alt="">
		  	<div class="card-body">
				<h5 class="card-title">{{$product->name}}</h5>
				<p class="card-text">{{$product->desc}}</p>
				<p class="card-text">{{$product->price}}</p>
				<p class="card-text">{{$product->weight}}</p>
				<a href="#" class="btn btn-primary">Add to Cart</a>
			</div>
		</div>
	</div>
	@endforeach
</div>
	</div>
</div>
	@endsection
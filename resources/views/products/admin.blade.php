@extends('layouts.app')

@section('header')
<style>
.product-img {
	width: 100px;
	height: 100px;
	object-fit: cover;
}
.category-title {
	color: white;
}
.btn {
	display: block;
	margin: auto;
	float:right;
}
th {
	text-align: center;
}
.qty {
	width:50px;
}
.form-opt{
	width: 120px;
}
.add-button {
	padding: 10px;
	font-size: 20px;
}
</style>
@endsection

@section('content')
<div class="container">
	<div class="d-flex flex-row my-3 justify-content-between">
		<div>
		<h1 class="category-title" >PRODUCT LIST</h1>
		</div>
		<div>
		<button id="add-product" class="add-button btn btn-success">Add Product</button>
		</div>
	</div>
	
	@if(count($products)==0)
	<div class="container bg-light p-3 my-3">
	There is no products 
	</div>
	@else
	<div class="container">
	<table class="table table-light table-bordered">
		<thead>
			<tr class="table-secondary">
				<th scope="col"></th>
				<th scope="col">ID</th>
				<th scope="col">Name</th>
				<th scope="col">Description</th>
				<th scope="col">Weight</th>
				<th scope="col">Price</th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td style="text-align: center"><img class="product-img" src="{{ asset('img/'.$product->filepath) }}" alt=""></td>
				<td class="text">{{$product->id}}</td>
				<td class="text-right">{{$product->name}}</td>
				<td class=" text-right">{{$product->description}}</td>
				<td class=" text-right">{{$product->weight}}</td>
				<td class=" text-right">{{$product->price}}</td>
				<td><button id="edit-{{$product->id}}" onclick="window.location.replace('{{route('products.edit', $product->id) }}')" class="btn btn-primary">Edit</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	@endif
</div>


@endsection


@section('footer')
<script>
$('document').ready(function(){
	$('#add-product').click(function(e){
		console.log("asa");
			window.location.replace("{{route("products.create")}}");
		});
})
</script>
@endsection

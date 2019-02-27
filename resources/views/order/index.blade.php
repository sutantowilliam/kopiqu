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
</style>
@endsection

@section('content')
<div class="container">
	<div class="container my-3">
		<h1 class="category-title" >YOUR ORDER</h1>
	</div>
	@if(count($orders)==0)
	<div class="container bg-light p-3 my-3">
	You have no order 
	</div>
	@else
	<div class="container">
	<table class="table table-light table-bordered">
		<thead>
			<tr class="table-secondary">
				<th scope="col">Product</th>
				<th scope="col">Address</th>
				<th scope="col">Total Product Price</th>
				<th scope="col">Total Product Weight</th>
				<th scope="col">Shippping Fee (5000/kg)</th>
				<th scope="col">Payment Key</th>
				<th scope="col">Total Payment</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
			<tr>
				<td class="col">
				@foreach($order->order_products as $product)
				aa{{$product}}
					<span>{{$product->name}}</span><br/>
				}
				@endforeach
				</td>
				<td class="">{{$order->address}}</td>
				<td class="text-right">{{$order->total_price}}</td>
				<td class=" text-right">{{$order->total_weight}}</td>
				<td class=" text-right">{{$order->shipping_fee}}</td>
				<td class=" text-right">-{{$order->payment_key}}</td>
				<td class=" text-right">{{$order->total_payment}}</td>
				<td class=" text-right">{{$order->status}}</td>
				@endforeach
			</tr>
		</tbody>
	</table>
	</div>
	@endif
</div>


@endsection


@section('footer')
<script>

</script>
@endsection

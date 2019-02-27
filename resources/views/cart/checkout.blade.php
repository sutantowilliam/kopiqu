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
		<h1 class="category-title" >CHECK OUT</h1>
	</div>
	@if(count($carts)==0)
	<div class="container bg-light p-3 my-3">
	Your shopping cart is empty
	</div>
	@else
	<div class="container bg-light p-3 my-3">
	<table class="table table-light table-bordered">
		<thead>
			<tr class="table-secondary">
				<th scope="col">Product Name</th>
				<th scope="col">Weight</th>
				<th scope="col">Price</th>
				<th scope="col">Quantity</th>
				<th scope="col">Subtotal Weight</th>
				<th scope="col">Subtotal Price</th>
			</tr>
		</thead>
		<tbody>
			@php
			   	$total_weight = 0;
				$total_price = 0; 
			@endphp
			@foreach($carts as $cart)
			<tr>
				<td class="col font-weight-bold">{{$cart->product->name}}</td>
				<td id="weight-{{$cart->id}}"class="text-right">{{$cart->product->weight}}</td>
				<td id="price-{{$cart->id}}" class="text-right">{{$cart->product->price}}</td>
				<td class=" text-right">{{$cart->quantity}}</td>
				@php
					$subtotal_weight = $cart->product->weight*$cart->quantity; 
					$subtotal_price = $cart->product->price*$cart->quantity;
				    $total_weight += $subtotal_weight;
				    $total_price += $subtotal_price;
				@endphp
				<td id="subtotal-weight-{{$cart->id}}" class="text-right">{{$subtotal_weight}}</td>
				<td id="subtotal-price-{{$cart->id}}" class="text-right">{{$subtotal_price}}</td>
				@endforeach
			</tr>
			<tr>
				<td colspan="5" class=" text-right">Subtotal</td>
				<td id = 'total-price' class="font-weight-bold text-right">{{$total_price}}</td>
			</tr>
			<tr>
				<td colspan="5" class=" text-right">Shipping Fee (5000x{{$total_weight}})</td>
				@php
					$shipping_fee = 5000*$total_weight;
				@endphp
				<td id = 'shipping-fee' class="font-weight-bold text-right">{{$shipping_fee}}</td>
			</tr>
			<tr class="table-secondary">
				<td colspan="5" class="font-weight-bold text-right">GRAND TOTAL</td>
				@php
					$payment_total = $shipping_fee+$total_price;
				@endphp
				<td id = 'shipping-fee' class="font-weight-bold text-right">{{$payment_total}}</td>
			</tr>
		</tbody>
	</table>
	</div>
	<div class=" bg-light center p-3 my-3 d-flex flex-column" >
		<form>
			<div class="form-group">
			    <label class="font-weight-bold" for="address-label">Shipping Adress</label>
			    <input type="text" class="form-control" id="address-input" placeholder="Type your shipping adress ... ">	    
			    <div class="invalid-feedback">
		          Please type your shipping address
		        </div>
			</div>	  
		</form>
		<button id="order-button" type="submit" class="btn btn-success mb-2">ORDER</button>
	</div>
	@endif
</div>


@endsection


@section('footer')
<script>
	$('document').ready(function(){
		// $('#change-button').click(function(e){
		// 	console.log("as");
		// });
        $("#order-button").click(function(e) {
        @guest
            window.location.replace("{{ route('login')}}");
        @else
	        var address = $('#address-input');
            if (address.val()!="") {
            	$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
	               	type: "POST",
	               	url: '{{ route("orders.store")}}',
	               	data: {
	                	address: address.val(),
	                    user_id: "{{Auth::user()->id}}",
	               	},
	               	success: function(data)
	               	{
	                  	console.log(data);
	                  	window.location.replace("{{route('orders.index')}}")
	               	},
	               	failed: function(data){
	                   console.log(data);
	               	}
	            });

            } else {
				address.addClass("is-invalid");
            }
        @endguest
        e.preventDefault();
        });
    });
</script>
@endsection

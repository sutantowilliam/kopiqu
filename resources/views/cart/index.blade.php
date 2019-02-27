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
	<div class="container p-3 my-3">
		<h1 class="category-title" >SHOPPING CART</h1>
	</div>
	@if(count($carts)==0)
	<div class="container bg-light p-3 my-3">
	Your shopping cart is empty
	</div>
	@else
	<div class="container">
	<table class="table table-light">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col"></th>
				<th scope="col">Product Name</th>
				<th scope="col">Unit Weight</th>
				<th scope="col">Unit Price</th>
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
				<td><button id="delete-{{$cart->id}}" class="btn btn-danger">x</button></td>
				<td style="text-align: center"><img class="product-img" src="{{ asset('img/'.$cart->product->filepath) }}" alt=""></td>
				<td><div class="container">
					<div class="col font-weight-bold">{{$cart->product->name}}</div>
					<div class="col">{{$cart->product->description}}</div>
				</div></td>
				<td id="weight-{{$cart->id}}"class="text-right">{{$cart->product->weight}}</td>
				<td id="price-{{$cart->id}}" class="text-right">{{$cart->product->price}}</td>
				<td class=" text-right"><input id="qty-{{$cart->id}}"class="qty text-center" onchange="calculateTotal({{$cart->id}})" type="number" name="quantity" min="1" value={{$cart->quantity}}></td>
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
				<td colspan="6" class="font-weight-bold text-right">TOTAL</td>
				<td id = 'total-weight' class="font-weight-bold text-right">{{$total_weight}}</td>
				<td id = 'total-price' class="font-weight-bold text-right">{{$total_price}}</td>
			</tr>
			<tr>
				<td colspan="8" class="text-right">
					<form id='form-check-out'>
						<button id="check-out" class="btn btn-success">Proceed to Check Out</button>
					</form>
			</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
	@endif
</div>


@endsection


@section('footer')
<script>
    $('document').ready(function(){
        $("[id^='delete-']").click(function(e) {
        @guest
            window.location.replace("{{ route('login')}}");
        @else
            var form = $(this);
            var url = form.attr('action');
            var id = $(this).attr('id').split('-')[1];
            // console.log(id);
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
               type: "DELETE",
               url: "cart/"+id,
               success: function(result)
               {
                  location.reload();
               },
               failed: function(xhr){
                  console.log(xhr.status);
               }
             });
            @endguest
        e.preventDefault();
        });

        $("#check-out").click(function(e){
        	var stringData = getCarts();
        	$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
	           	type: "POST",
	           	url: "{{route('cart.update_many')}}",
	           	data: {
	                cart_data: stringData,
	            },
	           	success: function(data)
	           	{
	              window.location.replace("{{route('cart.checkout')}}");
	           	},
	           	failed: function(xhr){
	            	console.log(xhr.status);
	           	}
	        });
        });
    })

	function calculateTotal(id) {
		var qty = $("#qty-"+id).val();
        var price = parseFloat($("#price-"+id).text());
        var weight = parseFloat($("#weight-"+id).text());
        var old_subtotal_price = parseFloat($("#subtotal-price-"+id).text());
        var old_subtotal_weight = parseFloat($("#subtotal-weight-"+id).text());
        var old_total_price = parseFloat($("#total-price").text());
        var old_total_weight = parseFloat($("#total-weight").text());

        var new_subtotal_price = qty*price;
        var new_subtotal_weight = qty*weight;
        var new_total_price = old_total_price-old_subtotal_price+new_subtotal_price;
        var new_total_weight = old_total_weight-old_subtotal_weight+new_subtotal_weight;
        $("#subtotal-price-"+id).text(new_subtotal_price);
        $("#subtotal-weight-"+id).text(new_subtotal_weight);
        $("#total-price").text(new_total_price);
        $("#total-weight").text(new_total_weight);

	}  
	function getCarts() {
		var carts = document.getElementsByClassName("qty");
		var length = carts.length;
		var cart_json = new Object();
		var cart_array = [];
		for (var i=0; i<length;i++) {
			var id = carts[i].id.split('-')[1];
			var element = new Object();
			element.cart_id = id;
			element.quantity = parseInt(carts[i].value);
			cart_array.push(element);
		}
		cart_json.data = cart_array;
		var stringData = JSON.stringify( cart_json );
		return stringData;
		
	}
	$( window ).bind('beforeunload', function()
	{
		var stringData = getCarts();
		console.log(stringData);
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
		   	type: "POST",
		   	url: "{{route('cart.update_many')}}",
		   	data: {
		        cart_data: stringData,
		    },
		   	success: function(data)
		   	{
		      console.log(data);
		   	},
		   	failed: function(xhr){
		    	console.log(xhr.status);
		   	}
		});
	});
</script>
@endsection

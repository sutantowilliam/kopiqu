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
	<div class="container">
		<h1 class="category-title" >SHOPPING CART</h1>
	</div>
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
				<td class=" text-right"><input id="qty-{{$cart->id}}"class=" qty text-center" onchange="calculateTotal({{$cart->id}})" type="number" name="quantity" min="1" value={{$cart->quantity}}></td>
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
				<button id="check-out" class="btn btn-success">Proceed to Check Out</button>

			</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>
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
            console.log(id);
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
    })

	function calculateTotal(id) {
		var qty = $("#qty-"+id).val();
        var price = parseFloat($("#price-"+id).text());
        var weight = parseFloat($("#weight-"+id).text());
        var old_subtotal_price = parseFloat($("#subtotal-price-"+id).text());
        var old_subtotal_weight = parseFloat($("#subtotal-weight-"+id).text());
        var old_total_price = parseFloat($("#total-price").text());
        var old_total_weight = parseFloat($("#total-weight").text());
        console.log(old_subtotal_weight,old_subtotal_price,old_total_weight,old_total_price);
        var new_subtotal_price = qty*price;
        var new_subtotal_weight = qty*weight;
        var new_total_price = old_total_price-old_subtotal_price+new_subtotal_price;
        var new_total_weight = old_total_weight-old_subtotal_weight+new_subtotal_weight;
        var total_weight = $("#total-weight");
        $("#subtotal-price-"+id).text(new_subtotal_price);
        $("#subtotal-weight-"+id).text(new_subtotal_weight);
        $("#total-price").text(new_total_price);
        $("#total-weight").text(new_total_weight);

	}  
</script>
@endsection

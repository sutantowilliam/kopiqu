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
</style>
@endsection

@section('content')
<div class="container">
	<div class="container my-3">
		<h1 class="category-title" >ORDER</h1>
	</div>
	@if(count($orders)==0)
	<div class="container bg-light p-3 my-3">
	There is no order 
	</div>
	@else
	<div class="container">
	<table class="table table-light table-bordered">
		<thead>
			<tr class="table-secondary">
				<th scope="col">Order Date</th>
				<th scope="col">Product Name</th>
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
				
				<td class="text-right">{{$order->created_at}}</td>
				<td>
					@foreach($order->order_products as $product)
			          	{{ $product->product->name }} ({{ $product->quantity }})<br/>
			         @endforeach
				</td>
				
				<td class="text">{{$order->address}}</td>
				<td class="text-right">{{$order->total_price}}</td>
				<td class=" text-right">{{$order->total_weight}}</td>
				<td class=" text-right">{{$order->shipping_fee}}</td>
				<td class=" text-right">-{{$order->payment_key}}</td>
				<td class=" text-right">{{$order->total_payment}}</td>
				<td class=" text-right">
					<form id="form-{{$order->id}}">
			          	<span id="status-{{$order->id}}">{{$order->status}}</span>
			          	<select class="form-opt form-control my-1 " name="status">
			              	<option {{$order->status == 'PAID' ? 'selected' : ''}}>PAID</option>
			              	<option {{$order->status == 'SHIPPED' ? 'selected' : ''}}>SHIPPED</option>
			          	</select>
			          	<button style=""class="btn btn-primary">Update</button>
			        </form>
				</td>
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
$('document').ready(function(){
        $("[id^='form-']").submit(function(e) {
        @guest
            window.location.replace("{{ route('login')}}");
        @else
            var form = $(this);
            var id = $(this).attr('id').split('-')[1];
            var url = "/orders/"+id;

            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
               type: "PUT",
               url: url,
               data: {
                    status: form.find('select').val()
               },
               success: function(data)
               {
                    form.find('#status-'+id).text(form.find('select').val());
                    console.log(data);
               },
               failed: function(data){
                   console.log(data);
               }
             });
        @endguest
        e.preventDefault();
        });
    })
</script>
@endsection

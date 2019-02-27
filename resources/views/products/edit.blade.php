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
		<h1 class="category-title" >EDIT PRODUCT</h1>
	</div>
	
	<div class=" bg-light center p-3 my-3 d-flex flex-column" >
			<form>
				<div class="form-group">

				    <label class="font-weight-bold">Name</label>
				    <input type="text" class="form-control" id="name-input" value='{{$product->name}}'>	    
				    <div class="invalid-feedback">
			          Please fill product name
			        </div>
			        <label class="font-weight-bold">Description</label>
				    <input type="text" class="form-control" id="description-input"  value='{{$product->description}}'>	    
				    <div class="invalid-feedback">
			          Please fill product description
			        </div>
			        <label class="font-weight-bold">Weight</label>
				    <input type="number" min=0.1 step="any" class="form-control" id="weight-input"  value='{{$product->weight}}'>
				    <div class="invalid-feedback">
			          Please fill product weight
			        </div>
			        <label class="font-weight-bold">Price</label>
				    <input type="number" min=100 class="form-control" id="price-input"  value='{{$product->price}}'>	    
				    <div class="invalid-feedback">
			          Please fill product price
			        </div>
			        <label class="font-weight-bold">Picture</label>
				</div>	  
			</form>
			<button id="add-button" class="btn btn-success mb-2">UPDATE</button>
		</div>
</div>


@endsection


@section('footer')
<script>
$('document').ready(function(){
	$('#add-button').click(function(e){
        var name = $('#name-input').val();
        var description = $('#description-input').val();
        var weight =$('#weight-input').val() ;
        var price = $('#price-input').val();
        console.log(name,description,weight,price);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
           	type: "PUT",
        	url: "{{route('products.update',$product->id)}}", 
        	data: {
        		name : name,
        		description:description,
        		weight:weight,
        		price:price,
        	},
           	success: function(result)
           	{
           		console.log(result);
              	// location.reload();
           	},
           	failed: function(xhr){
            	console.log(xhr.status);
           	}
        });
        e.preventDefault();
        });
})
</script>
@endsection

@extends('layouts.app')

@section('header')
<style>
.card-img-top {
    object-fit: cover;
}
.card-text {
    font-size:0.8rem;
}
.card {
    margin:0.3rem;
}
.success-alert {
  position: fixed;
  z-index: 7000;
}
.category-title {
    color: white;
}
</style>
@endsection

@section('content')
<div class="container" id="product-list">
    <div class="d-flex p-3 flex-wrap justify-content-between">
        <h1 class="category-title" >Category: {{$category->name}}</h1>
    </div>
    <div class="row d-flex" style="padding: 15px;">
        @foreach($products as $product)
        <div class="col-sm-3 p-3">
            <div class="card" style="height: 400px" >
                <img class="card-img-top" src="{{ asset('img/'.$product->filepath) }}" alt="", style="height: 40%">
                <div class="card-body d-flex flex-column justify-content-between" >
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text" >{{$product->description}}</p>
                    <div class="row">
                        <div class="col">
                            <strong>Rp.{{$product->price}}</strong>
                        </div>
                        <div class="col">
                            <span>{{$product->weight}}kg</span>
                        </div>
                    </div>
                    <div class="mt-auto">
                    <form id="form-{{$product->id}}">
                        @csrf
                        <div class="form-row align-items-center" style="margin-bottom: auto">
                            <div class="col">
                                <input type="number"  value=1 name="quantity" min=1 style="width:100%">
                            </div>
                            <div class="col">
                                <button class="btn btn-primary">Add to Cart</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div style="display:None">
        <div class="success-alert alert alert-success" role="alert">
      <strong>Success!</strong> Product added to cart. 
    </div>
    </div>
    
    {{-- <div class="alert-template" style="">
        <div class="alert alert-success fade in">
            <strong>Success!</strong> Product added to cart. 
        </div>
    </div> --}}
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
            var url = form.attr('action');
            var id = $(this).attr('id').split('-')[1];
            console.log("prod-id",id);
            console.log('please');
            console.log({{Auth::user()->id}});
            console.log(form.find("input[name='quantity']").val());
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
               type: "POST",
               url: '{{ route("cart.store")}}',
               data: {
                    product_id: id,
                    user_id: "{{Auth::user()->id}}",
                    quantity: form.find("input[name='quantity']").val()
               },
               success: function(data)
               {
                    var alert = $('.success-alert').clone().insertBefore('#product-list').delay(1000).fadeOut();
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

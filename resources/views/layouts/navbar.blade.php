<style>
#logo-kopiqu {
	font-size: 20pt;
	font-weight: bold;
	font-family: Helvetica;
}
</style>
<nav class="navbar fixed-top navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a id="logo-kopiqu" class="navbar-brand" style="font-size: 20pt;
    font-weight: bold;
    font-family: Helvetica;"href="{{ url('/') }}">
            KOPIQU
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Category
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        @foreach($nav_category as $category)
                        <a class="dropdown-item" href="{{route('category.search', $category->name) }}">{{$category->name}}</a>
                        @endforeach
						{{-- @foreach($nav_category as $category)
                        @if(!isSet($category->parent_id))
							<a class="dropdown-item font-weight-bold" href="{{route('category.search', $category->name) }}">{{$category->name}}</a>
                            @foreach($nav_category as $cat)
                            @if($cat->parent_id==$category->id)
                            <a class="dropdown-item" href="{{route('category.search', $cat->name) }}">{{$cat->name}}</a>
                            @endif
                            @endforeach
                        @else
                        <a class="dropdown-item font-weight-bold" href="{{route('category.search', $category->name) }}">{{$category->name}}</a>
                        @endif
						@endforeach --}}
					</div>
				</li>
            	
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @guest
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                </li>
                @endguest
            	<li class="nav-item">
					<a class="nav-link" href="{{ route('cart.index') }}">Carts</a>
				</li>
            	<!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role)
                            <a class="dropdown-item" href="{{ route('products.admin') }}">Product List</a>
                            <a class="dropdown-item"href="{{ route('orders.admin') }}">Order List</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

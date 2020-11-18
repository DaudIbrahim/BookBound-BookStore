<div class="header-middle"><!--header-middle-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="logo pull-left">
                    <a href="index.html"><img src="{{ asset('assets/customer') }}/assets/images/home/logo.png" alt="" /></a>
                </div>
                <div class="btn-group pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            USA
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Canada</a></li>
                            <li><a href="#">UK</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            DOLLAR
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Canadian Dollar</a></li>
                            <li><a href="#">Pound</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="shop-menu pull-right">
                    <ul class="nav navbar-nav">

                        <li>
                            @auth
                                @if (Auth::user()->is_admin)
                                    <a href="{{ route('admin.home') }}">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }} Panel
                                    </a>
                                @else
                                    <a href="{{ '#' }}">
                                        <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                    </a>
                                @endif
                            @endauth
                        </li>
                        {{-- <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                        <li><a href="checkout.html"><i class="fa fa-crosshairs"></i> Checkout</a></li> --}}

                        <li>
                            <a href="{{ route('cart.index') }}" class="{{ route::is('cart.index') ? 'active' : ''}}">
                                <i class="fa fa-shopping-cart"></i> Cart
                                <span style="{{ Cart::count() > 0 ? 'font-size: 120%' : '' }}">
                                    {{ Cart::count() > 0 ? Cart::count() : '' }}
                                </span>
                            </a>
                        </li>
                        
                        @guest
                            <li><a href="{{ route('register') }}"><i class="fa fa-lock"></i> {{ __('Register') }}</a></li>
                            <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> {{ __('Login') }}</a></li>
                        @endguest
                        
                        @auth
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>

        {{-- @auth
            @if (Auth::user()->is_admin)
                <div class="row">
                    <div class="alert alert-info">
                        <strong>{{ 'Admin Logged In.' }}</strong>
                    </div>
                </div>
            @endif
        @endauth --}}
    </div>
</div><!--/header-middle-->

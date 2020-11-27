<div class="header-middle"><!--header-middle-->
    <div class="container">
        <div class="row" style="border-bottom: none">
            
            <div class="col-sm-3">
                
                <div class="logo pull-left">
                    
                    <a href="{{ route('books.index') }}">
                        <img src="{{ asset('assets/customer') }}/assets/images/home/logo.png" alt="" style="width: 200px" />
                    </a>
                </div>

                
                
                
            </div>

            <div class="col-sm-9">

                <div class="pull-left">
                    <form method="GET" action="{{ route('books.index') }}" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input id="main-search" name="search" type="text" class="form-control" placeholder="Search" value="{{ old('search') ?? ($append['search'] ?? '')  }}">
                            </div>
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                    </form>
                </div>


                <div class="shop-menu pull-right">
                    <ul class="nav navbar-nav">


                        {{-- Home Button --}}
                        <li>
                            <a href="{{ route('books.index') }}">
                                <i class="fa fa-home" aria-hidden="false"></i> Home
                            </a>
                        </li>

                        {{-- My Orders --}}
                        @auth
                            @if (!Auth::user()->is_admin)
                                <li>
                                    <a href="{{ route('orders.index') }}">
                                        <i class="fa fa-archive" aria-hidden="false"></i> My Orders
                                    </a>
                                </li>    
                            @endif
                        @endauth

                        {{-- Cart --}}
                        <li>
                            <a href="{{ route('cart.index') }}" class="{{ route::is('cart.index') ? 'active' : ''}}">
                                <i class="fa fa-shopping-cart"></i> Cart
                                <span style="{{ Cart::count() > 0 ? 'font-size: 120%' : '' }}">
                                    {{ Cart::count() > 0 ? Cart::count() : '' }}
                                </span>
                            </a>
                        </li>

                        {{-- Proceed --}}
                        @if (route::is('cart.index'))
                            @if (Cart::count() > 0)
                                <li>
                                    <a href="#" onclick="event.preventDefault(); extraScroll('do_action')">
                                        <i class="fa fa-credit-card" aria-hidden="false"></i> Proceed
                                    </a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div><!--/header-middle-->

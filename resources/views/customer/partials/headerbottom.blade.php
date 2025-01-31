{{-- 
    DISCONTINUED
    --}}

<div class="header-bottom"><!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">

                        <li><a href="{{ route('books.index') }}" class="active">Home</a></li>

                        <li class="dropdown"><a href="#">Category<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                @foreach ($category_all as $category)
                                        <li>
                                            <a href="{{ route('books.index', ['category' => $category->id]) }}">
                                                {{ $category->title }}
                                            </a>
                                        </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li><a href="shop.html">Products</a></li>
                                <li><a href="product-details.html">Product Details</a></li> 
                                <li><a href="checkout.html">Checkout</a></li> 
                                <li><a href="cart.html">Cart</a></li> 
                                <li><a href="login.html">Login</a></li> 
                            </ul>
                        </li>

                        <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li><a href="blog.html">Blog List</a></li>
                                <li><a href="blog-single.html">Blog Single</a></li>
                            </ul>
                        </li>

                        <li><a href="404.html">404</a></li>

                        <li><a href="contact-us.html">Contact</a></li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="search_box pull-right">
                    <input type="text" placeholder="Search"/>
                    @if (route::is('cart.index'))
                        @if (Cart::count() > 0)
                            <button type="button" class="btn btn-outline-primary" onclick="extraScroll('do_action')">
                                <i class="fa fa-credit-card" aria-hidden="true"></i> Proceed
                            </button>    
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div><!--/header-bottom-->
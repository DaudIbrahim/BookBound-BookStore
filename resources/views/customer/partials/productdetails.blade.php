
<div class="product-details">

    @if (session('message'))
        <div class="alert alert-success">
            <strong>{{ session('message') }}</strong>
        </div>
    @endif
    
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{ $book->image }}" alt="">
        </div>
    </div>

    <div class="col-sm-7">
        <div class="product-information">

            @auth
                @if (Auth::user()->is_admin)
                    <p class="newarrival">
                        <a target="_blank" rel="noopener noreferrer" href="{{ route('admin.books.show', ['book' => $book->id]) }}">
                            Admin Panel
                        </a>
                    </p>
                @endif
            @endauth
            
            <h2>{{ $book->title }}</h2>
            <p>
                by <a href="#">{{ $book->author->title }}</a>
            </p>
            <p>
                <a href="#">{{ $book->getCategory()->title }}</a> > 
                <a href="#">{{ $book->subcategory->title }}</a>
            </p>
            
            
            {{-- Rating: Due --}}
            {{-- <span class="heading">User Rating</span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star"></span> --}}
            
            
            {{-- New Stock --}}
            <span>
                <p>Condition: <b>New</b></p>
                <span>TK. {{ $book->newStock()->price }}</span>
                @if ($book->newStock()->quantity >= 1)
                    @if (Cart::content()->firstWHere('id', $book->newStock()->id))
                        <a href="{{ route('cart.index') }}" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>&nbsp;Go to Cart
                        </a>
                    @else
                        <a href="#" class="btn btn-fefault cart" onclick="event.preventDefault(); document.getElementById('newstock-form').submit();">
                            <i class="fa fa-shopping-cart"></i>&nbsp;Add to cart
                        </a>
                        <form id="newstock-form" action="{{ route('cart.store') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $book->newStock()->id }}">
                        </form>
                    @endif
                @else
                    <a href="#" class="btn btn-fefault cart" style="color: black" disabled>
                        <i class="fa fa-shopping-cart"></i>&nbsp;Out of Stock
                    </a>
                @endif
            </span>

            {{-- Used Stock --}}
            <span>
                <p>Condition: <b>Used</b></p>
                <span>TK. {{ $book->usedStock()->price }}</span>
                @if ($book->usedStock()->quantity >= 1)
                    @if (Cart::content()->firstWHere('id', $book->usedStock()->id))
                        <a href="{{ route('cart.index') }}" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>&nbsp;Go to Cart
                        </a>
                    @else
                        <a href="#" class="btn btn-fefault cart" onclick="event.preventDefault(); document.getElementById('usedstock-form').submit();">
                            <i class="fa fa-shopping-cart"></i>&nbsp;Add to cart
                        </a>
                        <form id="usedstock-form" action="{{ route('cart.store') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ $book->usedStock()->id }}">
                        </form>
                    @endif
                @else
                    <a href="#" class="btn btn-fefault cart" style="color: black" disabled>
                        <i class="fa fa-shopping-cart"></i>&nbsp;Out of Stock
                    </a>
                @endif
            </span>
        </div>
        <!--/product-information-->
    </div>
</div>
<!--/product-details-->

<div class="category-tab shop-details-tab">
    <!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#description" data-toggle="tab">description</a></li>
            <li class=""><a href="#specification" data-toggle="tab">Specification</a></li>
            <li class=""><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="description">
            <p>
                {{ $book->description }}
            </p>
        </div>

        <div class="tab-pane fadea" id="specification">
            <table class="table table-bordered">
                <tbody>
                   <tr>
                      <td>Title</td>
                      <td>{{ $book->title }}</td>
                   </tr>
                   <tr>
                       <td>Author</td>
                       <td>{{ $book->author->title }}</td>
                   </tr>
                   <tr>
                       <td>Publisher</td>
                       <td> {{$book->publisher }} </td>
                   </tr>
                   <tr>
                       <td>ISBN-13</td>
                       <td> {{$book->isbn_13 }} </td>
                   </tr>
                   <tr>
                       <td>ISBN-10</td>
                       <td> {{$book->isbn_10 }} </td>
                   </tr>
                   <tr>
                       <td>Published Date</td>
                        <td> {{$book->published_date }} </td>
                    </tr>
                   <tr>
                       <td>Number of Pages</td>
                       <td> {{$book->page_count }} </td>
                   </tr>
                   <tr>
                       <td>Language</td>
                       <td> {{$book->lang }} </td>
                   </tr>
                    
                </tbody>
             </table>
        </div>

        <div class="tab-pane fade" id="reviews">
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis
                    aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <p><b>Write Your Review</b></p>

                <form action="#">
                    <span>
                                        <input type="text" placeholder="Your Name">
                                        <input type="email" placeholder="Email Address">
                                    </span>
                    <textarea name=""></textarea>
                    <b>Rating: </b> <img src="{{ asset('assets/customer/assets') }}/images/product-details/rating.png" alt="">
                    <button type="button" class="btn btn-default pull-right">
                                        Submit
                                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
<!--/category-tab-->

<div class="recommended_items">
    <!--recommended_items-->
    <h2 class="title text-center">recommended items</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend1.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend2.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend3.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item active">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend1.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend2.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('assets/customer/assets') }}/images/home/recommend3.jpg" alt="">
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                            </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                            </a>
    </div>
</div>
<!--/recommended_items-->
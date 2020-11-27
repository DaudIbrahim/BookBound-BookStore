
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
                by <a href="{{ route('books.index', ['author' => $book->author->id]) }}">{{ $book->author->title }}</a>
            </p>
            <p>
                <a href="{{ route('books.index', ['category' => $book->getCategory()->id ]) }}">{{ $book->getCategory()->title }}</a> > 
                <a href="{{ route('books.index', ['subcategory' => $book->subcategory->id ]) }}">{{ $book->subcategory->title }}</a>
            </p>
            
            
            {{-- Rating: Due --}}
            @if ($averageRating)
                <div>
                    <span class="heading">{{ $averageRating }}/5</span>
                    <span class="fa fa-star checked"></span>
                </div>
            @endif
            
            
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
            @if ($review)
                <li class=""><a href="#description" data-toggle="tab">description</a></li>
                <li class=""><a href="#specification" data-toggle="tab">Specification</a></li>
                <li class="active"><a href="#reviews" data-toggle="tab">Reviews ({{$book->reviews->count()}})</a></li>
            @else
                <li class="active"><a href="#description" data-toggle="tab">description</a></li>
                <li class=""><a href="#specification" data-toggle="tab">Specification</a></li>
                <li class=""><a href="#reviews" data-toggle="tab">Reviews ({{$book->reviews->count()}})</a></li>
            @endif
        </ul>
    </div>
    <div class="tab-content">

        <div class="tab-pane fade {{ $review ? 'active in' : ''}}" id="reviews">
            <div class="col-sm-12">

                {{-- Reviews --}}
                @foreach ($book->reviews as $r)
                    <div>
                        <ul>
                            <li><span class="stars-container stars-{{ $r->rating }}">★★★★★</span></li>
                            <li><a href="#"></a></li>
                            <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-user"></i>{{ $r->user->name}}</a></li>
                            <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-clock-o"></i>{{ date_format($r->created_at, 'g:i A')}}</a></li>
                            <li><a href="#" onclick="event.preventDefault()"><i class="fa fa-calendar-o"></i>{{ date_format($r->created_at, 'jS F Y')}}</a></li>
                            
                        </ul>
                        <p>{{ $r->description }}</p>
                    </div>
                    <br>
                @endforeach
                

                {{-- Review Form --}}
                @auth
                    @if (!Auth::user()->is_admin)

                        @if (!$userHasReviewed)
                        <div style="padding-top: 30px;">
                            <p>
                                <b>Write Your Review</b>
                            </p>
                            
                            <form action="{{ route('reviews.store') }}" method="post" id="review-form">
                                @csrf

                                <textarea id ="description" name="description" style="color: black" placeholder="Description">{{ old('description') ?? "" }}</textarea>

                                {{-- <b>Rating: </b> <img src="{{ asset('assets/customer/assets') }}/images/product-details/rating.png" alt=""> --}}

                                <b>Rating: </b>
                                <div class="txt-center22">
                                    <div class="rating22">
                                        <input id="star5" name="rating" type="radio" value="5" class="radio-btn hide22" />
                                        <label for="star5">☆</label>
                                        <input id="star4" name="rating" type="radio" value="4" class="radio-btn hide22" />
                                        <label for="star4">☆</label>
                                        <input id="star3" name="rating" type="radio" value="3" class="radio-btn hide22" />
                                        <label for="star3">☆</label>
                                        <input id="star2" name="rating" type="radio" value="2" class="radio-btn hide22" />
                                        <label for="star2">☆</label>
                                        <input id="star1" name="rating" type="radio" value="1" class="radio-btn hide22" />
                                        <label for="star1">☆</label>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                                {{--  Hidden Book Id--}}
                                <input type="hidden" name="book" value="{{ $book->id }}">
                                
                                <button type="submit" class="btn btn-default pull-right">Submit</button>
                            </form>
                            @if ($errors->any())
                                <br><br><br><!--SPACING-->
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                        </div>
                        @elseif($userHasReviewed)
                            <div id="review-form" style="padding-top: 30px;">
                                <p>
                                    <b>Rated & Reviewed</b>
                                </p>
                            </div>
                        @endif
                        
                    @endif
                @endauth

                @guest
                    <div id="review-form" style="padding-top: 30px;">
                        <p>
                            <a href="{{ route('login')}} ">Login</a>/<a href="{{ route('register') }}">Register</a> to
                            <b>Write Your Review</b>
                        </p>
                    </div>
                @endguest
                
                
            </div>
        </div>

        <div class="tab-pane fade {{ $review ? '' : 'active in'}}" id="description">
            <p>
                {{ $book->description }}
            </p>
        </div>

        <div class="tab-pane fade" id="specification">
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

    </div>
</div>
<!--/category-tab-->

<div class="recommended_items">
    <!--recommended_items-->
    <h2 class="title text-center">recommended items</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            {{-- <div class="item">
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
            </div> --}}
            <div class="item active">

                @foreach ($random as $b)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('books.details', $b->id) }}">
                                        <img class="img-fluid" src="{{ $b->image}}" alt="">
                                    </a>
                                    <h2>{{ $b->title }}</h2>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="col-sm-4">
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
                </div> --}}
            </div>
        </div>
        {{-- <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a> --}}
    </div>
</div>
<!--/recommended_items-->
{{-- THE Centrepiece --}}

<div class="features_items">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--features_items-->
    @if ($books->isEmpty())
        <div align="center "class="content-404">
            {{-- https://www.wayfair.co.uk/ --}}
            <p>We're Sorry! We can't seem to find any books that match your criteria</p>
            <strong><a href="{{ route('books.index') }}">Try Again</a></strong>
        </div>
    @else
        <h2 class="title text-center">Total Books {{ $books->count()}}</h2>
    @endif

    @foreach ($books as $book)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <a href="{{ route('books.details', ['book' => $book->id]) }}">
                            <img src="{{ $book->image }}" alt="" height="350">
                        </a>
                        <h2>
                            <a href="{{ route('books.details', ['book' => $book->id]) }}" style="color: orange">
                                {{ $book->title }}
                            </a>
                        </h2>
                        <p>
                            <a href="{{ route('books.index', ['author' => $book->author->id]) }}">
                                {{ $book->author->title }}
                            </a>
                        </p>
                    </div>
                </div>
                <div class="choose" style="background-color: ghostwhite;">
                    <ul class="nav nav-pills nav-justified">
                        <li>
                            <a href="{{ route('books.details', ['book' => $book->id]) }}" style="color: black; font-size:14px">
                                {{-- <i class="fa fa-money"></i> --}}
                                New TK. {{ $book->newStock()->price }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.details', ['book' => $book->id]) }}" style="color: black; font-size:14px">
                                {{-- <i class="fa fa-money"></i> --}}
                                Used TK. {{ $book->usedStock()->price }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach

    {{-- <ul class="pagination">
        <li class="active"><a href="">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>
        <li><a href="">»</a></li>
    </ul> --}}
</div>

<div align="center">
    
    {{ $books->appends($append)->links() }}

    {{-- {{ $books->links()  }} --}}
</div>
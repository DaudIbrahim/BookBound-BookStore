<div class="features_items">
    <!--features_items-->
    <h2 class="title text-center">Total Books {{ $books->count()}}</h2>

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
                        <p>{{ $book->author->title }}</p>
                    </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li>
                            <a href="{{ route('books.details', ['book' => $book->id]) }}">
                                <i class="fa fa-money"></i>New TK. {{ $book->newStock()->price }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('books.details', ['book' => $book->id]) }}">
                                <i class="fa fa-money"></i>Used TK. {{ $book->usedStock()->price }}
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
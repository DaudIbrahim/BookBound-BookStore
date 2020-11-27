<div class="left-sidebar">

    {{-- TEST --}}
    {{-- <div align="center">
        @foreach ($append as $key => $value)
            <p style="color: blue">{{ $key }} - {{ $value ?? 'NULL' }}</p>
        @endforeach
    </div> --}}

    {{-- Filter --}}
    @if ($append['filter'])
        <div class="brands_products" style="margin: 0 auto 30px;"><!--brands_products-->
            <h2>Filter</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">

                    @if ($append['search'])
                        <li>
                            <p></p> {{-- just for spacing --}}
                            <a href="{{ route('books.index', array_diff_key($append, array_flip(['search']))) }}" 
                                style="background: #efefef; color: #707070;">
                                <span class="pull-right">
                                    <i class="fa fa-times"></i>
                                </span>
                                {{ $append['search'] }}
                            </a>
                        </li>
                    @endif

                    @if ($append['author'])
                        <li>
                            <p></p> {{-- just for spacing --}}
                            <a href="{{ route('books.index', array_diff_key($append, array_flip(['author']))) }}" 
                                style="background: #efefef; color: #707070;">
                                <span class="pull-right">
                                    <i class="fa fa-times"></i>
                                </span>
                                {{ $author->title }}
                            </a>
                        </li>
                    @endif

                    @if ($append['subcategory'])
                        <li>
                            <p></p> {{-- just for spacing --}}
                            <a href="{{ route('books.index', array_diff_key($append, array_flip(['subcategory', 'category']))) }}" 
                                style="background: #efefef; color: #707070;">
                                <span class="pull-right">
                                    <i class="fa fa-times"></i>
                                </span>
                                {{ $subcategory->title }}
                            </a>
                        </li>
                    @endif

                    @if (!$append['subcategory'] && $append['category'])
                        <li>
                            <p></p> {{-- just for spacing --}}
                            <a href="{{ route('books.index', array_diff_key($append, array_flip(['category']))) }}" 
                                style="background: #efefef; color: #707070;">
                                <span class="pull-right">
                                    <i class="fa fa-times"></i>
                                </span>
                                {{ $category->title }}
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div><!--/brands_products-->    
    @endif
    
    
    <h2>Category</h2>
    <div class="panel-group category-products" id="accordian"><!--category-productsr--><!--Category-->
        @foreach ($category_all as $category)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#category-{{ $category->id }}" 
                            style="{{ $append['category'] == $category->id ? "color: #FE980F" : "" }}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{ $category->title }}
                        </a>
                    </h4>
                </div>

                <div id="category-{{ $category->id }}" class="panel-collapse {{ $append['category'] == $category->id ? "in" : "collapse" }}">
                    <div class="panel-body">
                        <ul>
                            <li>
                                <a href="{{ route('books.index', ['category' => $category->id, 'author' => $append['author'], 'search' => $append['search']])}}" 
                                    style="{{ ($append['subcategory'] == null && $append['category'] == $category->id) ? "color: #FE980F" : "" }}">
                                    All
                                </a>
                            </li>
                            @foreach ($category->subcategories as $subcategory)
                                <li>
                                    <a href="{{ route('books.index', ['subcategory' => $subcategory->id, 'author' => $append['author'], 'search' => $append['search']])}}" 
                                        style="{{ $append['subcategory'] == $subcategory->id ? "color: #FE980F" : ""}}">
                                        {{ $subcategory->title }}
                                    </a>
                                </li>    
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div><!--/category-productsr--><!--Category-->

    @if ($author_all)
        {{-- Authors --}}
        <div class="brands_products"><!--brands_products--><!--Authors-->
            <h2>Authors ({{ $author_all->count() }})</h2>
            <div class="brands-name" style="padding-bottom: 2px">
                <ul class="list-group" style="max-height: 200px; overflow-y: auto;">

                    <form action="{{ route('books.index', ['catgeory' => '9']) }}" method="GET">
                        
                        {{-- Get Append --}}
                        @foreach ($append as $k => $a)
                            @if ($k === 'author') @continue @endif
                            <input type="hidden" name="{{ $k }}" value="{{ $a}}">
                        @endforeach

                        {{-- Create Radio Button --}}
                        @foreach ($author_all as $author)
                            <li class="list-group-item" style="padding: 3px 15px; border: 0px;">
                                <input type="radio" class="custom-control-input" name="author" id="author-{{ $author->id }}" 
                                value="{{ $author->id }}" onclick="this.form.submit()"
                                {!! $author->id == $append['author'] ? "checked function(){console.log('WAH')}()" : "" !!}>

                                <label class="custom-control-label" for="author-{{ $author->id }}">&nbsp;{{ $author->title }}</label>
                            </li>
                        @endforeach
                    </form>

                </ul>
            </div>
        </div><!--brands_products--><!--Authors-->
    @endif
    
</div>
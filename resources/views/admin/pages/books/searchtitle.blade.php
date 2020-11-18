@extends('admin.layout.master')

@section('page-header')
   Title Search <small>Search Books by Title to Add into your Products</small>
@endsection

@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-content">

            @if (session('message'))
               <div class="alert alert-success">
                  <strong>{{ session('message') }}</strong>
               </div>
            @endif

            {{-- 
               Search Form. Sending the Key Word
                --}}
            <form method="GET" action="{{ route('admin.books.search.title') }}" class="col s12">
               <div class="row">
                  <div class="input-field col s8">
                     <input id="title" name="title" type="text" placeholder="Title" value="{{ old('title') ?? $title }}" required/>
                        @error('title')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
                  <div class="input-field col s4">
                     <button type="submit" class="waves-effect waves-light btn">
                        <i class="material-icons left">search</i>search
                     </button>
                  </div>
               </div>
            </form>

            {{-- 
               Return array of search results Show Important Data
               Using GET Request send ISBN number to 
               Existing route -> admin.books.search -> AdminBookController@search
                --}}
            @foreach ($books_array as $book)
            <div class="row">
                      <div class="card-content">
                        <form method="GET" action="{{ route('admin.books.search') }}" class="col s12">
                           <input id="isbn" name="isbn" type="hidden" value="{{ $book['isbn_13'] }}" required/>

                           <div class="row">
                              
                              {{-- 1. image --}}
                              <div class="input-field col s2">
                                 <img src="{{ $book['image'] }}" class="img-thumbnail">
                              </div>

                              <div class="input-field col s9">
                                 <div class="row">

                                    <div class="input-field col s5">
                                       <input name="" id="title" type="text" value="{{ $book['title'] }}" readonly>
                                       <label for="title" class="active" style="font-size: 80%">Title</label>
                                    </div>

                                    <div class="input-field col s5">
                                       <input name="" id="author" type="text" value="{{ $book['author'] }}" readonly>
                                       <label for="author" class="active" style="font-size: 80%">Author</label>
                                    </div>

                                    <div class="input-field col s5">
                                       <input name="" id="isbn_10" type="text" value="{{ $book['isbn_10'] }}" readonly>
                                       <label for="isbn_10" class="active" style="font-size: 80%">ISBN 10</label>
                                    </div>

                                    <div class="input-field col s5">
                                       <input name="" id="isbn_13" type="text" value="{{ $book['isbn_13'] }}" readonly>
                                       <label for="isbn_13" class="active" style="font-size: 80%">ISBN 13</label>
                                    </div>

                                    <div class="input-field col s5">
                                       <input name="" id="publisher" type="text" value="{{ $book['publisher'] }}" readonly>
                                       <label for="publisher" class="active" style="font-size: 80%">publisher</label>
                                    </div>

                                    <div class="input-field col s5">
                                       <input name="" id="published_date" type="text" value="{{ $book['published_date'] }}" readonly>
                                       <label for="published_date" class="active" style="font-size: 80%">Published Date</label>
                                    </div>

                                    {{-- <div class="input-field col s12">
                                       <p>
                                          {{ $book ['description'] }}
                                       </p>
                                       <label for="description" class="active" style="font-size: 80%">Description</label>
                                    </div> --}}

                                    <div class="input-field col s12">
                                       <button type="submit" class="btn btn-primary btn-block">
                                          Select
                                       </button>
                                    </div>
                                    
                                 </div>
                              </div>
                           </div>
                         </form>
                      </div>
                     </div>
               @endforeach

         </div>
         <div class="clearBoth"><br/></div>
      </div>
   </div>
 </div>
@endsection

@section('javascript')
  
@endsection

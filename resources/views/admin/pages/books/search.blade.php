@extends('admin.layout.master')

@section('page-header')
   ISBN Search <small>Search Books by ISBN Number to Add into your Products</small>
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">
         <div class="card-content">
            @if (session('message'))
               <div class="alert alert-success">
                  <strong>{{ session('message') }}</strong>
               </div>
            @endif
            <form method="GET" action="{{ route('admin.books.search') }}" class="col s12">
               <div class="row">
                  <div class="input-field col s8">
                     <input id="isbn" name="isbn" type="text" placeholder="ISBN Number" value="{{ old('isbn') }}" required/>
                        @error('isbn')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
                  <div class="input-field col s4">
                     <button type="submit" class="waves-effect waves-light btn">
                        <i class="material-icons left">search</i>search
                     </button>
                  </div>
               </div>
               <div class="row">
                  @if (session('google_book'))
                      Last Search: <a href="{{ route('admin.books.create') }}">{{ session('google_book')['title'] }}</a>
                  @endif
               </div>
           </form>
         </div>
         <div class="clearBoth"><br/></div>
      </div>
   </div>
 </div>
@endsection

@section('javascript')
  
@endsection

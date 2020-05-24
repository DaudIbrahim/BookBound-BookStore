@extends('admin.layout.master')

@section('page-header')
  Edit Category
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">

         <div class="card-action">
            <a href="{{ route('admin.categories.index') }}">
               <span class="material-icons">arrow_back</span>
            </a>
         </div>
         <div class="card-content">

            <form method="POST" action="{{ route('admin.categories.update', ["category" => $category->id]) }}" class="col s12">
               @method('PUT')
               @csrf
               
               <div class="row">
                  <div class="input-field col s8">
                     <input id="title" name="title" type="text" value="{{ $category->title }}" />
                        @error('title')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
                  <div class="input-field col s4">
                     <button type="submit" class="waves-effect waves-light btn">
                        <i class="material-icons left">create</i>Edit
                     </button>
                  </div>
               </div>
           </form>

         </div>
         <div class="clearBoth"><br/></div>
      </div>
   </div>
 </div>
@endsection

@section('javascript')
  <script>
      (function() {

      })();
  </script>
@endsection

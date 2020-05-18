@extends('admin.layout.master')

@section('page-header')
  Edit SubCategory
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">

         <div class="card-action">
            <a href="{{ route('admin.subcategories.index') }}">
            <span class="material-icons">arrow_back</span>
            </a>
         </div>
         
         <div class="card-content">

            <form method="POST" action="{{ route('admin.subcategories.update', ["subcategory" => $subcategory->id]) }}" class="col s12">
               @method('PUT')
               @csrf
               
               <div class="row">
                  <div class="input-field col s8">
                     <select id="category" name="category" class="form-control">
                        @foreach ($categories as $category)
                           <option value="{{ $category->id }}" 
                              {{ ($subcategory->category_id == $category->id) ? "selected" : "" }}>
                              {{ $category->title }}
                           </option>
                        @endforeach
                     </select>
                        @error('category')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
               </div>

               <div class="row">
                  <div class="input-field col s8">
                     <input id="title" name="title" type="text" value="{{ $subcategory->title }}" />
                        @error('title')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
               </div>

               <div class="tow">
                  <div class="input-field col s8">
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

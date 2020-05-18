@extends('admin.layout.master')

@section('page-header')
  Create New Category
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">
         <div class="card-content">

            <form method="POST" action="{{ route('admin.categories.store') }}" class="col s12">

               @csrf
               
               <div class="row">
                  <div class="input-field col s8">
                     <input id="title" name="title" type="text" placeholder="Title" value="{{ old('title') }}" />
                        @error('title')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
                  <div class="input-field col s4">
                     <button type="submit" class="waves-effect waves-light btn">
                        <i class="material-icons left">add_circle</i>Add
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

@extends('admin.layout.master')

@section('page-header')
   Add New Area
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">
         <div class="card-content">

            <form method="POST" action="{{ route('admin.areas.store') }}" class="col s12">

               @csrf

               <div class="row">
                  <div class="input-field col s8">
                     <select id="city" name="city" class="form-control">
                        <option value="0">Select a City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ (old('city') == $city->id) ? "selected" : "" }}>
                              {{ $city->title }}
                           </option>
                        @endforeach
                      </select>
                        @error('city')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
               </div>
               
               <div class="row">
                  <div class="input-field col s8">
                     <input id="title" name="title" type="text" placeholder="Title" value="{{ old('title') }}" />
                        @error('title')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
               </div>
               
               <div class="row">
                  <div class="input-field col s8">
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

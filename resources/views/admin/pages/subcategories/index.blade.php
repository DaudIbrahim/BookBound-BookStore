@extends('admin.layout.master')

@section('page-header')
  Subcategories
@endsection

@section('content')
<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-action">
            {{-- Action --}}
         </div>
         <div class="card-content">
            @if (session('message'))
               <div class="alert alert-success">
                  <strong>{{ session('message') }}</strong>
               </div>
            @endif
            <div class="table-responsive">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Edit</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($subcategories as $subcategory)
                        <tr>
                           <td>{{ $subcategory->id }}</td>
                           <td>{{ $subcategory->title }}</td>
                           <td>{{ $subcategory->category->title }}</td>
                           <td>
                              <a href="{{ route('admin.subcategories.edit', ['subcategory' => $subcategory->id]) }}">
                                 Edit
                              </a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
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

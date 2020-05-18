@extends('admin.layout.master')

@section('page-header')
  Categories
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
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Subcategories</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($categories as $category)
                        <tr>
                           <td>{{ $category->id }}</td>
                           <td>{{ $category->title }}</td>
                           <td>
                              <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
                                 Edit
                              </a>
                           </td>
                           <td>
                              <a href="{{ route('admin.categories.show', ['category' => $category->id]) }}">
                                 Subcategories
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

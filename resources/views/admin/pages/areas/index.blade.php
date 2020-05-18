@extends('admin.layout.master')

@section('page-header')
  Areas
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
                        <th>Area</th>
                        <th>City</th>
                        <th>Edit</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($areas as $area)
                        <tr>
                           <td>{{ $area->id }}</td>
                           <td>{{ $area->title }}</td>
                           <td>{{ $area->city->title }}</td>
                           <td>
                              <a href="{{ route('admin.areas.edit', ['area' => $area->id]) }}">
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

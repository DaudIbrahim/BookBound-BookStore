@extends('admin.layout.master')

@section('page-header')
  {{ $category->title }}<small> Subcategories</small>
@endsection

@section('content')
<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-action">
            <a href="{{ url()->previous() }}">
               <span class="material-icons">arrow_back</span>
            </a>         
         </div>

        <div class="card-content">
            <div class="row">
               <div class="table-responsive">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Title</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($category->subcategories as $subcategory)
                           <tr>
                              <td>{{ $subcategory->id }}</td>
                              <td>
                                 <a href="{{ route('admin.subcategories.edit', ["subcategory" => $subcategory->id]) }}">
                                    {{ $subcategory->title }}
                                 </a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>

         </div>
         <div class="clearBoth"><br/></div>
      </div>
   </div>
</div>
@endsection

@section('javascript')
  <script>
   
  </script>
@endsection

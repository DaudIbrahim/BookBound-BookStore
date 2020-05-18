@extends('admin.layout.master')

@section('page-header')
  Subcategories Show.
@endsection

@section('content')
<div class="row">
   <div class="col-md-8">
      <div class="card">
         <div class="card-action">
            {{-- Action --}}
         </div>

        <div class="card-content">
            <div class="row">
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
                        <td>Example</td>
                        <td>Example</td>
                        <td>Example</td>
                        <td>Example</td>
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
  
@endsection

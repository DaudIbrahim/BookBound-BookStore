@extends('admin.layout.master')

@section('page-header')
  Coupons
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
                        <th>Code</th>
                        <th>Percent</th>
                        <th>Quantity</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($coupons as $coupon)
                        <tr>
                           <td>{{ $coupon->id }}</td>
                           <td>{{ $coupon->code }}</td>
                           <td>{{ $coupon->percent }}</td>
                           <td>{{ $coupon->quantity }}</td>
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

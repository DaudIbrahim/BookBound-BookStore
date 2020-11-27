@extends('admin.layout.master')

@section('page-header')
  Index Page
@endsection

@section('content')


{{-- FIRST ROW --}}
<div class="row">

   {{--  --}}
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card horizontal cardIcon waves-effect waves-dark">
         <div class="card-image red">
            <i class="fa fa-shopping-cart fa-5x"></i>
         </div>
         <div class="card-stacked">
            <div class="card-content">
               <h3>Tk. {{ number_format($sales) }}</h3>
            </div>
            <div class="card-action">
               <strong> Sales</strong>
            </div>
         </div>
      </div>
   </div>

   {{--  --}}
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card horizontal cardIcon waves-effect waves-dark">
         <div class="card-image blue">
            <i class="fa fa-list fa-5x"></i>
         </div>
         <div class="card-stacked">
            <div class="card-content">
               <h3>{{ number_format($approved) }}</h3>
            </div>
            <div class="card-action">
               <strong> Orders Approved</strong>
            </div>
         </div>
      </div>
   </div>

   {{--  --}}
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card horizontal cardIcon waves-effect waves-dark">
         <div class="card-image orange">
            <i class="fa fa-list fa-5x"></i>
         </div>
         <div class="card-stacked">
            <div class="card-content">
               <h3>{{ number_format($shipping) }}</h3>
            </div>
            <div class="card-action">
               <strong> Orders On Shipping</strong>
            </div>
         </div>
      </div>
   </div>

   
   {{--  --}}
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card horizontal cardIcon waves-effect waves-dark">
         <div class="card-image">
            <i class="fa fa-list fa-5x"></i>
         </div>
         <div class="card-stacked">
            <div class="card-content">
               <h3>{{ number_format($completed) }}</h3>
            </div>
            <div class="card-action">
               <strong> Orders Completed</strong>
            </div>
         </div>
      </div>
   </div>
</div>


{{-- SECOND ROW --}}
<div class="row">
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card-panel text-center">
         <h4>Total Books</h4>
         <div class="easypiechart" id="easypiechart-blue" data-percent="82">
            <span class="percent">{{ number_format($books) }}</span>
            <canvas height="110" width="110"></canvas>
         </div>
      </div>
   </div>
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card-panel text-center">
         <h4>Stock (New & Used)</h4>
         <div class="easypiechart" id="easypiechart-red" data-percent="46">
            <span class="percent">{{ number_format($stocks) }}</span>
            <canvas height="110" width="110"></canvas>
         </div>
      </div>
   </div>
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card-panel text-center">
         <h4>Valid Coupons</h4>
         <div class="easypiechart" id="easypiechart-teal" data-percent="84">
            <span class="percent">{{ number_format($coupons) }}</span>
            <canvas height="110" width="110"></canvas>
         </div>
      </div>
   </div>
   <div class="col-xs-12 col-sm-6 col-md-3">
      <div class="card-panel text-center">
         <h4>Registered Users</h4>
         <div class="easypiechart" id="easypiechart-orange" data-percent="55">
            <span class="percent">{{ number_format($users) }}</span>
            <canvas height="110" width="110"></canvas>
         </div>
      </div>
   </div>
</div>

@endsection

@section('javascript')
  <script>
      (function() {
         console.log('READY');
      })();
  </script>
@endsection

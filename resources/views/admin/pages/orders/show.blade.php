@extends('admin.layout.master')

@section('page-header')
  Order Details
@endsection

@section('content')

{{-- Keys --}}
<div class="row">
   <div class="col-md-12">
      <div class="card"> 
 
         <div class="card-content">

            {{-- Update Success Message --}}
            @if (session()->has('updatesuccess'))
               <div class="alert alert-success">
                  <strong>{{ session('updatesuccess') }}</strong>
               </div>
              <br>
            @endif

            {{-- Order/Customer Details --}}
            <div class="row">
               <h4><strong>Order/Customer Details</strong></h4></div>
            <form action="" method="" onsubmit="event.preventDefault()">

               <div class="row">
                  <div class="input-field col s4">
                     <input name="" id="order_id" type="text" value="{{ $order->id }}" readonly>
                     <label for="order_id" class="active" style="font-size: 80%">Order ID</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="status" type="text" value="{{ $order->status->title }}" readonly>
                     <label for="status" class="active" style="font-size: 80%">Order Status</label>
                  </div>

                  
                  <div class="center-align input-field col s4">
                     <a href="{{ route('admin.orders.edit', ["order" => $order->id]) }}" class="btn" style="overflow: hidden; width: 70%">
                        <i class="material-icons dp48">mode_edit</i>
                        Update Status
                     </a>
                  </div>
               </div>

               <div class="row">
                  <div class="input-field col s4">
                     <input name="" id="user" type="text" value="{{ $order->user->name }}" readonly>
                     <label for="user" class="active" style="font-size: 80%">Customer</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="transaction_id" type="text" value="{{ $order->transaction_id }}" readonly>
                     <label for="transaction_id" class="active" style="font-size: 80%">Stripe Transaction ID</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="coupon" type="text" value="{{ $order->coupon_id ? $order->coupon->code : 'Empty' }}" readonly>
                     <label for="coupon" class="active" style="font-size: 80%">Coupon Code</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="placed-at" type="text" value="{{ $order->created_at }}" readonly>
                     <label for="placed-at" class="active" style="font-size: 80%">Placed At</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="area" type="text" value="{{ $order->area->title }}" readonly>
                     <label for="area" class="active" style="font-size: 80%">Area</label>
                  </div>

                  <div class="input-field col s4">
                     <input name="" id="address" type="text" value="{{ $order->address }}" readonly style="overflow: hidden">
                     <label for="address" class="active" style="font-size: 80%">Address</label>
                  </div>
               </div>

               {{-- Books Purchased --}}
               <div class="row"><h4><strong>Books Purchased</strong></h4></div>
               <div class="row">
                  @foreach ($order->stocks as $s)
                     <div class="input-field col s3">
                        <input name="" id="stock-{{ $s->id }}-title" type="text" value="{{ $s->book->title }} ({{ $s->is_used ? 'Used' : 'New' }})" readonly>
                        <label for="stock-{{ $s->id }}-title" class="active" style="font-size: 80%">
                           <a href="{{ route('admin.books.show', $s->book->id) }}">Link</a>
                        </label>
                     </div>
                     <div class="input-field col s3">
                        <input name="" id="stock-{{ $s->id }}-price" type="text" value="{{ $s->pivot->price }}" readonly>
                        <label for="stock-{{ $s->id }}-price" class="active" style="font-size: 80%">Price At Purchase</label>
                     </div>
                     <div class="input-field col s3">
                        <input name="" id="stock-{{ $s->id }}-quantity" type="text" value="{{ $s->pivot->quantity }}" readonly>
                        <label for="stock-{{ $s->id }}-quantity" class="active" style="font-size: 80%">Quantity</label>
                     </div>
                     <div class="input-field col s3">
                        <input name="" id="stock-{{ $s->id }}-total" type="text" value="{{ $s->pivot->price * $s->pivot->quantity }}" readonly>
                        <label for="stock-{{ $s->id }}-total" class="active" style="font-size: 80%">Total</label>
                     </div>
                  @endforeach
               </div>

               {{-- Summary --}}
               <div class="row"><h4><strong>Summary</strong></h4></div>
               <div class="row">
                  <div class="input-field col s3">
                     <input name="" id="subtotal" type="text" value="{{ $order->subtotal }}" readonly>
                     <label for="subtotal" class="active" style="font-size: 80%">Subtotal</label>
                  </div>
                  <div class="input-field col s3">
                     <input name="" id="shipping" type="text" value="{{ $order->shipping }}" readonly>
                     <label for="shipping" class="active" style="font-size: 80%">Shipping</label>
                  </div>
                  <div class="input-field col s3">
                     <input name="" id="discount" type="text" value="{{ $order->discount }}" readonly>
                     <label for="discount" class="active" style="font-size: 80%">Discount</label>
                  </div>
                  <div class="input-field col s3">
                     <input name="" id="total" type="text" value="{{ $order->total }}" readonly>
                     <label for="total" class="active" style="font-size: 80%">Total</label>
                  </div>
               </div>

            </form>
         </div>
 
         <div class="clearBoth"><br/></div>
      </div>
   </div>
</div>
   <!-- /. ROW  -->
@endsection

@section('javascript')
   <script src="{{ asset('assets/admin') }}/assets/js/dataTables/jquery.dataTables.js"></script>
   <script src="{{ asset('assets/admin') }}/assets/js/dataTables/dataTables.bootstrap.js"></script>

   {{-- <script>
       alert(jQuery.fn.jquery);
   </script> --}}
   
@endsection

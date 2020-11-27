@extends('customer.layout.master')

@section('content')
<div id="contact-page" class="container">
	<div class="bg">

		<div class="row">
			<div class="col-sm-12">
                <div class="contact-form">
                    <h2 class="title text-center">Order Details</h2>
                </div>
        </div>

        <div class="row">

         <div class="col-sm-4">

            {{-- Payment Summary --}}
            <div class="col-sm-12 padding-right">
               <table class="table">
                   <h4>Details</h4>
                   <tbody>
                      <tr>
                         <td>Order ID</td>
                         <td class="text-right" id="ID">{{ $order->id }}</td>
                      </tr>
                      <tr>
                         <td>Order Status</td>
                         <td class="text-right" id="Status">{{ $order->status->title }}</td>
                      </tr>
                      <tr>
                         <td>Placed At</td>
                         <td class="text-right" id="Placed">{{ date_format($order->created_at, 'd/m/y') }}</td>
                      </tr>
                      <tr>
                         <td>Area</td>
                         <td class="text-right" id="Area">{{ $order->area->title }}</td>
                      </tr>
                      <tr>
                          <td>Address</td>
                          <td class="text-right" id="Address" style="overflow: hidden">
                              {{ $order->address }}
                           </td>
                      </tr>
                      @if ($order->coupon_id)
                       <tr>
                           <td>Coupon Code</td>
                           <td class="text-right" id="Area">{{ $order->coupon->code }}</td>
                       </tr>
                      @endif
                   </tbody>
                </table>
           </div>

            {{-- Payment Summary --}}
            <div class="col-sm-12 padding-right">
               <table class="table">
                   <h4>Payment</h4>
                   <tbody>
                      <tr>
                         <td>Subtotal</td>
                         <td class="text-right" id="subtotal">{{ $order->subtotal }} TK.</td>
                      </tr>
                      <tr>
                         <td>Shipping</td>
                         <td class="text-right" id="shipping">{{ $order->shipping }} TK.</td>
                      </tr>
                      <tr>
                        @if ($order->coupon_id)
                           <td>Discount</td>
                           <td class="text-right" id="shipping">{{ $order->discount }} TK.</td>
                         @endif
                      </tr>
                      <tr>
                         <td>Total Paid</td>
                         <td class="text-right" id="shipping">{{ $order->total }} TK.</td>
                      </tr>
                   </tbody>
                </table>
           </div>

         </div>

         <div class="col-sm-8">
             {{-- Books Purchased --}}
             <div class="col-sm-12">
               {{-- <h3>Purchase</h3><br> --}}
               <table class="table table-borderless">
                   <thead>
                     <tr>
                       <th scope="col">Image</th>
                       <th scope="col">Book</th>
                       <th scope="col">Price At Purchase</th>
                       <th scope="col">Quantity</th>
                       <th scope="col">Total</th>
                     </tr>
                   </thead>
                   <tbody>
                     @foreach ($order->stocks as $s)
                         <tr>
                             <td>
                                 <img src="{{ $s->book->image }}" class="img-fluid" alt="Responsive image">
                             </td>
                             <td>
                                 <a href="{{ route('books.details', $s->book->id) }}">
                                     {{ $s->book->title }} ({{ $s->is_used ? 'Used' : 'New'}})
                                 </a>
                             </td>
                             <td>{{ $s->pivot->price }}</td>
                             <td>{{ $s->pivot->quantity }}</td>
                             <td>{{ $s->pivot->price * $s->pivot->quantity }}</td>
                     @endforeach
                   </tbody>
               </table>
           </div>

         </div>
        </div>
        
	</div>
</div>





<div id="contact-page" class="container">        
		<div class="row">

           
            
           
        </div>
	</div>
</div>
<!--/#contact-page-->
@endsection

@section('javascript')
    
@endsection
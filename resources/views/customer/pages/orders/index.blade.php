@extends('customer.layout.master')

@section('content')
<div id="contact-page" class="container">
	<div class="bg">

		{{-- <div class="row">
			<div class="col-sm-12">
				<h2 class="title text-center">Contact <strong>Us</strong></h2>
				<div id="gmap" class="contact-map"> </div>
			</div>
        </div> --}}
        
		<div class="row">

            {{-- WORK HERE --}}
			<div class="col-sm-12">
				<div class="contact-form">

                    <h2 class="title text-center">My Orders</h2>
                    <h4 class="title text-center">Your Total Order{{ $orders->count() > 0 ? 's' : ''}}: {{ $orders->count() }}</h4>
                    
                    {{-- <div class="status alert alert-success" style="display: none"></div> --}}
                    
					<table class="table table-borderless">
						<thead>
						  <tr>
							<th scope="col">Id</th>
							<th scope="col">Status</th>
							<th scope="col">Placed At</th>
							<th scope="col">Details</th>
						  </tr>
						</thead>
						<tbody>
							@foreach ($orders as $order)
								<tr>
									<td sope="row">{{ $order->id }}</td>
									<td>{{ $order->status->title }}</td>
									<td>{{ date_format($order->created_at, 'g:ia \o\n l jS F Y') }}</td>
									<td>
										<a href="{{ route('orders.show', $order->id) }}">
											Details
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
            </div>
            
			{{-- <div class="col-sm-4">
				<div class="contact-info">
					<h2 class="title text-center">Contact Info</h2> <address>
	    					<p>E-Shopper Inc.</p>
							<p>935 W. Webster Ave New Streets Chicago, IL 60614, NY</p>
							<p>Newyork USA</p>
							<p>Mobile: +2346 17 38 93</p>
							<p>Fax: 1-714-252-0026</p>
							<p>Email: info@e-shopper.com</p>
	    				</address>
					<div class="social-networks">
						<h2 class="title text-center">Social Networking</h2>
						<ul>
							<li> <a href="#"><i class="fa fa-facebook"></i></a> </li>
							<li> <a href="#"><i class="fa fa-twitter"></i></a> </li>
							<li> <a href="#"><i class="fa fa-google-plus"></i></a> </li>
							<li> <a href="#"><i class="fa fa-youtube"></i></a> </li>
						</ul>
					</div>
				</div>
			</div> --}}
		</div>
	</div>
</div>
<!--/#contact-page-->
@endsection

@section('javascript')
    
@endsection
@extends('admin.layout.master')

@section('page-header')
   @if ($status)
      {{ $status->title }} Orders
   @else
      All Orders
   @endif
@endsection

@section('content')
<div class="row">
   <div class="col-md-12">
      <div class="card">

         {{-- <div class="card-action">
               Orders for Book Name (used/new)
         </div> --}}

         <div class="card-content">

            {{-- Table --}}
            <div class="table-responsive">
               <table class="table  table-bordered table-hover" id="dataTables-example">
                  <thead>
                        <tr>
                           <th>ID</th>
                           <th>Status</th>
                           <th>Customer</th>
                           <th>Area</th>
                           <th>Updated At</th>
                           <th>Total</th>
                           <th>Details</th>
                           <th>Process Order</th>
                        </tr>
                  </thead>
                  <tbody>
                     @foreach ($orders as $order)
                        {{-- <tr class="{{ $colors[$order->status_id] }}"> --}}
                        <tr>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->id }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->status->title }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->user->name }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->area->title }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ date('d-m-Y', strtotime($order->updated_at)) }}</td>
                           <td class="{{ $colors[$order->status_id] }}">Tk. {{ $order->total }}</td>
                           <td>
                              <a href="{{ route('admin.orders.show', $order->id) }}">
                                 Details
                              </a>
                           </td>
                           <td>
                              <a href="{{ route('admin.orders.edit', $order->id) }}">
                                 Process Order
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
   <!-- /. ROW  -->
@endsection

@section('javascript')
   <script src="{{ asset('assets/admin') }}/assets/js/dataTables/jquery.dataTables.js"></script>
   <script src="{{ asset('assets/admin') }}/assets/js/dataTables/dataTables.bootstrap.js"></script>
   
@endsection

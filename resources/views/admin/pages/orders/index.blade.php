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
               All Orders
         </div> --}}

         <div class="card-content">

            {{-- Select --}}
            <div class="row">
               <form action="{{ route('admin.orders.index') }}" method="get">
                  <div class="input-field col s12">
                     <div class="form-group">
                        {{-- <label for="exampleFormControlSelect1">Example select</label> --}}
                        <select class="form-control" name="status" id="status" onchange="this.form.submit()">
                          <option value="0">All</option>

                          {{-- Checking for slected --}}
                          @if ($status)
                              @foreach ($statuses as $s)
                                 <option value="{{ $s->id }}" {{ $s->id == $status->id ? 'selected' : ''}}>
                                    {{ $s->title}}
                                 </option>
                              @endforeach
                          @else
                              @foreach ($statuses as $s)
                                 <option value="{{ $s->id }}">
                                    {{ $s->title}}
                                 </option>
                              @endforeach 
                          @endif
                        </select>
                      </div>
                  </div>
               </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
               <table class="table  table-bordered table-hover" id="dataTables-example">
                  <thead>
                        <tr>
                           <th>ID</th>
                           <th>Status</th>
                           <th>Customer</th>
                           <th>Area</th>
                           <th>Total</th>
                           <th>Placed At</th>
                           <th>Updated At</th>
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
                           <td class="{{ $colors[$order->status_id] }}">Tk. {{ $order->total }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->created_at }}</td>
                           <td class="{{ $colors[$order->status_id] }}">{{ $order->updated_at }}</td>
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

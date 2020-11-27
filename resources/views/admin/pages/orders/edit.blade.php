@extends('admin.layout.master')

@section('page-header')
  Process Order
@endsection

@section('content')
<div class="row">
   <div class="col-md-6">
      <div class="card"> 

         <div class="card-action">
            <a href="{{ url()->previous() }}">
               <span class="material-icons">arrow_back</span>
            </a>
         </div>
 
         <div class="card-content">
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
               @method('PUT')
               @csrf

               {{-- Showing Order ID & STatus --}}
               <div class="row">
                  <div class="input-field col s6">
                     <input name="order" id="order" type="text" value="{{ $order->id }}" readonly>
                     <label for="order" class="active" style="font-size: 80%">Order ID</label>
                  </div>
                  <div class="input-field col s6">
                     <input name="s{{ $order->id }}" id="s{{ $order->id }}" type="text" value="{{ $order->status->title }}" readonly>
                     <label for="s{{ $order->id }}" class="active" style="font-size: 80%">Status</label>
                  </div>
               </div>

               {{-- Select Option --}}
               <div class="row">
                  <div class="input-field col s12">
                     <select id="status" name="status" class="form-control" onchange="updateSubmitButton()">
                        <option value="0" selected>Select Status</option>
                        @foreach ($statuses as $status)
                           <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                     </select>
                     
                     @error('status')
                        <p style="color:red">{{ $message }}</p> 
                     @enderror
                     <p><label for="status" class="active" style="font-size: 80%">Status</label></p>
                  </div>
               </div>

               {{-- Submit Button --}}
               <div class="row">
                  <div class="input-field col s12">
                     <button type="submit" id="submitID" class="btn btn-primary btn-block" disabled>
                        Update Order Status
                     </button>
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

   <script>
      function updateSubmitButton() {
         if (document.getElementById('status').value > 0) {
            document.getElementById('submitID').disabled = false;
         } else {
            document.getElementById('submitID').disabled = true;
         }
      }
   </script>
   
@endsection

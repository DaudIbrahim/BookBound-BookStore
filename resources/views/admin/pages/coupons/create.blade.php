@extends('admin.layout.master')

@section('page-header')
  Create New Coupon
@endsection

@section('content')
<div class="row">
   <div class="col-lg-6">
      <div class="card">
         <div class="card-content">

            <form method="POST" action="{{ route('admin.coupons.store') }}" class="col-lg-11">

               @csrf
               
               <div class="row">

                  <div class="input-field col s12">&nbsp;</div>
                  <div class="input-field col s11">
                     <input type="text" name="code" id="code" value={{ old('code') ? old('code') : $code }} readonly>
                     <label for="code" class="active" style="font-size: 80%">Auto Generated Coupon Code</label>
                  </div>
                  <div class="input-field col s1">
                     <p>
                        <a onclick="event.preventDefault(); refresh();">
                           <i class="fa fa-refresh" aria-hidden="true" style="font-size: 180%; color: #26A69A;"></i>
                        </a>
                     </p>
                  </div>
                  
                  <div class="input-field col s12">&nbsp;</div>
                  <div class="input-field col s12">
                     <input id="percent" name="percent" type="text" placeholder="%" value="{{ old('percent') }}" />
                     <label for="percent" class="active" style="font-size: 80%">Percent</label>
                        @error('percent')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>
                  
                  <div class="input-field col s12">&nbsp;</div>
                  <div class="input-field col s12">
                     <input id="quantity" name="quantity" type="text" placeholder="10" value="{{ old('quantity') }}" />
                     <label for="quantity" class="active" style="font-size: 80%">Quantity</label>
                        @error('quantity')
                           <p style="color:red">{{ $message }}</p>
                        @enderror
                  </div>

                  <div class="input-field col s8">
                     <button type="submit" class="waves-effect waves-light btn">
                        <i class="material-icons left">add_circle</i>Add
                     </button>
                  </div>

               </div>
           </form>
         </div>
         <div class="clearBoth"><br/></div>
      </div>
   </div>
 </div>
@endsection

@section('javascript')
  <script>
      function refresh() {
         axios.get('/administrator/coupons/fetch/code')
         .then(response => {
            document.getElementById('code').value = response.data.data;
         })
         .catch((error) => {
            console.dir(error.response.data.status);}
         );
      }
  </script>
@endsection

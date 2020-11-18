@extends('customer.layout.master')

@section('content')
<div class="section" style="margin-bottom: 10%">
    <div class="container">
        <div class="row">

            {{-- THe Form --}}
            <div class="col-sm-9">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3>Shipping Details</h3><br>

                <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">

                    @csrf

                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" readonly>
                     </div>

                    <div class="form-group col-md-6">
                       <label for="email">Email Address</label>
                       <input type="email" class="form-control" id="email" name="email" value="{{ $email }}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <select id="city" name="city_id" class="form-control">
                          <option selected value="{{ $city->id }}">{{ $city->title }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="area">Area</label>
                        <select id="area" name="area_id" class="form-control">
                          @foreach ($city->areas as $area)
                            <option value="{{ $area->id }}">{{ $area->title }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                     <textarea name="address" id="address" spellcheck="false" placeholder="Address" style="margin-top: 0px; margin-bottom: 0px; height: 130px;" minlength="10" required></textarea>
                     @error('address')
                        <small style="color: red">{{ $message }}</small>
                     @enderror


                     <h3>Payment Details</h3><br>

                    {{-- <div class="form-group">
                        <label for="name_on_card">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
                    </div> --}}

                    {{-- Stripe Element --}}
                    <div class="form-group">
                        <label for="card-element">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          <!-- a Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    
                    <button type="submit" id="complete-order" class="btn btn-primary btn-lg btn-block">Complete Order</button>
                </form>
            </div>

            {{-- Checkout Summary --}}
            <div class="col-sm-3 padding-right">
                <table class="table">
                    <h3>Checkout Summary</h3>
                    <tbody>
                       <tr>
                          <td>Subtotal</td>
                          <td class="text-right" id="subtotal">{{ $subtotal }} TK.</td>
                       </tr>
                       <tr>
                          <td>Shipping</td>
                          <td class="text-right" id="shipping">{{ $shipping }} TK.</td>
                       </tr>
                       <tr>
                           @if ($discount)
                            <td>Discount</td>
                            <td class="text-right" id="shipping">{{ $discount }} TK.</td>
                           @endif
                       </tr>
                       <tr>
                          <td>Payable Total</td>
                          <td class="text-right" id="shipping">{{ $total }} TK.</td>
                       </tr>
                    </tbody>
                 </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script src="{{ asset('js/card.js') }}"></script>

    <script>
        var options = {
        name: document.getElementById('name').value,
        address_line1: document.getElementById('address').value,
  }
  
  console.log(options);
  
</script>
@endsection
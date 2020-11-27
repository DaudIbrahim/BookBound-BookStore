@extends('customer.layout.master')

@section('content')


@if (Cart::count() == 0)

    {{-- TESTING --}}
    @if (session('order_id'))
        <div class="container">
            <div class="alert alert-success">
                <strong>{{ session('order_success') }}</strong>
            </div>
            <div class="alert alert-success">
                Order ID - <strong>{{ session('order_id') }}</strong>
            </div>
        </div>
    @endif
    {{-- TESTING --}}


    @if (session('message-danger'))
        <div class="container">
            <div class="alert alert-danger">
                <strong>{{ session('message-danger') }}</strong>
            </div>
        </div>
    @endif

    <div align="center">
        <h1>Your Cart is Empty!</h1>
        <p class="sub-title">Looks like you haven't add anything yet.</p>
        <a href="{{ route('books.index') }}" class="btn">Continue To Shopping</a>
    </div>
@endif


@if (Cart::count() != 0)
    <section id="cart_items">
        <div class="container">

            

            @if (session('message-danger'))
                <div class="alert alert-danger">
                    <strong>{{ session('message-danger') }}</strong>
                </div>
            @endif

            @if (session('message-success'))
                <div class="alert alert-success">
                    <strong>{{ session('message-success') }}</strong>
                </div>
            @endif

            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Book</td>
                            <td class="description"></td>
                            <td class="price">Price</td>
                            <td class="quantity">Quantity</td>
                            <td class="total">Total</td>
                            <td>Delete</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $row)
                            <tr>
                                <td class="cart_product">
                                    <a href="{{ route('books.details', [$row->model->book->id]) }}">
                                        <img src="{{ $row->model->book->image }}" alt="">
                                    </a>
                                </td>
                                <td class="cart_description">
                                    <h4>
                                        <a href="{{ route('books.details', [$row->model->book->id]) }}">
                                            {{ $row->model->book->title }}
                                        </a>
                                    </h4>
                                    <p>Condition: <strong>{{ $row->model->is_used ? 'Used' : 'New '}}</strong></p>
                                </td>
                                <td class="cart_price">
                                    <p>Tk. {{ number_format($row->model->price) }}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_up" href="" onclick="event.preventDefault(); document.getElementById('{{ 'addqty-' . $row->rowId }}').submit();" disable> + </a>
                                        <form id="{{ 'addqty-' . $row->rowId }}" action="{{ route('cart.update', $row->rowId) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $row->qty + 1 }}">
                                        </form>

                                        <input class="cart_quantity_input" type="text" name="quantity" value="{{ $row->qty }}" autocomplete="off" size="2" readonly>

                                        <a class="cart_quantity_up" href="" onclick="event.preventDefault(); document.getElementById('{{ 'subqty-' . $row->rowId }}').submit();"> - </a>
                                        <form id="{{ 'subqty-' . $row->rowId }}" action="{{ route('cart.update', $row->rowId) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $row->qty - 1 }}">
                                        </form>

                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">Tk. {{ number_format($row->qty * $row->price) }}</p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="#" onclick="event.preventDefault(); document.getElementById('{{ 'delete-' . $row->rowId }}').submit();">
                                        <i class="fa fa-times-circle" style="color: black"></i>
                                    </a>
                                    <form id="{{ 'delete-' . $row->rowId }}" action="{{ route('cart.destroy', $row->rowId) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="heading">

                @guest
                    <div class="alert alert-warning">
                        <strong>
                            <a href="">Login</a>/<a href="">Signup</a>
                            to Checkout & Confirm Order
                        </strong>
                    </div>
                @endguest

                @auth
                    @if (Auth::user()->is_admin)
                        <div class="alert alert-danger">
                            <strong>
                                Administrator restricted to checkout.
                            </strong>
                        </div>
                    @endif
                @endauth

            <h3>Summary</h3>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                           <li>Subtotal
                               <span>{{ number_format(Cart::subtotal()) }} TK.</span>
                            </li>
                            <li>
                                Shipping <span>+50 TK.</span>
                             </li>
                            @if (session('coupon'))
                                <li>
                                    Discount {{ session('coupon')->percent }}%
                                    <span>- {{ $discount = ceil(Cart::subtotal() * (session('coupon')->percent / 100)) }} TK.</span>
                                </li>
                            @endif
                           <li>
                               Total
                               <span>{{ isset($discount) ? Cart::subtotal() -$discount + 50 : Cart::subtotal() + 50 }} TK.</span>
                            </li>
                        </ul>
                        <a class="btn btn-default update" href="#" onclick="event.preventDefault(); extraScroll('header')" style="background-color: #FE980F; color: white;">
                            View Items in Cart
                        </a>
                        <a class="btn btn-default update" href="{{ route('checkout.index') }}" style="background-color: #FE980F; color: white;">
                            Proceed to Checkout
                        </a>
                     </div>
                </div>
                <div class="col-sm-6">

                    {{-- Coupons --}}
                    <div class="chose_area">
                        <ul class="user_option">
                           <li>
                              <h4>Add Promo code or Gift voucher </h4>
                           </li>
                        </ul>

                        <form action="{{ route('coupon.apply') }}" method="GET">
                            <ul class="user_info">
                                <li class="">

                                    {{-- Input Field --}}
                                    @if (!session()->has('coupon'))
                                        <input type="text" id="code" name="code" placeholder="{{ old('code') }}" required>
                                     @endif
                                     @if (session()->has('coupon'))
                                        <input type="text" id="code" name="code" value="{{ session()->get('coupon')->code }}" readonly>
                                     @endif

                                    {{-- Error Message --}}
                                     @error('code')
                                         <small style="color: red">{{ $message }}</small>
                                     @enderror
                                     @if (session()->has('coupon'))
                                        <small style="color: green">Coupon Applied Successfully</small>
                                     @endif
                                </li>
                                <li>

                                    {{-- Apply/Remove Coupon Button --}}
                                    @if (!session()->has('coupon'))
                                        <button type="submit" class="btn btn-default">Apply Coupon</button>
                                     @endif
                                    @if (session()->has('coupon'))
                                        <a href="{{ route('coupon.remove') }}">Remove Coupon</a>
                                    @endif

                                </li>
                             </ul>
                        </form>

                     </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            // extraScroll('cart_items');
        });

        @error('code')
            extraScroll('do_action');
        @enderror

        @if (session()->has('validcoupon') || session()->has('reomvecoupon'))
            extraScroll('do_action');
        @endif

        function extraScroll(id)
        {
            document.getElementById(id).scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
        }
    </script>
@endsection
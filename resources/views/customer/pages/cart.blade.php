@extends('customer.layout.master')

@section('content')


@if (Cart::count() == 0)
    <div class="text-center" style="margin-bottom: 10%">
        <h1 class="title">Your Cart is Empty!</h1>
        <p class="sub-title">Looks like you haven't made order yet.</p>
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
                <h3>Checkout Summary</h3>
                <p>Go to Shipping Page? </p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                           <li>Cart Sub Total 
                               <span>{{ number_format(Cart::subtotal()) }} TK.</span>
                            </li>
                           <li>
                               Shipping Cost <span>50 TK.</span>
                            </li>
                           <li>
                               Total 
                               <span>{{ number_format((Cart::subtotal() + 50)) }} TK.</span>
                            </li>
                        </ul>
                        <a class="btn btn-default update" href="#">
                            Go to Shipping Page
                        </a>
                     </div>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        </div>
    </section>
@endif

@endsection

@section('javascript')
    <script>
        
    </script>
@endsection
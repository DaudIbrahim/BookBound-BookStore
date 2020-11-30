<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\City;
use App\Stock;
use App\Coupon;
use App\Order;
use App\Status;

// use App\Http\Requests\CheckoutRequest;

use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

class CustomerCheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('customer');
    }

    /**
     * Show the Checkout Page
     * 
     * One Important Note
     * Unlike Cart Controller relying on View
     * 
     * Customer Checkout Controller Will
     * Pass Everything to the View via The Controller
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Empty Cart Redirect
        if (Cart::count() == 0) {
            session()->forget('coupon');
            return redirect()->route('home'); 
        }

        // Check if Stock is still available
        $out_of_stock = false;
        $out_of_stock_message = "";

        foreach (Cart::content() as $row) {
            if ($row->model->quantity === 0) {
                $out_of_stock = true;
                $out_of_stock_message .= "$row->name, ";
                Cart::remove($row->rowId);
            }
        }

        // Redirect if out of stock
        if ($out_of_stock) {
            return redirect()->route('cart.index')->with('message-danger', "Out of Stock - $out_of_stock_message Removed from Cart");
        }

        // Coupon Validity Check
        if (session()->get('coupon')) {
            if ($coupon = Coupon::where('code', session()->get('coupon')->code)->first()) {
                if ($coupon->isExpired()) {
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->withErrors(["code" => "Expired Coupon"])->withInput(["code" => $coupon->code]);
                }
            }
        }
        
        $city = City::findOrFail('1');
        $name = Auth::user()->name;
        $email = Auth::user()->email;

        $subtotal = (int)ceil(Cart::subtotal());
        $shipping = 50;
        $discount = session('coupon') ? (int)ceil($subtotal * (session('coupon')->percent / 100)) : 0;
        $total = $subtotal + $shipping - $discount;

        $pass = compact('city', 'name', 'email', 'subtotal', 'shipping', 'discount', 'total');
        return view('customer.pages.checkout', $pass);
    }

    /**
     * Make Payment and Process Order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'address' => 'min:10|max:100|string'
        ]);

        // Validation Fail
        if ($validator->fails()) { return redirect()->route('checkout.index')->withErrors($validator)->withInput(); }

        // Empty Cart? | Rmove Coupon | Redirect
        if (Cart::count() == 0) {
            session()->forget('coupon');
            return redirect()->route('home'); 
        }

        /**
         * Checking Available Stock One Last Time (Where it all started)
         */
        $out_of_stock = false;
        $out_of_stock_message = "";

        foreach (Cart::content() as $row) {
            if ($row->model->quantity === 0) {
                $out_of_stock = true;
                $out_of_stock_message .= "$row->name, ";
                Cart::remove($row->rowId);
            }
        }

        // Redirect if out of stock
        if ($out_of_stock) {
            return redirect()->route('cart.index')->with('message-danger', "Out of Stock - $out_of_stock_message Removed from Cart");
        }

        // Coupon Validity Check
        if (session()->get('coupon')) {
            if ($coupon = Coupon::where('code', session()->get('coupon')->code)->first()) {
                if ($coupon->isExpired()) {
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->withErrors(["code" => "Expired Coupon"])->withInput(["code" => $coupon->code]);
                }
            }
        }

        // Cart Calculations
        $subtotal = (int)ceil(Cart::subtotal());
        $shipping = 50;
        $discount = session('coupon') ? (int)ceil($subtotal * (session('coupon')->percent / 100)) : 0;
        $total = $subtotal + $shipping - $discount;

        // Payment 💵💶💷💰
        try {
            $charge = Stripe::charges()->create([
                'amount' => $total,
                'currency' => 'USD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
            ]);

            $order_id = $this->processOrder($request->all(), $charge['id']);
            
            return redirect()->route('orders.show', $order_id)->with([
                'order_success' => 'Thank you! Your payment has been Successfully Accepted! & Your order has been Placed'
            ]);
            
        } catch (CardErrorException $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }

    }

    /**
     * Order Processing
     * Make All Necessary changes in DataBase
     * 
     */
    public function processOrder(Array $request, $transaction_id)
    {
        $subtotal = (int)ceil(Cart::subtotal());
        $shipping = 50;
        $discount = session('coupon') ? (int)ceil($subtotal * (session('coupon')->percent / 100)) : 0;
        $total = $subtotal + $shipping - $discount;
        
        $order = New Order;
        
        # status_id FK
        $order->status_id = Status::where('title', 'Approved')->first()->id;
        
        # user_id FK
        $order->user_id = Auth::user()->id;

        # area_id FK
        $order->area_id = (int)$request['area_id'];
        
        # coupon_id FK
        $order->coupon_id = session()->has('coupon') ? session()->get('coupon')->id : NULL;
        
        # Remaining Information - transaction_id, address, subtotal, shipping, discount, total
        $order->transaction_id = $transaction_id;
        $order->address = $request['address'];
        $order->subtotal = $subtotal;
        $order->shipping = $shipping;
        $order->discount = $discount;
        $order->total = $total;

        # Save Order
        $order->save();

        # Reduce Coupon Quantity in database
        if ($order->coupon_id) {
            $coupon = Coupon::find($order->coupon_id);
            $coupon->quantity -= 1;
            $coupon->save();
        }
        
        # Pivot Create | Reduce Stock Quantity in database
        $pivot = array();
        foreach (Cart::content() as $row) {    
            $pivot[$row->id] = ['quantity' => $row->qty, 'price' => $row->price];            
            $stock = Stock::findOrFail($row->id);
            $stock->quantity -= $row->qty;            
            $stock->save();
        }

        # Pivot Attach
        $order->stocks()->attach($pivot);

        # Destroy Cart
        Cart::destroy();

        # Remove Coupon
        session()->forget('coupon');

        # Stripe Meta Data (Transaction id)
        $order->refresh();
        $charge = Stripe::charges()->update($transaction_id, [
            'metadata' => [
                'order_id' => $order->id,
                'user_email' => Auth::user()->email,
                'user_name' => Auth::user()->name,
            ]
        ]);

        # Return
        return $order->id;
    }

}

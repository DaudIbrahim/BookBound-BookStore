<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Order;

class CustomerOrderController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('customer.pages.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        /**
         * Authorization
         * Establishing the rights and privileges of a user.
         * In this case User has the right to see only his order
         */
        if ($order->user_id !== Auth::user()->id) {
            return redirect()->route('home');
        }
        
        # Authorized
        return view('customer.pages.orders.show', compact('order'));
    }

}

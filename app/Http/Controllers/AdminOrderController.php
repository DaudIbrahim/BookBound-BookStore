<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Order;
use App\Status;
use App\Stock;

class AdminOrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Orders are Eager Loaded by Default
     * Defined with a $with property on the Order Model
     * Specify columns order.id
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|numeric'
        ]);
        
        // Validation Fail
        if ($validator->fails()) { return redirect()->route('admin.orders.index'); }
        
        $orders = Order::orderBy('updated_at', 'desc');
        $status = Status::find($request->get('status'));
        $statuses = Status::get();
        $colors = ['zero', 'info', 'warning', 'success'];

        if ($status) {
            $orders = $orders->where('status_id', $status->id)->get();
        } else {
            $orders = $orders->get();
        }
        
        return view('admin.pages.orders.index', compact('orders', 'statuses', 'status', 'colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('admin.pages.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $statuses = Status::where('id', '>', $order->status_id)->get();
        return view('admin.pages.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|exists:statuses,id'
        ]);

        // Validation Fail
        $order = Order::findOrFail($id);
        if ($validator->fails()) {
            return redirect()->route('admin.orders.edit', $request->get('order'))->withErrors($validator);
        } elseif ($request->get('status') <= $order->status_id) {
            return redirect()->route('admin.orders.edit', $request->get('order'))->withErrors(['status' => 'The selected status is invalid.']);
        }
        
        $order->status_id = $request->get('status');
        $order->save();
    
        return redirect()->route('admin.orders.show', $order->id)->with('updatesuccess', 'Order Status Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('AT DESROY');
    }

    /**
     * Access Orders for Specific Stock
     * Book. New or Used orders
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stock($id)
    {
        // Discontinued - Orders of Book Shown at - 'AdminBookController@show'
        // Discovered Error Eager Loading Both Stock & Orders
        $stock = Stock::with('orders')->findOrFail($id);
        $orders = $stock->orders;
        return $stock;
    }

}

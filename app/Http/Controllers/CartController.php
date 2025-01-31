<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Coupon;

use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
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
        if (Cart::count() == 0) { session()->forget('coupon'); }
        if (session()->get('coupon')) {
            if ($coupon = Coupon::where('code', session()->get('coupon')->code)->first()) {
                if ($coupon->isExpired()) {
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->withErrors(["code" => "Expired Coupon"])->withInput(["code" => $coupon->code]);
                }
            }
        }

        // Full/Empty Cart is dealt in View
        return view('customer.pages.cart');
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
        $validatedData = $request->validate([
            'stock_id' => 'required',
        ]);

        $stock = Stock::findOrFail($validatedData['stock_id']);

        // Cart - id, name, quantity, price
        Cart::add($stock->id, $stock->book->title, 1, $stock->price)->associate('App\Stock');

        return redirect()->route('books.details', [$stock->book->id])->with('message', 'Item Added to Cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validatedData = $request->validate([
            'qty' => 'numeric|required'
        ]);

        // Quantity Limits (1 to 5)
        if ($validatedData['qty'] == 0) { return back()->with('message-danger', 'Please enter a value greater than or equal to 1'); }
        if ($validatedData['qty'] == 6) { return back()->with('message-danger', 'Max 5 Copies can be Purchased at a Time'); }
        
        $stock = Stock::findOrFail(Cart::get($id)->id);

        // If stock available
        if ($stock->quantity >= $validatedData['qty']) {
            Cart::update($id, $validatedData['qty']);
            return back()->with('message-success', 'Quantity Updated Successfully');
        } else {
            // Out of Stock
            $quantity = $stock->quantity;
            return back()->with('message-danger', "Fail to Add to Cart. Only $quantity copies avalialable in Stock");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        if (Cart::count() == 0) { session()->forget('coupon'); }
        return back()->with('message-success', 'Item Removed From Cart');
    }
}

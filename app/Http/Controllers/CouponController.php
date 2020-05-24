<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponController extends Controller
{
    /**
     * Apply Coupon
     */
    public function apply(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required',
        ]);

        $coupon = Coupon::where('code', $validatedData['code'])->get();

        // Invalid
        if ($coupon->isEmpty()) {
            session()->has('coupon') ?  session()->forget('coupon') : '';
            return redirect()->route('cart.index')->withErrors(["code" => "true"])->withInput();
        }

        // Valid
        session()->put('coupon', $coupon[0]);
        return redirect()->route('cart.index')->with('validcoupon', 'Valid Coupon - Scroll into View');
    }

    /**
     * Remove Coupon
     */
    public function remove(Request $request)
    {
        session()->has('coupon') ?  session()->forget('coupon') : '';
        return redirect()->route('cart.index')->with('reomvecoupon', 'Remove Coupon - Scroll into View');
    }

}

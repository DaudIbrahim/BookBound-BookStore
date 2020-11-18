<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Coupon;

class CouponController extends Controller
{
    /**
     * Apply Coupon
     */
    public function apply(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|alpha_num',
        ]);

        $coupon = Coupon::where('code', $validatedData['code'])->first();
        
        // Invalid Coupon (Not found in Database)
        if (!$coupon) {
            session()->forget('coupon');
            return redirect()->route('cart.index')->withErrors(["code" => "Invalid Coupon"])->withInput();
        }

        // Expired Coupon (Found in Database but quantity = 0)
        if ($coupon->isExpired()) {
            session()->forget('coupon');
            return redirect()->route('cart.index')->withErrors(["code" => "Expired Coupon"])->withInput();
        }

        // Valid Coupon (Found in Database & quantity >= 1) ✔
        if (!$coupon->isExpired()) {
            session()->put('coupon', $coupon);
            return redirect()->route('cart.index')->with('validcoupon', 'Valid Coupon - Scroll into View');
        }
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

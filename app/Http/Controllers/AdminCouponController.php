<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class AdminCouponController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::get();
        return view('admin.pages.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code = (new Coupon)->idGenerate();
        return view('admin.pages.coupons.create', compact('code'));
    }

    /**
     * Return the Auto Generated Code
     */
    public function code()
    {
        $code = (new Coupon)->idGenerate();
        $data = [
            'status' => 'success',
            'code'   => '200',
            'data'   => $code,
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validatedData = $request->validate([
            'code' => 'required|unique:coupons|min:4|max:255',
            'percent' => 'required|numeric|min:10|max:50',
            'quantity' => 'required|numeric|min:10|max:50',
        ]);

        $coupon = new Coupon($validatedData);

        if ($coupon->save()) {
            return redirect()->route('admin.coupons.index')->with('message', 'Coupon Created Successfully!');
        } else {
            $error = "Internal Error During Store Operation";
            return redirect()->route('admin.coupons.create')->withErrors(["title" => $error])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'AdminCouponController';
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

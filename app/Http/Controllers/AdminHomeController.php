<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Category;
use App\SubCategory;
use App\Author;
use App\Book;
use App\Stock;
use App\City;
use App\Coupon;
use App\Status;
use App\Order;
use App\Review;

class AdminHomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sales = Order::sum('total');
        $approved = Order::where('status_id', 1)->count();
        $shipping = Order::where('status_id', 2)->count();
        $completed = Order::where('status_id', 3)->count();
        $books = Book::count();
        $stocks = Stock::sum('quantity');
        $coupons = Coupon::where('quantity', '>=', 1)->sum('quantity');
        $users = User::get()->count() - 1;
        

        return view('admin.pages.index', compact([
            'sales',
            'approved',
            'shipping',
            'completed',
            'books',
            'stocks',
            'coupons',
            'users',
        ]));
    }
}

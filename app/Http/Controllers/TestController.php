<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Category;
use App\SubCategory;
use App\Author;
use App\Book;
use App\Stock;
use App\City;
use App\Coupon;

use Scriptotek\GoogleBooks\GoogleBooks;
use Gloudemans\Shoppingcart\Facades\Cart;


class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        /**
         * Authentication
         */
        // return Auth::check() ? 'LoggedIn' : 'Out';
        // $message = "Not Logged In ❌ ";

        // if(Auth::user()) {
        //     $message = "You are Logged in - ";
        //     $message .= Auth::user()->is_admin ? "As Admin" : "As Customer";
        //     $message .= " ✔ ";
        // }
    
        // return $message;

        /**
         * Google Books
         */
        // $isbn = '152903566X';
        // $books = new GoogleBooks(['country' => 'NO']);


        // try {
        //     $volume = $books->volumes->byIsbn($isbn);
        // } catch (Exception $e) {
        //     $volume = null;
        // }

        // $completeInfo = true;
        // $a = array();

        // if ($volume) {
        //     $a["isbn_10"] = null;
        //     $a["isbn_13"] = null;

        //     if (isset($volume->volumeInfo->industryIdentifiers[0])) {
        //         $a[strtolower($volume->volumeInfo->industryIdentifiers[0]->type)]
        //         = $volume->volumeInfo->industryIdentifiers[0]->identifier ?? null;
        //     }

        //     if (isset($volume->volumeInfo->industryIdentifiers[1])) {
        //         $a[strtolower($volume->volumeInfo->industryIdentifiers[1]->type)]
        //         = $volume->volumeInfo->industryIdentifiers[1]->identifier ?? null;
        //     }

        //     $a["title"] = ($volume->volumeInfo->title) ?? null;
        //     $a["image"] = ($volume->volumeInfo->imageLinks->thumbnail) ?? null;

        //     // Second Info
        //     $a["published_date"] = ($volume->volumeInfo->publishedDate) ?? null;
        //     $a["description"] = ($volume->volumeInfo->description) ?? null;
        //     $a["page_count"] = ($volume->volumeInfo->pageCount) ?? null;
        //     $a["lang"] = ($volume->volumeInfo->language) ?? null;

        //     // FK
        //     $a["category"] = 1;
        //     $a["author"] = ($volume->volumeInfo->authors[0]) ?? null;
        //     $a["publisher"] = ($volume->volumeInfo->publisher) ?? null;

        //     // Complete Info
        //     foreach ($a as $key => $value) {
        //         if ($value === null) {
        //             $completeInfo = false;
        //             break;
        //         }
        //     }
        // }


        // if ($volume && $completeInfo) {
        //     return json_encode($a);
        // } else {
        //     $a = array();
        //     return json_encode($a);
        // }
        

        /**
         * Handling Session In Laravel
         */
        // session()->put('friends', ["S" => "Solayman", "U" => "Umar"]);
        // return session()->get('friends');
        // session()->forget('friends');
        // return session()->get('friends') ?? 'False - Empty session';
        // return session()->forget('google_book');
        // return session()->get('google_book') ?? 'False - 114';
        // session()->put('coupon', 'CC');
        return session()->get('coupon');



        /**
         * Testing Relationship
         */
        // $category = Category::findOrFail('1');
        // return $category->books[0]->author;

        // $author = Author::first();
        // return $author->books;

        // $book = Book::findOrFail('1');
        // dd($book);
        // return $book->subcategory;
        // return $book->author;

        // dd($book->subcategory->category);
        // dd($book->getCategory());
        // dd($book->category);

        /**
         * Creating a City Only Dhaka
         */
        // $city = City::findOrFail('1');
        // return $city;

        /**
         * SLug helper by Laravel Framework
         */
        // $slug = Str::slug('Laravel 5 Framework', '-');
        // return $slug;


        /**
         * Rollbacking DB to fix mistake
         * Now - Books has New & Used Stocks
         */
        // $book = Book::findOrFail('1');
        // dd($book->usedStock());

        // /**
        //  * Stock
        //  */
        // $stock = Stock::findOrFail('1');
        // $x = $stock->getBuyableIdentifier() . '<br>';
        // $x .= $stock->getBuyableDescription() . '<br>';
        // $x .= $stock->getBuyablePrice() . '<br>';
        // return $x;

        /**
         * Cart
         */
        // return Cart::get('1');
        // $x = Cart::search(function ($cartItem, $rowId) {
        //     return $cartItem->id === 1;
        // });

        // $rowId  = "027c91341fd5cf4d2579b49c4b6a90da";
        // return Cart::get($rowId);

        // return $x;
        // return Cart::subtotal();

        // Cart::destroy();return;

        
        // return Cart::tax();
        // dd(Cart::content());
        // $cart = Cart::content()->firstWHere('id', '1');
        // dd($cart);
        // return $cart->firstWhere('name', 'Permanent Record');


        /**
         * CSRF TOKEN FOR API TESTER
         */
        // return csrf_token();


        /**
         * Random Number & Letter Generator
         * ReferenceWeb - https://www.php.net/manual/en/function.rand.php
         */
        // $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) ); 
        // $random_string = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
        // return $random_number . $random_string;

        /**
         * Get current AUTO_INCREMENT value for any table
         * ReferenceWeb - https://stackoverflow.com/a/15821543/7031530
         * 
         * SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES 
         * WHERE TABLE_SCHEMA = 'DatabaseName' AND   TABLE_NAME   = 'TableName';
         */
        // $db = env('DB_DATABASE');
        // $select = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES ";
        // $select .= "WHERE TABLE_SCHEMA = '$db' AND   TABLE_NAME   = 'coupons'";
        
        // $x = (DB::select($select)[0]);
        // return $x->AUTO_INCREMENT;


    }

    public function api($boolean = false) {


        if ($boolean) {
            $data = [
                'status' => 'success',
                'code'   => '200',
                'data'   => $boolean,
            ];
            return response()->json($data, 200);
        } elseif (!$boolean) {
            $data = [
                'status'  => 'error',
                'code'    => '404',
                'message' => 'Error occurred.',
            ];
            return response()->json($data, 404);
        }

    
        

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Review;

class CustomerReviewController extends Controller
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
        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'book' => 'required|exists:books,id',
            'description' => 'required|string|min:3|max:100',
            'rating' => 'required|integer|between:1,5'
        ]);

         // Validation Fail
         if ($validator->fails()) { 
            return redirect()->route('books.details', [$request->book, 'review' => true])->withInput()->withErrors($validator);
        }

        $review = new Review;
        $review->user_id = Auth::user()->id;
        $review->book_id = $request->get('book');
        $review->description = $request->get('description');
        $review->rating = $request->get('rating');
        $review->save();

        return redirect()->route('books.details', [$request->book, 'review' => true]);



    }

}

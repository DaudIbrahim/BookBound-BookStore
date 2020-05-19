<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::get();
        return view('customer.pages.test', compact('books'));
    }

    /**
     * Display Details of A Book
     */
    public function details($id)
    {
        $book = Book::findOrFail($id);
        return view('customer.pages.books.details', compact('book'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Scriptotek\GoogleBooks\GoogleBooks;

use App\Category;
use App\SubCategory;
use App\Author;
use App\Book;

class AdminBookController extends Controller
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
        $books = Book::get();
        return view('admin.pages.books.index', compact('books'));
    }

    /**
     * Show the search form and its errors.
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'min:10|max:14'
        ]);

        // No ISBN Just View Page.
        if (!$request->has('isbn')) {
            return view('admin.pages.books.search');
        }

        // Validation Fail
        if ($validator->fails()) {
            return redirect()->route('admin.books.search')->withErrors($validator)->withInput();
        }

        // Pass Validator & Has ISBN.
        if (!$validator->fails() && $request->has('isbn')) {

            // Must Check Google API
            $google_book = ($this->getBookFromApi($request->input('isbn')));

            // Not found in Google API.
            if (!$google_book) {
                $error = "Book not found in Google API. Please try with a different Identifier.";
                return redirect()->route('admin.books.search')->withErrors(["isbn" => $error])->withInput();
            }

            // Found in Google API
            if ($google_book) {
                // Check if Already in Database.
                $book = Book::where('title', $google_book['title'])->first();
                if ($book) {
                    $message = "Book already exists in Database.";
                    return redirect()->route('admin.books.show', ["book" => $book->id])->with('message', $message);
                }

                // Not in Database add to Session.
                session()->put('google_book', $google_book);
                return redirect()->route('admin.books.create');
            }
        }
    }


     /**
     * Show the form for creating a new book.
     * Form data filled via Google Books API call, saved in session('google_book')
     * Deal with form processing and storing the book into the Database
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No session('google_book) redirect
        if (!session()->has('google_book')) { return redirect()->route('admin.books.search'); }
        $categories = Category::has('subcategories')->get();
        return view('admin.pages.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // No session('google_book) redirect
        if (!session()->has('google_book')) { return redirect()->route('admin.books.search'); }

        // Validator
        $validatedData = $request->validate([
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:subcategories,id',
            'new_price' => 'numeric|required|min:100|max:9999',
            'new_quantity' => 'numeric|required|min:10|max:50',
            'used_price' => 'numeric|required|min:100|max:9999',
            'used_quantity' => 'numeric|required|min:10|max:50',
        ]);

        $google_book = session()->get('google_book');
        $book = Book::where('title', $google_book['title'])->first();

        if ($book !== null) {
            return "<h1 style='color: red'>" . $google_book['title'] . " Already is in Database</h1>";
        }

        if ($book === null) {
            $author = Author::firstOrCreate(['title' => $google_book['author']]);
            $book = new Book($google_book);
            $book->subcategory_id = request()->input('subcategory');
            $book->author_id = $author->id;
            $book->new_price = request()->input('new_price');
            $book->new_quantity = request()->input('new_quantity');
            $book->used_price = request()->input('used_price');
            $book->used_quantity = request()->input('used_quantity');

            if ($book->save()) {
                session()->forget('google_book');
                $message = 'Boook Added successfully.';
                return redirect()->route('admin.books.show', ["book" => $book->id])->with('message', $message);
            }
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
        $book = Book::findOrFail($id);
        return view('admin.pages.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::has('subcategories')->get();
        $book = Book::findOrFail($id);
        $redirectFromCreate = session()->has('message') ? session()->get('message') : null;

        
        return view('admin.pages.books.edit', compact('categories', 'book', 'redirectFromCreate'));
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
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:subcategories,id',
            'new_price' => 'numeric|required|min:100|max:9999',
            'new_quantity' => 'numeric|required|min:0|max:50',
            'used_price' => 'numeric|required|min:100|max:9999',
            'used_quantity' => 'numeric|required|min:0|max:50',
        ]);

        $book = Book::findOrFail($id);
        $book->subcategory_id = request()->input('subcategory');
        $book->new_price = request()->input('new_price');
        $book->new_quantity = $book->new_quantity + request()->input('new_quantity');
        $book->used_price = request()->input('used_price');
        $book->used_quantity = $book->used_quantity + request()->input('used_quantity');

        if ($book->update()) {
            return redirect()->route('admin.books.show', ["book" => $book->id])->with('message', 'Update Successful!');
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
        //
    }


    /**
     * Google Books API
     */
    public function getBookFromApi($isbn = '')
    {
        // Instantiate Google Books.
        $books = new GoogleBooks(['country' => 'NO']);
        
        // Make API Call.
        try {
            $volume = $books->volumes->byIsbn($isbn);
        } catch (Exception $e) {
            $volume = null;
        }

        // Declaring Variables.
        $completeInfo = true;
        $a = array();

        // Checking if Volume has complete info; Copy into new array.
        if ($volume) {
            $a["isbn_10"] = null;
            $a["isbn_13"] = null;

            if (isset($volume->volumeInfo->industryIdentifiers[0])) {
                $a[strtolower($volume->volumeInfo->industryIdentifiers[0]->type)]
                = $volume->volumeInfo->industryIdentifiers[0]->identifier ?? null;
            }

            if (isset($volume->volumeInfo->industryIdentifiers[1])) {
                $a[strtolower($volume->volumeInfo->industryIdentifiers[1]->type)]
                = $volume->volumeInfo->industryIdentifiers[1]->identifier ?? null;
            }

            $a["title"] = ($volume->volumeInfo->title) ?? null;
            $a["image"] = ($volume->volumeInfo->imageLinks->thumbnail) ?? null;

            // Second Info
            $a["published_date"] = ($volume->volumeInfo->publishedDate) ?? null;
            $a["description"] = ($volume->volumeInfo->description) ?? null;
            $a["page_count"] = ($volume->volumeInfo->pageCount) ?? null;
            $a["lang"] = ($volume->volumeInfo->language) ?? null;

            // FK
            $a["category"] = 1;
            $a["author"] = ($volume->volumeInfo->authors[0]) ?? null;
            $a["publisher"] = ($volume->volumeInfo->publisher) ?? null;

            // Complete Info
            foreach ($a as $key => $value) {
                if ($value === null) {
                    $completeInfo = false;
                    break;
                }
            }
        }

        // Return array if completeinfo else false
        if ($volume && $completeInfo) {
            return $a;
        } else {
            return false;
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Scriptotek\GoogleBooks\GoogleBooks;

use App\Category;
use App\SubCategory;
use App\Author;
use App\Book;
use App\Stock;

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
                // $book = Book::where('isbn_13', $google_book['isbn_13'])->first();
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
     * Search by Title
     * 15-Nov-20
     */
    public function searchByTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'min:1|max:25|string'
        ]);

        // Validation Fail
        if ($validator->fails()) {
            return redirect()->route('admin.books.search.title')->withErrors($validator)->withInput();
        }
        
        // Google API
        $books = new GoogleBooks(['country' => 'NO', 'maxResults' => 10]);
        $title = $request->title;
        $books_array = array();

        // (Code Repeat)
        if ($title) {
            foreach ($books->volumes->search($title) as $volume) {
            
                $completeInfo = true;
                $a = array();
    
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
                
                if ($completeInfo) {
                    array_push($books_array, $a);
                    continue;
                }
    
            }
        }

        return view('admin.pages.books.searchtitle', compact('title', 'books_array'));

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
            'new_quantity' => 'numeric|required|min:5|max:50',
            'used_price' => 'numeric|required|min:100|max:9999',
            'used_quantity' => 'numeric|required|min:5|max:50',
        ]);

        $google_book = session()->get('google_book');
        // $book = Book::where('isbn_13', $google_book['isbn_13'])->first();
        $book = Book::where('title', $google_book['title'])->first();

        if ($book !== null) {
            return "<h1 style='color: red'>" . $google_book['title'] . " Already is in Database</h1>";
        }

        if ($book === null) {

            // Find/Create The Author.
            $author = Author::firstOrCreate(['title' => $google_book['author']]);

            // Create The Book.
            $book = new Book($google_book);
            $book->subcategory_id = request()->input('subcategory');
            $book->author_id = $author->id;
            $book->save();
            
            // Assign New Stock
            $new_stock = new Stock();
            $new_stock->is_used = false;
            $new_stock->book_id = $book->id;
            $new_stock->price = request()->input('new_price');
            $new_stock->quantity = request()->input('new_quantity');

            // Assign Used Stock
            $used_stock = new Stock();
            $used_stock->is_used = true;
            $used_stock->book_id = $book->id;
            $used_stock->price = request()->input('used_price');
            $used_stock->quantity = request()->input('used_quantity');

            if ($new_stock->save() && $used_stock->save()) {
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
        $colors = ['zero', 'info', 'warning', 'success'];
        return view('admin.pages.books.show', compact('book', 'colors'));
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
        return view('admin.pages.books.edit', compact('categories', 'book'));
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

        // Book Update.
        $book = Book::findOrFail($id);
        $book->subcategory_id = request()->input('subcategory');

        // New Stock Update.
        $book->newStock()->price = request()->input('new_price');
        $book->newStock()->quantity = $book->newStock()->quantity + request()->input('new_quantity');
        $book->newStock()->save();
        
        // Used Stock Update.
        $book->usedStock()->price = request()->input('used_price');
        $book->usedStock()->quantity = $book->usedStock()->quantity + request()->input('used_quantity');
        $book->usedStock()->save();
        
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

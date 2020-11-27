<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Category;
use App\Subcategory;
use App\Author;
use App\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'category' => 'nullable|integer',
            'subcategory' => 'nullable|integer',
            'author' => 'nullable|integer',
            'search' => 'nullable|max:20|regex:/^[a-zA-Z0-9\s]+$/',
            'filter' => 'nullable|integer'
        ]);

        // Validation Fail
        if ($validator->fails()) { return redirect()->route('books.index')->withInput()->withErrors($validator); }

        // Query Variables
        $subcategory = Subcategory::find($request->get('subcategory'));
        $category = !$subcategory ? Category::find($request->get('category')) : null;
        $author = Author::find($request->get('author'));
        $search = $request->get('search');
        
        // Query Append as Array
        $append = array();
        
        // Pass All(Category, Author) to View
        $category_all = Category::with('subcategories')->get();
        $author_all = (!$category && !$subcategory) ? Author::orderBy('title')->get() : null;
        
        if ($subcategory) {

            $books = $subcategory->books();
            
            /**
             * Bug
             * 
             * $author_all = Author::whereIn('id', $subcategory->books()->select('author_id')->distinct('author_id')->get())->orderBy('title')->get();
             * $subcategory->books()->select('author_id')->distinct('author_id')->get() returns key-value pairs
             * which whereIn inputs all wrongly. Extra step pluck all author_ids.
             *
             * Fixed
             */
            $distinctAuthors = $subcategory->books()->select('author_id')->distinct('author_id')->get();
            $distinctAuthors = $distinctAuthors->pluck('author_id');
            $author_all = Author::whereIn('id', $distinctAuthors)->orderBy('title')->get();
            
            $append['subcategory'] = $subcategory->id;
            $append['category'] = $subcategory->category->id;
            $append['filter'] = true;

        } elseif ($category) {

            $books = $category->books();

            # Database Query Distinct Authors
            $distinctAuthors = $category->books()->select('author_id')->distinct('author_id')->get();

            # Pluck author_ids usnig Collection
            $distinctAuthors = $distinctAuthors->pluck('author_id');
            
            # Get All Authors in this Category
            $author_all = Author::whereIn('id', $distinctAuthors)->orderBy('title')->get();

            $append['subcategory'] = null;
            $append['category'] = $category->id;
            $append['filter'] = true;

        } else {
            $books = null;
            $append['subcategory'] = null;
            $append['category'] = null;
            $append['filter'] = null;
            // $books = Book::paginate(1);
        }

        $append['author'] = null;
        if ($author) {
            $books = $books ? $books->where('books.author_id', $author->id) : Book::where('author_id', $author->id);
            $append['author'] = $author->id;
            $append['filter'] = true;
        }

        $append['search'] = null;
        if ($search) {
            $books = $books ? $books->where('books.title', 'LIKE', "%$search%") : Book::where('title', 'LIKE', "%$search%");
            $append['search'] = $search;
            $append['filter'] = true;
        }
        
        if ($books) {
            $books = $books->with('author', 'subcategory')->paginate(9);
        } elseif (!$books) {
            $books = Book::with('author', 'subcategory')->paginate(9);
        }
        
        return view('customer.pages.index', compact(
            'category_all',
            'author_all',
            'subcategory',
            'category',
            'author',
            'append',
            'books'
        ));
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

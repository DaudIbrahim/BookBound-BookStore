<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;

class AdminSubcategoryController extends Controller
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
        $subcategories = Subcategory::get();
        return view('admin.pages.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.pages.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|exists:categories,id',
            'title' => 'required|unique:subcategories|min:4|max:255',
        ],[
            'category.required' => 'Please Select a Category',
            'category.exists' => 'Please Select a Category',
        ]);
        
        $subcategory = new Subcategory;
        $subcategory->category_id = request()->input('category');
        $subcategory->title = request()->input('title');
        
        if ($subcategory->save()) {
            $message = "Subcatgory - `$subcategory->title` created successfully";
            return redirect()->route('admin.subcategories.index')->with('message', $message);
        } else {
            $error = "Internal Error During Store Operation";
            return redirect()->route('admin.subcategories.create')->withErrors(["title" => $error])->withInput();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get();
        $subcategory = Subcategory::findOrFail($id);
        return view('admin.pages.subcategories.edit', compact('categories', 'subcategory'));
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
            'title' => "required|unique:subcategories,title,$id|min:4|max:255",
        ],[
            'category.required' => 'Please Select a Category',
            'category.exists' => 'Please Select a Category',
        ]);
        
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->category_id = request()->input('category');
        $subcategory->title = request()->input('title');
        
        if ($subcategory->update()) {
            $message = "Subcatgory - `$subcategory->title` updated successfully";
            return redirect()->route('admin.subcategories.index')->with('message', $message);
        } else {
            $error = "Internal Error During Update Operation";
            return redirect()->route('admin.subcategories.edit', ["subcategory" => $subcategory->id])->withErrors(["title" => $error])->withInput();
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
}

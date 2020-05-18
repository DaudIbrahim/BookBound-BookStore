<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdminCategoryController extends Controller
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
        $categories = Category::get();
        return view('admin.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ReferenceWeb
        // Laravel Validation - https://laravel.com/docs/5.8/validation#quick-writing-the-validation-logic
        $validatedData = $request->validate([
            'title' => 'required|unique:categories|min:4|max:255',
        ]);
        
        $category = new Category;
        $category->title = request()->input('title');
        
        if ($category->save()) {
            return redirect()->route('admin.categories.index')->with('message', 'Category Created Successfully!');
        } else {
            $error = "Internal Error During Store Operation";
            return redirect()->route('admin.categories.create')->withErrors(["title" => $error])->withInput();
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
        $category = Category::findOrFail($id);
        return view('admin.pages.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.categories.edit', compact('category'));
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
            'title' => "required|unique:categories,title,$id,|min:4|max:255",
            
        ]);
        
        $category = Category::findOrFail($id);
        $category->title = request()->input('title');
        
        if ($category->update()) {
            return redirect()->route('admin.categories.index')->with('message', 'Update Successful!');
        } else {
            $error = "Internal Error During Update Operation";
            return redirect()->route('admin.categories.edit', ["category" => $category->id])->withErrors(["title" => $error])->withInput();
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
     * Fetch (Axios, Ajax, Fetch) 
     * Subactegories via the provided Category ID
     */
    public function fetch($id) 
    {
        $subcategories = Category::findOrFail($id)->subcategories;
        if ($subcategories->isEmpty()) {

            $data = [
                'status'  => 'error',
                'code'    => '404',
                'message' => 'Error occurred.',
            ];
            
            return response()->json($data, 404);
            
        } else {

            $subcategories->toArray();

            $data = [
                'status' => 'success',
                'code'   => '200',
                'data'   => $subcategories,
            ];

            return response()->json($data, 200);
        }
    }
}

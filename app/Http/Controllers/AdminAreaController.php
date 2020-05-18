<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Area;

class AdminAreaController extends Controller
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
        $areas = Area::get();
        return view('admin.pages.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::get();
        return view('admin.pages.areas.create', compact('cities'));
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
            'city' => 'required|exists:cities,id',
            'title' => 'required|unique:areas|min:4|max:255',
        ],[
            'city.required' => 'Please Select a City',
            'city.exists' => 'Please Select a City',
        ]);
        
        $area = new Area;
        $area->city_id = request()->input('city');
        $area->title = request()->input('title');
        
        if ($area->save()) {
            $message = "Area - `$area->title` created successfully";
            return redirect()->route('admin.areas.index')->with('message', $message);
        } else {
            $error = "Internal Error During Store Operation";
            return redirect()->route('admin.areas.create')->withErrors(["title" => $error])->withInput();
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
        $cities = City::get();
        $area = Area::findOrFail($id);
        return view('admin.pages.areas.edit', compact('cities', 'area'));
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
            'city' => 'required|exists:cities,id',
            'title' => "required|unique:areas,title,$id|min:4|max:255",
        ],[
            'city.required' => 'Please Select a Category',
            'city.exists' => 'Please Select a Category',
        ]);
        
        $area = Area::findOrFail($id);
        $area->city_id = request()->input('city');
        $area->title = request()->input('title');
        
        if ($area->update()) {
            $message = "Area - `$area->title` updated successfully";
            return redirect()->route('admin.areas.index')->with('message', $message);
        } else {
            $error = "Internal Error During Update Operation";
            return redirect()->route('admin.areas.edit', ["area" => $area->id])->withErrors(["title" => $error])->withInput();
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

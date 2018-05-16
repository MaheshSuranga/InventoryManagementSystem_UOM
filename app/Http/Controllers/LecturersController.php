<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lecturer;
use App\User;

class LecturersController extends Controller
{
    /**
     * Display a listing of the resource.
     * Display all lecturers details
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = Lecturer::orderBy('created_at','acs')->get();
        return view('lecturers.index')->with('lecturers',$lecturers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //show the specific lecturer details.
        $lecturer = Lecturer::find($id);
        return view('lecturers.show')->with('lecturer',$lecturer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lecturer = Lecturer::find($id);
        //if user is not login redirect to all lecturers detail page
        if(!auth()->user()->hasAccess(['update-lecturer'])){
            return redirect('/lecturers')->with('error','Unauthorized Page');
        }
        return view('lecturers.edit')->with('lecturer',$lecturer);
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
        //validate lecturer detail update form post method.
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'regex:/(0)[0-9]{9}/',
        ]);
        
        //if new image is uploaded to change then store it in storage
        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        //retrive relevent lecturer from table 
        $lecturer= Lecturer::find($id);
        $lecturer->status = $request->input('status');
        $lecturer->designation = $request->input('designation');
        $lecturer->name = $request->input('name');
        $lecturer->email = $request->input('email');
        $lecturer->contact = $request->input('contact');
        
        //if form has cover image
        if($request->hasFile('cover_image')){
            $lecturer->cover_image = $fileNameToStore;
        }
        $lecturer->save();

        //update user table with new lecturer's details
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('/lecturers')->with('success','Lecturer detail updated');
    
    }

    /**
     * Remove the specified resource from storage.
     * //delete lecturer from system
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecturer = Lecturer::find($id);

        //if user is not logged in redirect to all lecturers' details page
        if(!auth()->user()->hasAccess(['delete-lecturer'])){
            return redirect('/lecturers')->with('error','Unauthorized Page');
        }

        //if lecturer has uploaded the image delete it from storage
        if($lecturer->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$lecturer->cover_image);
        }
        $lecturer->delete();

        //delete lecturer from user table also
        $user = User::find($id);
        $user->delete();

        return redirect('/lecturers')->with('success', 'Lecturer Removed');
    }
}

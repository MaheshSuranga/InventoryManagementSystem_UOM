<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supervisor;
use App\User;

class SupervisorsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Display all supervisors details.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supervisors = Supervisor::orderBy('created_at','acs')->get();
        return view('supervisors.index')->with('supervisors',$supervisors);
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
        //show the specific supervisor's details.
        $supervisor = Supervisor::find($id);
        return view('supervisors.show')->with('supervisor',$supervisor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supervisor = Supervisor::find($id);
        //if user is not login redirect to all supervisors' detail page
        if(!auth()->user()->hasAccess(['update-supervisor'])){
            return redirect('/supervisors')->with('error','Unauthorized Page');
        }
        return view('supervisors.edit')->with('supervisor',$supervisor);
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
            'contact' => 'regex:/(0)[0-9]{9}/'
        ]);

        //if new image is uploaded to change then store it in storage
        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        //retrive relevent supercisor from table 
        $supervisor= Supervisor::find($id);
        $supervisor->status = $request->input('status');
        $supervisor->name = $request->input('name');
        $supervisor->email = $request->input('email');
        $supervisor->contact = $request->input('contact');
        
        //if form has cover image
        if($request->hasFile('cover_image')){
            $supervisor->cover_image = $fileNameToStore;
        }
        $supervisor->save();

        //update user table with new lecturer's details
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('/supervisors')->with('success','Supervisor detail updated');
    }

    /**
     * Remove the specified resource from storage.
     * //delete lecturer from system
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supervisor = Supervisor::find($id);

        //if user is not logged in redirect to all supervisors' details page
        if(!auth()->user()->hasAccess(['delete-supervisor'])){
            return redirect('/supervisors')->with('error','Unauthorized Page');
        }

        //if lecturer has uploaded the image delete it from storage
        if($supervisor->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$supervisor->cover_image);
        }
        $supervisor->delete();

        //delete lecturer from user table also
        $user = User::find($id);
        $user->delete();

        return redirect('/supervisors')->with('success', 'Supervisor Removed');
    }
}

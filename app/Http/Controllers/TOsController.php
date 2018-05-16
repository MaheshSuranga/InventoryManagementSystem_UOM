<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TO;
use App\User;

class TOsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Display all TOs details
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TOs = TO::orderBy('created_at','acs')->get();
        return view('tos.index')->with('TOs',$TOs);
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
        //show the specific TOs details.
        $TO = TO::find($id);
        return view('tos.show')->with('TO',$TO);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $TO = TO::find($id);

        //if user is not login redirect to all TOs' detail page
        if(!auth()->user()->hasAccess(['update-to'])){
            return redirect('/tos')->with('error','Unauthorized Page');
        }
        return view('tos.edit')->with('TO',$TO);
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
        //validate TO detail update form post method.
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

        //retrive relevent TO from table 
        $TO= TO::find($id);
        $TO->status = $request->input('status');
        $TO->name = $request->input('name');
        $TO->email = $request->input('email');
        $TO->contact = $request->input('contact');
        
        //if form has cover image
        if($request->hasFile('cover_image')){
            $TO->cover_image = $fileNameToStore;
        }
        $TO->save();

        //update user table with new TO's details
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('/tos')->with('success','Technical Officer detail updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $TO = TO::find($id);

        //if user is not logged in redirect to all lecturers' details page
        if(!auth()->user()->hasAccess(['delete-to'])){
            return redirect('/tos')->with('error','Unauthorized Page');
        }

        //if TO has uploaded the image delete it from storage
        if($TO->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$TO->cover_image);
        }
        $TO->delete();

        //delete lecturer from TO table also
        $user = User::find($id);
        $user->delete();

        return redirect('/tos')->with('success', 'Technical Officer Removed');
    }
}

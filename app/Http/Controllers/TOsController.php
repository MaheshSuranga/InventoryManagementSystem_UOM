<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TO;
use App\User;

class TOsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'regex:/(0)[0-9]{9}/'
        ]);

        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $TO= TO::find($id);
        $TO->status = $request->input('status');
        $TO->name = $request->input('name');
        $TO->email = $request->input('email');
        $TO->contact = $request->input('contact');
        
        if($request->hasFile('cover_image')){
            $TO->cover_image = $fileNameToStore;
        }
        $TO->save();

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
        if(!auth()->user()->hasAccess(['delete-to'])){
            return redirect('/tos')->with('error','Unauthorized Page');
        }
        if($TO->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$TO->cover_image);
        }
        $TO->delete();

        $user = User::find($id);
        $user->delete();

        return redirect('/tos')->with('success', 'Technical Officer Removed');
    }
}

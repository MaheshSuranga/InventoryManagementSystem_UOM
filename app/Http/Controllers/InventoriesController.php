<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Inventory;
use App\Lecturer;
use App\Supervisor;
use App\History;

class InventoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::where('availability',1)->orderBy('updated_at','desc')->paginate(10);
        //return $inventories;
        return view('inventories.index')->with('inventories',$inventories);
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'brand' => 'required',
            'serial' => 'required',
            'price' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $inventory = new Inventory;
        $inventory->name = $request->input('name');
        $inventory->brand = $request->input('brand');
        $inventory->serialno = $request->input('serial');
        $inventory->price = $request->input('price');
        $inventory->description = $request->input('description');
        $inventory->purchaseddate = $request->input('purchase');
        $inventory->availability = 1;
        $inventory->cover_image = $fileNameToStore;
        $inventory->save();

        return redirect('/inventories')->with('success','Inventory Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        return view('inventories.show')->with('inventory',$inventory);
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
        $inventory = Inventory::find($id);
        if(!auth()->user()->hasAccess(['update-inventory'])){
            return redirect('/inventories')->with('error','Unauthorized Page');
        }
        return view('inventories.edit')->with('inventory',$inventory);
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
            'brand' => 'required',
            'serial' => 'required',
            'price' => 'required',
        ]);

        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $inventory = Inventory::find($id);
        $inventory->name = $request->input('name');
        $inventory->brand = $request->input('brand');
        $inventory->serialno = $request->input('serial');
        $inventory->price = $request->input('price');
        $inventory->description = $request->input('description');
        $inventory->purchaseddate = $request->input('purchase');
        $inventory->cover_image = $fileNameToStore;
        if($request->hasFile('cover_image')){
            $inventory->cover_image = $fileNameToStore;
        }
        $inventory->save();

        return redirect('/inventories')->with('success','Inventory Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if(!auth()->user()->hasAccess(['delete-inventory'])){
            return redirect('/inventories')->with('error','Unauthorized Page');
        }
        if($inventory->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$inventory->cover_image);
        }
        $inventory->delete();
        return redirect('/inventories')->with('success', 'Inventory Removed');
        //
    }

    public function allint(){
        $inventories = Inventory::orderBy('updated_at','desc')->paginate(10);
        return view('inventories.allint')->with('inventories',$inventories);
    }

    public function issue(){
        $inventories = Inventory::where('availability',1)->orderBy('updated_at','desc')->paginate(10);
        $lecturers = Lecturer::all();
        $supervisors = Supervisor::all();

        $data = array(
            'inventories' => $inventories,
            'lecturers' => $lecturers,
            'supervisors' => $supervisors
        );
        if(!auth()->user()->hasAccess(['issue-inventory'])){
            return redirect('/inventories')->with('error','Unauthorized Page');
        }
        return view('inventories.issue')->with($data);
    }

    public function sendemail(Request $request){
        
        $this->validate($request, [
            //'id[]' => 'required',
            'name' => 'required',
            'index' => 'required',
            'incharge' => 'required'
        ]);
        
        $inventoriesid = $request->input('id');
        $index = $request->input('index');
        $name = $request->input('name');
        $incharge = $request->input('incharge');

        $inventories = array();
        foreach($inventoriesid as $inventoryid){
            $inventory= Inventory::find($inventoryid);
            $inventory->send = 1;
            $inventory->save();
            array_push($inventories, $inventory);

            $history = new History;
            $history->intid = $inventory->id;
            $history->intname = $inventory->name;
            $history->index = $index;
            $history->name = $name;
            $history->approve = 0;
            $history->save();
        }

        $user = User::find($incharge);
        $useremail = $user->email;

        $data = array('name'=> $name, 'index' => $index, 'inventories' => $inventories);
        Mail::send('emails.mail', $data, function($message) use($useremail){
            $message->to($useremail)->subject('Request for borrowing inventories from Embedded Lab');
            $message->from('wasanthaedirisuriya65@gmail.com','Wasantha Edirisuriya');

        });
        return redirect('/inventories')->with('success', 'Email is sent');

    }
    public function unavailable(){
        $inventories = Inventory::where('availability',0)->orderBy('updated_at','desc')->paginate(10);
        return view('inventories.unavailable')->with('inventories',$inventories);
    }

    public function return($id){
        $inventory = Inventory::find($id);
        $inventory->availability = 1;
        $inventory->save();

        return redirect('/inventory/unavailable')->with('success', 'Inventory is returned to Lab');
    }
}

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
     * retrieve data where availablity is true in db. Therefore currently availabe inventories display 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::where('availability',1)->orderBy('updated_at','desc')->paginate(10);
        return view('inventories.index')->with('inventories',$inventories);

    }


    /**
     * Show the form for creating a new resource.
     * Display the inventory add form.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created resource in storage.
     * Add a new row to inventory table.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate post request from creating inventory form
        $this->validate($request, [
            'name' => 'required',
            'brand' => 'required',
            'serial' => 'required',
            'price' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //check for the image file availability
        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';  //if a image is not exists default one is assign to inventory.
        }

        //save inventory to table
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
     * show inventory detail blade
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        return view('inventories.show')->with('inventory',$inventory);
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
        //if user is not logged return to inventory list page with an error message
        if(!auth()->user()->hasAccess(['update-inventory'])){
            return redirect('/inventories')->with('error','Unauthorized Page');
        }
        return view('inventories.edit')->with('inventory',$inventory);
    }

    /**
     * Update the specified resource in storage.
     * update the inventory detail
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate inventory's detail form
        $this->validate($request, [
            'name' => 'required',
            'brand' => 'required',
            'serial' => 'required',
            'price' => 'required',
        ]);
        
        //check for the image file availability
        if($request->hasFile('cover_image')){
            $fileNamewithExt = $request->file('cover_image')->getClientOriginalName();
            $fileName = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        //save inventory to table
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

        //return to inventory list with success message
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
        //if user is not loggged redirect to inventory list page
        $inventory = Inventory::find($id);
        if(!auth()->user()->hasAccess(['delete-inventory'])){
            return redirect('/inventories')->with('error','Unauthorized Page');
        }
        //if there is a specific image delete it from storage.otherwise leave
        if($inventory->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_image/'.$inventory->cover_image);
        }
        //delete that inventory row. and send successfuly process message
        $inventory->delete();
        return redirect('/inventories')->with('success', 'Inventory Removed');
        
    }

    //display all inventories' details
    public function allint(){
        $inventories = Inventory::orderBy('updated_at','desc')->paginate(10);
        return view('inventories.allint')->with('inventories',$inventories);
    }


    //Display inventory issue form.
    public function issue(){
        //retrieve currently available all inventories
        $inventories = Inventory::where('availability',1)->orderBy('updated_at','desc')->paginate(10);
        $lecturers = Lecturer::all();
        $supervisors = Supervisor::all();

        //send all details as array to blade view.
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

    //email sending method
    public function sendemail(Request $request){
        
        //validate inventory issue form
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

        //push to all data which are taken from form to an one array.
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

        //To whoom to send this email for approval request
        $user = User::find($incharge);
        $useremail = $user->email;

        //mail sending
        $data = array('name'=> $name, 'index' => $index, 'inventories' => $inventories);
        Mail::send('emails.mail', $data, function($message) use($useremail){
            $message->to($useremail)->subject('Request for borrowing inventories from Embedded Lab');
            $message->from('wasanthaedirisuriya65@gmail.com','Wasantha Edirisuriya');

        });
        return redirect('/inventories')->with('success', 'Email is sent');

    }

    //currently unavailable inventories.
    public function unavailable(){
        $inventories = Inventory::where('availability',0)->orderBy('updated_at','desc')->paginate(10);
        return view('inventories.unavailable')->with('inventories',$inventories);
    }

    //after returning inventory mark it as available for boorow.
    public function return($id){
        $inventory = Inventory::find($id);
        $inventory->availability = 1;
        $inventory->send = 0;
        $inventory->save();

        return redirect('/inventory/unavailable')->with('success', 'Inventory is returned to Lab');
    }
}

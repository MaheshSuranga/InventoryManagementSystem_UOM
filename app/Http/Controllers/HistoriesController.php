<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;
use App\Inventory;

class HistoriesController extends Controller
{
    public function index()
    {
        //retrieve only approved to borrow inventories from table.it means issued inventories
        $histories = History::where('approve',1)->orderBy('updated_at','desc')->paginate(10);
        return view('histories.index')->with('histories',$histories);
    }

    public function notifications()
    {
        //retrieve pending inventory issues.
        $histories = History::where('approve',0)->orderBy('updated_at','desc')->paginate(10);
        return view('histories.notification')->with('histories',$histories);
    }

    public function show($id)
    {
        //take specific row
        $history = History::find($id);
        return $this->edit($history->id);
    }

    public function edit($id)
    {
        //approve the inventory to issue
        $history = History::find($id);
        $history->approve = 1;
        $history->save();

        $inventory = Inventory::find($history->intid);
        $inventory->availability = 0;
        $inventory->save();

        return redirect('/histories')->with('success','Inventory issued');
    }

    public function destroy($id)
    {
        //delete from history if inventory issue is rejected
        $history = History::find($id);
        $history->delete();
        return redirect('/histories')->with('success', 'Request is rejected');
    }
}

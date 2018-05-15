<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;
use App\Inventory;

class HistoriesController extends Controller
{
    public function index()
    {
        $histories = History::where('approve',1)->orderBy('updated_at','desc')->paginate(10);
        return view('histories.index')->with('histories',$histories);
    }

    public function notifications()
    {
        $histories = History::where('approve',0)->orderBy('updated_at','desc')->paginate(10);
        return view('histories.notification')->with('histories',$histories);
    }

    public function show($id)
    {
        $history = History::find($id);
        return $this->edit($history->id);
    }

    public function edit($id)
    {
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
        $history = History::find($id);
        $history->delete();
        return redirect('/histories')->with('success', 'Request is rejected');
    }
}

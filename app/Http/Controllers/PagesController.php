<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;

class PagesController extends Controller
{
    public function index(){
        $title = "Welcome to Inventory Management System of Embedded Lab";
        return view('pages.index')->with('title',$title);
    }
}

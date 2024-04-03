<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function showTop()
    {
        return view('toppage');
    }

    public function showMylist()
    {
        return view('mylist');
    }
}

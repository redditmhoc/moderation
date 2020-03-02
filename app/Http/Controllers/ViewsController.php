<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access']);
    }

    public function dash()
    {
        return view('dash');
    }
}

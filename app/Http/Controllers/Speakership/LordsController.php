<?php

namespace App\Http\Controllers\Speakership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LordsController extends Controller
{
    public function countVote()
    {
        return view('speakership.lords.countvote');
    }
}

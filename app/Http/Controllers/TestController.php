<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function abc() {
        $title = 'My Title';
        $xyz = 'ZZZZZZZZZZZ';

        //Cach 1 
        return view('test', [
            'heading' => $title,
            'xyz' => $xyz
        ]);

        //Cach 2
        // return view('test')->with('title', $title)->with('xyz', $xyz);

        //Cach 3
        // return view('test', compact('title', 'xyz'));
    }
}

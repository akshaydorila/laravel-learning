<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return 'This is test function of controller';
    }

    public function testView(Request $request, $name, $subject = 'BCA')
    {
        // $input = $request->all();
        // $grade = $request->grade;
        $grade = $request->input('grade', 'A');
        
        // $data = ['name' => $name, 'subject' => $subject, 'grade' => $grade];
        // return view('test', $data);

        return view('test', compact('name', 'subject', 'grade'));
        // return view('test')->with(['name' => $name]);
    }
}

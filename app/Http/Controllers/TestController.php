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

        $data = [
            'name' => $name,
            'subject' => $subject,
            'grade' => $grade,
            'tag' => '<b>bold text</b>',
            'count' => 0,
            'users' => $this->usersData(),
        ];
        return view('test', $data);

        // return view('test', compact('name', 'subject', 'grade'));
        // return view('test')->with(['name' => $name]);
    }

    private function usersData()
    {
        $users = [
            ["type" => 2, "name" => "Aarav",  "number" => 2, "status" => 1],
            ["type" => 3, "name" => "Vivaan", "number" => 3, "status" => 1],
            ["type" => 1, "name" => "Aditya", "number" => 4, "status" => 0], // skipped because type = 1
            ["type" => 2, "name" => "Krishna", "number" => 1, "status" => 1],
            ["type" => 3, "name" => "Ishaan", "number" => 5, "status" => 1], // break happens here
            ["type" => 2, "name" => "Aryan",  "number" => 6, "status" => 0],
            ["type" => 3, "name" => "Rohan",  "number" => 7, "status" => 1],
            ["type" => 1, "name" => "Kabir",  "number" => 8, "status" => 0],
            ["type" => 2, "name" => "Arjun",  "number" => 9, "status" => 1],
            ["type" => 3, "name" => "Dev",    "number" => 4, "status" => 0]
        ];

        return $users;
    }

    public function form()
    {
        return view('pages.form');
    }

    public function submitForm(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => 'The :attribute field is required Any how.',
            'email.email' => 'Invalid :attribute.',
        ];

        $validatedData = $request->validate($rules, $customMessages);

        // return $validatedData;
        // return "Email: " . $request->email . ", Password: " . $request->password;
    }
}

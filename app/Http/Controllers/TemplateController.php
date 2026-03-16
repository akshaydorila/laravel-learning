<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function page1()
    {
        $data = [
            'title' => 'Page 1',
            'description' => 'This is page 1 description',
        ];

        return view('pages.page-1', $data);
    }

    public function page2()
    {
        return view('pages.page-2');
    }

    public function page3()
    {
        $data = [
            'title' => 'Page 3',
            'description' => 'This is page 3 description',
        ];

        return view('pages.page-3', $data);
    }
}

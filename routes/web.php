<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// without param
// Route::get('/greeting', function () {
//     return "Hello World";
// });

// required param
Route::get('/greeting/{name}', function ($name) {
    return "Hello World $name";
}); // ->where('name', '[A-Za-z]+')

// optional param
// Route::get('/greeting/{name?}', function ($name = null) {
//     return "Hello World $name";
// });

// request data
// Route::get('/request-data', function (Request $request) {
//     // return $request->all();
//     return $request->name; // get only name from request data
// });

// if route not exists, then fallback route will call
Route::fallback(function () {
    return 'Page Not Found';
});

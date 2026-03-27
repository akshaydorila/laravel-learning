<?php

use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'welcome');

# without param
// Route::get('/greeting', function () {
//     return "Hello World";
// });

# required param
// Route::get('/greeting/{name}', function ($name) {
//     return "Hello World $name";
// }); // ->where('name', '[A-Za-z]+')

# optional param
// Route::get('/greeting/{name?}', function ($name = null) {
//     return "Hello World $name";
// });

# request data
// Route::get('/request-data', function (Request $request) {
//     // return $request->all();
//     return $request->name; // get only name from request data
// });

# if route not exists, then fallback route will call
Route::fallback(function () {
    return 'Page Not Found';
});

# Call controller method
Route::get('test', [TestController::class, 'test']);
// Route::get('test-view', [TestController::class, 'testView']);
Route::get('test-view/{name}/{subject?}', [TestController::class, 'testView']);

Route::get('page-1', [TemplateController::class, 'page1']);
Route::get('page-2', [TemplateController::class, 'page2']);
Route::get('page-3', [TemplateController::class, 'page3']);

// Form demo
Route::get('form', [TestController::class, 'form']);
Route::post('submit-form', [TestController::class, 'submitForm']);

// Send Mail
Route::get('send-mail', [TestController::class, 'sendMail']);
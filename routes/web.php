<?php

use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\TestMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('page-1', [TemplateController::class, 'page1']); // ->middleware(TestMiddleware::class.':admin');
Route::get('page-2', [TemplateController::class, 'page2']);
Route::get('page-3', [TemplateController::class, 'page3']);

// Form demo
Route::get('form', [TestController::class, 'form']); // ->middleware(TestMiddleware::class);
Route::post('submit-form', [TestController::class, 'submitForm']); // ->middleware('throttle:5,1'); // 5 requests per minute

// Send Mail
Route::get('send-mail', [TestController::class, 'sendMail']);

// Session routes
Route::get('set-session', [TestController::class, 'setSession']);
Route::get('get-session', [TestController::class, 'getSession']);
Route::get('delete-session', [TestController::class, 'deleteSession']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

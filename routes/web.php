<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

if (App::environment('local')) {
    Route::get('/playground', function () {
        event(new \App\Events\PlaygroundEventEvent());
        // return (new \App\Mail\WelcomeMail(\App\Models\User::factory()->make()))->render();
        return null;
    });
}

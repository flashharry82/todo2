<?php

use Illuminate\Support\Facades\Route;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Html\FormBuilder;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/process', 'TaskController@process');

Route::resource('tasks', 'TaskController');

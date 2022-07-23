<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonDataController;



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

Route::get('/', [PersonDataController::class, 'index']);

// Route::get('/', function () {
//     $data = DB::table('test_data')->get();
//     return view('welcome',['data' => $data]);
// });



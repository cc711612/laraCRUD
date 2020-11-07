<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserdataController ;
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

// Route::get('/', function () {
//     return view('home');
// });
//index
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/orderby={orderby}&keyword={keyword}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/keyword={keyword}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/orderby={orderby}', [App\Http\Controllers\HomeController::class, 'index']);
//add
Route::post('/datas/add', [App\Http\Controllers\UserdataController ::class,'store']);
//update
Route::post('/datas/edit', [App\Http\Controllers\UserdataController ::class,'update']);
//delete
Route::get('/datas/delete/{id}', [App\Http\Controllers\UserdataController ::class,'destroy']);
//ajax
Route::post('/datas/api', [App\Http\Controllers\UserdataController ::class,'show']);
//export
Route::get('/datas/export', [App\Http\Controllers\UserdataController ::class,'export']);
Auth::routes();



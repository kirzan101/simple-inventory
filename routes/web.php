<?php

use App\Http\Controllers\AssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
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

Route::resource('/items', ItemController::class);
Route::resource('/inventories', InventoryController::class);
Route::resource('/employees', EmployeeController::class);
Route::resource('/assigns', AssignController::class);
Route::get('/home', [HomeController::class, 'index']);

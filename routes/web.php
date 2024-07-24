<?php

use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

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

Route::get("/",[PenjualanController::class,'index'])->name("home");

Route::post("/add_data",[PenjualanController::class,'add_data'])->name("add_data");
Route::post("/remove_data",[PenjualanController::class,'remove_data'])->name("remove_data");
Route::post("/clear_data",[PenjualanController::class,'clear_data'])->name("clear_data");
Route::post("/update_quantity",[PenjualanController::class,'update_quantity'])->name('update_quantity');
Route::post("/save_data",[PenjualanController::class,'save_data'])->name('save_data');
Route::get("/get_data_transaksi",[PenjualanController::class,'get_data_transaksi'])->name("get_data_transaksi");

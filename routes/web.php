<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReportsController;

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

Route::view('/','login');
Route::post('/login',[UsersController::class, 'login']);
Route::get('/logout',[UsersController::class, 'logout']);
Route::get('/dashboard',[UsersController::class, 'dashboard']);
Route::get('/expNBills',[UsersController::class, 'expNBills']);
Route::post('/addExpType',[UsersController::class, 'addExpType']);
Route::post('/addBillType',[UsersController::class, 'addBillType']);
Route::post('/editExpType',[UsersController::class, 'editExpType']);
Route::post('/editBillType',[UsersController::class, 'editBillType']);
Route::get('/delete_exp_type/{id}',[UsersController::class, 'delete_exp_type']);
Route::get('/delete_bill_type/{id}',[UsersController::class, 'delete_bill_type']);
Route::post('/addExp',[UsersController::class, 'addExp']);
Route::post('/editExp',[UsersController::class, 'editExp']);
Route::get('/delete_exp/{id}',[UsersController::class, 'delete_exp']);
Route::get('/bydate',[ReportsController::class, 'bydate']);
Route::post('/bydate',[ReportsController::class, 'bydate']);
Route::get('/bymonth',[ReportsController::class, 'bymonth']);
Route::post('/bymonth',[ReportsController::class, 'bymonth']);
Route::get('/bymonthexp',[ReportsController::class, 'bymonthexp']);
Route::post('/bymonthexp',[ReportsController::class, 'bymonthexp']);
Route::get('/try',[ReportsController::class, 'try']);

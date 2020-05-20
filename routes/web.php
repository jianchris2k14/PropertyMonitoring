<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;

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

Route::get('/email', function(){
	Mail::to('email@email.com')->send(new NotifyMail());
	return new NotifyMail();
});

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// System Routes
Route::get('/persons', 'HomeController@persons');
Route::get('/users', 'HomeController@users');
Route::get('/equipments', 'HomeController@equipments');
Route::get('/repair_job_orders/{id}', 'HomeController@repair_job_orders');
Route::get('/inventory', 'HomeController@inventory');
Route::get('/inventory_stocks/{id}', 'HomeController@inventory_stocks');

// PDF Routes
Route::get('/equipment_pdf/{id}', 'EquipmentController@equipment_pdf');
Route::get('/inventory_pdf/{id}', 'InventoryController@inventory_pdf');
Route::get('/repair_job_order_pdf/{id}', 'RepairJobOrderController@repair_job_order_pdf');
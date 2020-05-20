<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Persons API
Route::get('persons', 'PersonController@index');
Route::post('persons', 'PersonController@search');
Route::get('person/{id}', 'PersonController@show');
Route::post('person', 'PersonController@store');
Route::put('person', 'PersonController@store');
Route::delete('person/{id}', 'PersonController@destroy');
Route::get('persons_selection', 'PersonController@selection');

// User Roles API
Route::get('user_roles', 'UserRoleController@index');
Route::get('user_role/{id}', 'UserRoleController@show');
Route::post('user_role', 'UserRoleController@store');
Route::put('user_role', 'UserRoleController@store');
Route::delete('user_role/{id}', 'UserRoleController@destroy');
Route::get('user_roles_selection', 'UserRoleController@selection');

// Users API
Route::get('users', 'UserController@index');
Route::post('users', 'UserController@search');
Route::get('user/{id}', 'UserController@show');
Route::post('user', 'UserController@store');
Route::put('user', 'UserController@store');
Route::delete('user/{id}', 'UserController@destroy');

// Equipments API
Route::get('equipments', 'EquipmentController@index');
Route::post('equipments', 'EquipmentController@search');
Route::get('equipment/{id}', 'EquipmentController@show');
Route::post('equipment', 'EquipmentController@store');
Route::put('equipment', 'EquipmentController@store');
Route::delete('equipment/{id}', 'EquipmentController@destroy');

// Equipment Images API
Route::get('equipment_image/{id}', 'EquipmentController@show_image');
Route::post('equipment_image', 'EquipmentController@store_image');
Route::delete('equipment_image/{id}', 'EquipmentController@destroy_image');

// Repair Job Orders API
Route::get('repair_job_orders/{id}', 'RepairJobOrderController@index');
Route::post('repair_job_orders/{id}', 'RepairJobOrderController@search');
Route::get('repair_job_order/{id}', 'RepairJobOrderController@show');
Route::post('repair_job_order', 'RepairJobOrderController@store');
Route::put('repair_job_order', 'RepairJobOrderController@store');
Route::delete('repair_job_order/{id}', 'RepairJobOrderController@destroy');

// Inventory API
Route::get('inventory', 'InventoryController@index');
Route::post('inventory', 'InventoryController@search');
Route::get('inventory_item/{id}', 'InventoryController@show');
Route::post('inventory_item', 'InventoryController@store');
Route::put('inventory_item', 'InventoryController@store');
Route::delete('inventory_item/{id}', 'InventoryController@destroy');

// Inventory Images API
Route::get('inventory_image/{id}', 'InventoryController@show_image');
Route::post('inventory_image', 'InventoryController@store_image');
Route::delete('inventory_image/{id}', 'InventoryController@destroy_image');

// Inventory Stocks API
Route::get('inventory_stocks/{id}', 'InventoryStockController@index');
Route::post('inventory_stocks/{id}', 'InventoryStockController@search');
Route::get('inventory_stock/{id}', 'InventoryStockController@show');
Route::post('inventory_stock', 'InventoryStockController@store');
Route::put('inventory_stock', 'InventoryStockController@store');
Route::delete('inventory_stock/{id}', 'InventoryStockController@destroy');
Route::get('inventory_stock_balance/{id}', 'InventoryStockController@stock_balance');
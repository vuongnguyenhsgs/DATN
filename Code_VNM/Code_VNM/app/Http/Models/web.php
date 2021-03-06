<?php

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

Route::get('/', 'Shop\ShopController@index');
Route::get('/login', 'Process\LoginController@getLogin');
Route::post('/login', 'Process\LoginController@postLogin');
Route::get('/logout', 'Process\LoginController@getLogout');

Route::get('/Admin/drinks/all', 'Process\DrinkController@getAll');
Route::get('/Admin/drinks/all-mob', 'Process\DrinkController@mobGetAll');
Route::get('/Admin/drinks/all-by-ajax', 'Process\DrinkController@getAllByAjax');

Route::get('/Admin/drinks/add', 'Process\DrinkController@getAdd');
Route::post('/Admin/drinks/add', 'Process\DrinkController@postAdd');
Route::post('/Admin/drinks/is-existed', 'Process\DrinkController@isExistedDrink');
Route::post('/Admin/drinks/delete', 'Process\DrinkController@postDelDrink');
Route::get('/Admin/drinks/edit/{drinkId}', 'Process\DrinkController@getEditDrink');

//Materials
Route::get('/Admin/materials/all','Process\MaterialController@getAll');
Route::get('/Admin/materials/add','Process\MaterialController@getAdd');
Route::post('/Admin/materials/add','Process\MaterialController@postAddMaterial');
Route::post('/Admin/materials/is-existed','Process\MaterialController@isExistedMaterial');
Route::post('/Admin/materials/delete','Process\MaterialController@postDelMaterial');

Route::get('/Admin/bills/all','Process\BillController@getBill');
Route::get('/Admin/bills/add','Process\BillController@getAddBill');
Route::post('/Admin/bills/add','Process\BillController@postAddBill');

Route::get('/Admin/bills/add-mob','Process\BillController@postAddBill');
Route::get('/Admin/bills/get-mob','Process\BillController@getBillById');
Route::get('/Admin/bills/get-by-status-mob','Process\BillController@getBillByStatus');
Route::get('/Admin/bills/get-bill_detail-mob','Process\BillController@getBillDetail');
Route::get('/Admin/bills/update-bill-mob','Process\BillController@updateBillStatus');

Route::get('/Admin/productions/all','Process\ProductionController@getAll');
Route::get('/Admin/productions/add','Process\ProductionController@getAdd');
Route::post('/Admin/productions/delete','Process\ProductionController@postDelProduction');

Route::post('/Admin/categories/is-existed', 'Process\DrinkController@isExistedCategory');
Route::post('/Admin/categories/add', 'Process\DrinkController@addCategory');

Route::get('/home','Shop\ShopController@index');
Route::get('/category/{id}', 'Shop\ShopController@getDrinkByCategory');
Route::get('/drink/detail/{id}', 'Shop\ShopController@getDrinkDetail');
Route::post('/cart/addToCart','Shop\ShopController@postAddToBill');
Route::get('/cart','Shop\ShopController@getCart');
Route::post('/cart/remove','Shop\ShopController@removeItemFromCart');
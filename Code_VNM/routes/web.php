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
Route::get('/login-mob', 'Process\LoginController@getLoginMob');
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
Route::post('Admin/bills/delete','Process\BillController@deleteBill');
Route::post('/Admin/bills/detail','Process\BillController@getBillDetail');
Route::get('/Admin/bills/edit/{id}','Process\BillController@getEditBill');
Route::get('/Admin/bills/{id}','Process\BillController@getBillById');

Route::get('/Admin/bills/add-mob','Process\BillController@postAddBillMob');
Route::get('/Admin/bills/get-mob','Process\BillController@getBillById');
Route::get('/Admin/bills/get-by-status-mob','Process\BillController@getBillByStatus');
Route::get('/Admin/bills/get-bill_detail-mob','Process\BillController@getBillDetail');
Route::get('/Admin/bills/update-bill-mob','Process\BillController@updateBillStatus');
Route::post('/Admin/bills/update-bill','Process\BillController@updateBillStatus');
Route::get('/Admin/tables','Process\BillController@getAllTable');
Route::get('/Admin/tables/update','Process\BillController@updateStatusTable');

Route::get('/Admin/productions/all','Process\ProductionController@getAll');
Route::get('/Admin/productions/add','Process\ProductionController@getAdd');
Route::post('/Admin/productions/delete','Process\ProductionController@postDelProduction');

Route::post('/Admin/categories/is-existed', 'Process\DrinkController@isExistedCategory');
Route::post('/Admin/categories/add', 'Process\DrinkController@addCategory');

Route::get('/Admin/employees/all','Process\EmployeeController@getAll');

Route::post('/Admin/bills/statistic','Process\BillController@getStatistic');

Route::get('/home','Shop\ShopController@index');
Route::get('/category/{id}', 'Shop\ShopController@getDrinkByCategory');
Route::get('/drink/detail/{id}', 'Shop\ShopController@getDrinkDetail');
Route::post('/cart/addToCart','Shop\ShopController@postAddToBill');
Route::get('/cart','Shop\ShopController@getCart');
Route::post('/cart/remove','Shop\ShopController@removeItemFromCart');
Route::post('/cart/add-bill','Shop\ShopController@addBillOnline');
Route::post('/cart/update','Shop\ShopController@updateCart');
Route::post('/cart/add-bill','Shop\ShopController@checkoutCart');

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
//menus route
Route::get('/', "PagesController@index");
Route::get('/home', "PagesController@home");
Route::get('/CreateMenu', "PagesController@CreateMenu");
Route::get('/MappedMenu', "PagesController@MappedMenu");
Route::get('/CreateUser', "PagesController@CreateUser");
Route::get('/listdelivery/{id}', "PagesController@deliverydetails");
Route::get('/ongoing/{id}', "PagesController@ongoingdeliver");
Route::get('/paymententry/{id}', "PagesController@paymententry");
Route::get('/user', "PagesController@userdetails");
Route::get('/changecredential/{id}', "PagesController@changecredential");


//transaction routes
Route::get('/payment/{id}',"PaymentEntryController@show");
Route::get('/orderdetails/{tran_no}',"PaymentEntryController@orderDetails");
Route::get('/displayEntry/{user}',"PaymentEntryController@displayEntry")->name('displayEntry');
Route::post('/savePayment',"PaymentEntryController@store");
Route::get('/allTransactions/{date}',"InsertPayment@showAllTransaction")->name('allTransactions');
Route::post('/addPayment',"InsertPayment@savePayment");
Route::get('/removeDetails/{id}',"InsertPayment@deleteDetails");
Route::get('/listTransactions/{date}',"ListDeliveryController@showAllTransaction")->name('listTransactions');
Route::post('/updatePayment',"ListDeliveryController@updatePayment");
Route::get('/exportReport/{date}',"ListDeliveryController@exportReport");
Route::get('/alldelivered',"InsertPayment@alldelivered");
Route::get('/paiddelivered',"InsertPayment@paiddelivered");
Route::get('/unpaiddelivered',"InsertPayment@unpaiddelivered");


//user routes

Route::post('/addUser',"UserController@addUser");
Route::get('/userlist',"UserController@userList")->name('userlist');
Route::post('/updateUser',"UserController@updateUser");
Route::get('/deleteUser/{id}',"UserController@deleteUser");
Route::post('/userLogin',"UserController@userLogin");
Route::post('/updatecredentials',"UserController@updatecredentials");
Route::post('/logout', "UserController@logout");

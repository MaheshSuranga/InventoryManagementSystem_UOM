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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('inventories', 'InventoriesController');

Route::group(['prefix'=>'inventories'],function(){
    Route::get('/', 'InventoriesController@index');

    Route::get('/create', 'InventoriesController@create')->middleware('can:create-inventory');

    Route::post('/create', 'InventoriesController@store')->middleware('can:create-inventory');

    Route::get('/show/{id}', 'InventoriesController@show');

    Route::get('/{inventory}/edit', 'InventoriesController@edit')->middleware('can:update-inventory');

    Route::post('/{inventory}/update', 'InventoriesController@update')->middleware('can:update-inventory');

    Route::delete('/{inventory}/delete', 'InventoriesController@update')->middleware('can:delete-inventory');
});

Route::resource('lecturers', 'LecturersController');
Route::get('/inventorie/allint', 'InventoriesController@allint');
Route::get('/inventory/issue', 'InventoriesController@issue');
Route::post('/inventory/issue', 'InventoriesController@sendemail');

Route::resource('supervisors', 'SupervisorsController');
Route::resource('tos', 'TOsController');

Route::resource('histories', 'HistoriesController');
Route::get('/history/notify', 'HistoriesController@notifications');
Route::get('/inventory/unavailable', 'InventoriesController@unavailable');
Route::post('/{inventory}/return', 'InventoriesController@return');
//Route::get('/lecturers/{lecturer}/edit ', 'LecturersController@edit')->middleware('can:update-lecturer');
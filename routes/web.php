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
Route::get('language/{lang}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

//Route::get('/', function () {
//    return redirect( 'index.php/'.config('crudbooster.ADMIN_PATH'));
//});

//Route::get('/admin/', function () {
//    return redirect( 'index.php/'.config('crudbooster.ADMIN_PATH'));
//});

Route::get('/','TrangchuController@getDeThi');
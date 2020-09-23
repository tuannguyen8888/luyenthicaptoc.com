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

Route::get('/','TrangchuController@getExamQuestions');
Route::get('home','TrangchuController@getExamQuestions');
Route::get('search','TrangchuController@getSearch');

Route::get('gioithieu', function () {
    return view('admin.layout.gioithieu');
});
Route::get('contact-us', 'ContactUsController@getIndex');
Route::get('share', function () {
    return view('admin.tintuc.dstintuc');
});
Route::get('tintuc1', function () {
    return view('admin.tintuc.tintuc1');

});
Route::get('tintuc2', function () {
    return view('admin.tintuc.tintuc2');

});
Route::get('ngoaingu', function () {
    return view('admin.tailieu.ngoaingu');

});

Route::get('article/{id}','TrangchuController@getArticle');
Route::get('category/{id}','TrangchuController@getCategory');

Route::get('chitiet', function () {
    return view('admin.thitructuyen.chitiet');
});

Route::get('dangnhap','\crocodicstudio\crudbooster\controllers\AdminController@getLogin');
Route::get('dangxuat','\crocodicstudio\crudbooster\controllers\AdminController@getLogout');
//Route::get('dangnhap','TrangchuController@getdangnhap');
//Route::post('dangnhap','TrangchuController@postdangnhap');


Route::get('dethi/{id}','DeThiController@hocsinhctdethi');
Route::post('thembinhluan/{id}','ThaoluandethiController@postthemcmt');


Route::get('/auth/{provider}', 'SocialAuthController@redirectToProvider');
Route::get('/auth/{provide}/callback', 'SocialAuthController@handleProviderCallback');
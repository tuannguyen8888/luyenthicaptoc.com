
<?php
use App\Http\Controllers;
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
//
//Route::get('/admin/', function () {
//    return redirect( 'index.php/'.config('crudbooster.ADMIN_PATH'));
//});

Route::get('/','TrangchuController@getExamQuestions');
Route::get('home','TrangchuController@getExamQuestions');
Route::get('search','TrangchuController@getSearch');

Route::get('contact-us', 'ContactUsController@getIndex');

Route::get('article/{id}','TrangchuController@getArticle');
Route::get('category/{id}','TrangchuController@getCategory');

Route::get('chitiet', function () {
    return view('admin.thitructuyen.chitiet');
});

Route::get('dangnhap','\crocodicstudio\crudbooster\controllers\AdminController@getLogin');
Route::get('dangxuat','AdminCmsUsersController@logout');
//Route::get('dangnhap','TrangchuController@getdangnhap');
//Route::post('dangnhap','TrangchuController@postdangnhap');


Route::get('exam-question/{id}','TrangchuController@hocsinhctdethi');
//Route::get('dethi/{id}','DeThiController@hocsinhctdethi');

//Route::get('ketqua','TrangchuController@tinhdiem');


Route::get('/auth/{provider}', 'SocialAuthController@redirectToProvider');
Route::get('/auth/{provide}/callback', 'SocialAuthController@handleProviderCallback');
Route::get('registration','AdminCmsUsersController@getRegistration');
Route::post('registration','AdminCmsUsersController@postRegistration');

Route::group([
    'middleware' => ['web', 'App\Http\Middleware\FrontendRequestLogin'],
], function (){
    Route::get('dethi/thamgiathi/{id}','TrangchuController@thamgiathi');
    Route::get('dethi/thamgiathi/ajax/{id}','TrangchuController@thamgiathi1');
    Route::get('exam-question/thamgiathi/{id}','TrangchuController@thamgiathi');
    Route::get('exam-question/thamgiathi/ajax/{id}','TrangchuController@thamgiathi1');
    Route::get('test-history','TrangchuController@getTestHistory');
    Route::get('tructuyen/{id}','TrangchuController@getdiemthi');
    Route::get('xemdapan/{id}','TrangchuController@getXemDapAn');
    Route::post('insertdapan','TrangchuController@chondapan');
    Route::post('thembinhluan/{id}','ThaoluandethiController@postthemcmt');
    Route::get('profile','AdminCmsUsersController@getFrontendProfile');
    Route::get('change-password','AdminCmsUsersController@getChangePassword');
    Route::get('transaction-history','TrangchuController@getTransactionHistory');
});
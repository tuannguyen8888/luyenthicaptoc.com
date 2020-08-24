<?php 
namespace App\Http\Controllers;

use DB;
use Session;
use Request;
use CRUDBooster;
use Illuminate\Support\Facades\Log;

class CBHook extends Controller {

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	public function afterLogin() {
        DB::table('cms_users')->where('id', CRUDBooster::myId())->whereNull('status')->update( [ 'status' => 'Active' ]);
        $redirect_url = Request::input("redirect_url");
        Log::debug('Request::input("redirect_url") = '. $redirect_url);
        if($redirect_url) {
            return redirect($redirect_url)->send();
            exit;
        }else if(CRUDBooster::myPrivilegeId()==4){
            return redirect('/')->send();
            exit;
        }
	}
}
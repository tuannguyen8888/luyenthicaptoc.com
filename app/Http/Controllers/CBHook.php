<?php 
namespace App\Http\Controllers;

use DB;
use Session;
use Request;
use CRUDBooster;

class CBHook extends Controller {

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	public function afterLogin() {
        DB::table('cms_users')->where('id', CRUDBooster::myId())->whereNull('status')->update( [ 'status' => 'Active' ]);
	}
}
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
        $user = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
        $redirect_url = Request::input("redirect_url");
        Log::debug('Request::input("redirect_url") = '. $redirect_url);
        if($user && !$user->phone){
            Log::debug('redirect profile');
//            return redirect('/profile')
//                ->with('message', 'Bạn cần phải cập nhật số điện thoại để tiếp tục.')
//                ->with('redirect_url', $redirect_url)
//                ->send();
//            session("message_type", 'warning');
//            session("message", 'Bạn cần phải cập nhật số điện thoại để tiếp tục.');

            return redirect('/profile')
                ->with('redirect_url', $redirect_url)
                ->with('message', 'Bạn cần phải cập nhật số điện thoại để tiếp tục.')
                ->with('message_type', 'warning')
                ->send();
            exit;
        }
        if($redirect_url) {
            Log::debug('redirect($redirect_url)');
            return redirect($redirect_url)->send();
            exit;
        }else if(CRUDBooster::myPrivilegeId()==4){
            Log::debug('redirect(\'/home\')');
            return redirect('/home')->send();
            exit;
        }
	}
}
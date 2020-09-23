<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite, Auth, Redirect, Session, URL;
use App\User;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    /**
     * Chuyển hướng người dùng sang OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if(!Session::has('pre_url')){
            Session::put('pre_url', URL::previous());
        }else{
            if(URL::previous() != URL::to('login')) Session::put('pre_url', URL::previous());
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Lấy thông tin từ Provider, kiểm tra nếu người dùng đã tồn tại trong CSDL
     * thì đăng nhập, ngược lại nếu chưa thì tạo người dùng mới trong SCDL.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $socia_user = Socialite::driver($provider)->user();

        Log::debug('$socia_user = ', [$socia_user]);

        $users = $this->findOrCreateUser($socia_user, $provider);
//        Auth::login($authUser, true);

        $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();

        $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', $users->id_cms_privileges)->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();

        $photo = ($users->photo) ? asset($users->photo) : asset('imgs/avatar.png');
        Session::put('admin_id', $users->id);
        Session::put('admin_is_superadmin', $priv->is_superadmin);
        Session::put('admin_name', $users->name);
        Session::put('admin_photo', $photo);
        Session::put('admin_privileges_roles', $roles);
        Session::put("admin_privileges", $users->id_cms_privileges);
        Session::put('admin_privileges_name', $priv->name);
        Session::put('admin_lock', 0);
        Session::put('theme_color', $priv->theme_color);
        Session::put("appname", CRUDBooster::getSetting('appname'));

        CRUDBooster::insertLog(trans("crudbooster.log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));

        $cb_hook_session = new \App\Http\Controllers\CBHook;
        $cb_hook_session->afterLogin();

        return Redirect::to(Session::get('pre_url'));
    }

    /**
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($socia_user, $provider)
    {
//        $authUser = User::where('provider_id', $socia_user->id)->first();
//        if ($authUser) {
//            return $authUser;
//        }
//        return User::create([
//            'name'     => $socia_user->name,
//            'email'    => $socia_user->email,
//            'provider' => $provider,
//            'provider_id' => $socia_user->id
//        ]);

        $authUser = DB::table(config('crudbooster.USER_TABLE'))
            ->where("status",'<>','Inactive')
            ->where("email", $socia_user->getEmail())
            ->first();
        if (!$authUser) {
            DB::table(config('crudbooster.USER_TABLE'))
                ->insert([
                    'name' => $socia_user->getName,
                    'email' => $socia_user->getEmail(),
                    'photo' => 'imgs/avatar.png',
                    'id_cms_privileges' => 4, // học viên
                    'password' => '',
                    'status' => 'Active',
//                    'phone' => $socia_user->phone
                ]);
            $authUser = DB::table(config('crudbooster.USER_TABLE'))
                ->where("status",'<>','Inactive')
                ->where("email", $socia_user->email)
                ->first();
        }
        return  $authUser;
    }
}

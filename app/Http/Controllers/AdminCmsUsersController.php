<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDbooster;
use Illuminate\Support\Facades\Log;

class AdminCmsUsersController extends CBExtendController {
	public function cbInit() {
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon_text';
		$this->button_import 	   = FALSE;	
		$this->button_export 	   = FALSE;	
		# END CONFIGURATION DO NOT REMOVE THIS LINE
	
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label"=>"Name","name"=>"name");
		$this->col[] = array("label"=>"Email","name"=>"email");
		$this->col[] = array("label"=>"Privilege","name"=>"id_cms_privileges","join"=>"cms_privileges,name");
		$this->col[] = array("label"=>"Avatar","name"=>"photo","image"=>1);
        $this->col[] = ["label"=> "Status","name"=>"status", "callback_php"=>'get_string_in_array($row->status,\Enums::$USER_STATUS);'];
        $this->col[] = ["label"=> "Last login","name"=>"(Select L.created_at from cms_logs as L where ".$this->table.".status is not null and L.id_cms_users = ".$this->table.".id order by L.created_at desc limit 1) as last_login", "callback_php"=>'date_time_format($row->last_login, \'Y-m-d H:i:s\', \'d/m/Y H:i:s\');'];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array(); 		
		$this->form[] = array("label"=>"Tên","name"=>"name",'required'=>true,'validation'=>'required|min:3');
		$this->form[] = array("label"=>"Email","name"=>"email",'required'=>true,'type'=>'email','validation'=>'required|email|unique:cms_users,email,'.CRUDBooster::getCurrentId());		
		$this->form[] = array("label"=>"Ảnh đại diện","name"=>"photo","type"=>"upload","help"=>"Recommended resolution is 200x200px",'required'=>false,'validation'=>'image|max:1000','resize_width'=>90,'resize_height'=>90);
		$this->form[] = array("label"=>"Vai trò","name"=>"id_cms_privileges","type"=>"select","datatable"=>"cms_privileges,name",'required'=>true);
		$this->form[] = array("label"=>"Mật khẩu","name"=>"password","type"=>"password","help"=>"Bỏ trống nếu bạn không muốn đổi mật khẩu mới");
		$this->form[] = array("label"=>"Xác nhận mật khẩu","name"=>"password_confirmation","type"=>"password","help"=>"Bỏ trống nếu bạn không muốn đổi mật khẩu mới");
		# END FORM DO NOT REMOVE THIS LINE
        $this->addaction[] = ['label' => 'Reset Password', 'url' => CRUDBooster::mainpath('reset-password/[id]'), 'icon' => 'fa fa-repeat', 'color' => 'info', 'confirmation' => true, 'confirmation_text' => 'Bạn chắc chắn muốn reset mật khẩu ?', 'confirmation_title' => 'Xác nhận', 'showIf'=>"[status] != 'Inactive'"];
        $this->addaction[] = ['label' => 'Khóa', 'url' => CRUDBooster::mainpath('block-user/[id]'), 'icon' => 'fa fa-lock', 'color' => 'danger', 'confirmation' => true, 'confirmation_text' => 'Bạn muốn khóa user đang chọn ?', 'confirmation_title' => 'Xác nhận', 'showIf'=>"[status] != 'Inactive'"];
        $this->addaction[] = ['label' => 'Mở khóa', 'url' => CRUDBooster::mainpath('unblock-user/[id]'), 'icon' => 'fa fa-unlock', 'color' => 'success', 'confirmation' => true, 'confirmation_text' => 'Bạn chắc chắn muốn mở khóa user đang chọn chứ?', 'confirmation_title' => 'Xác nhận', 'showIf'=>"[status] == 'Inactive'"];
	}
    public function hook_query_index(&$query) {
        //Your code here
        $query->whereNotIn('id_cms_privileges', HIDDEN_PRIVILEGES);
        $query->whereNull('deleted_at');
    }
	public function getProfile() {			

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;			
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;	
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = trans("crudbooster.label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users',CRUDBooster::myId());		
		$this->cbView('crudbooster::default.form',$data);				
	}
	public function hook_before_edit(&$postdata,$id) { 
		unset($postdata['password_confirmation']);
        if(!$postdata['photo']){
            $postdata['photo'] = 'imgs/avatar.png';
        }
	}
	public function hook_before_add(&$postdata) {      
	    unset($postdata['password_confirmation']);
        if(!$postdata['photo']){
            $postdata['photo'] = 'imgs/avatar.png';
        }
	}
    function getSearchUsers(){
        $para = Request::all();
        $search_term = $para['term'];
        $page = intval( $para['page']);
        $page_limit = intval( $para['page_limit']);
        $users = DB::table(USERS_TABLE_NAME.' as U')
            ->leftJoin(PRIVILEGES_TABLE_NAME.' as P', 'U.id_cms_privileges', '=', 'P.id')
            ->whereNull('U.deleted_at')
            ->whereRaw('IFNULL(U.status,\'\') <> \'Inactive\'')
            ->whereNotIn('U.id_cms_privileges',[1,5,7,8])
            ->where(function($w) use ($search_term) {
                $w->where('U.name','like','%'.$search_term.'%')
                ->orWhere('U.email','like','%'.$search_term.'%');
            })
            ->select(
                'U.id as id',
                DB::raw("CONCAT(U.name, ' - ', U.email, ' (',P.name,')') as text"))
            ->orderBy('U.name','asc')
            ->distinct()
            ->offset(($page-1)*$page_limit)
            ->limit($page_limit);
//        Log::debug(CRUDBooster::getCurrentMethod().' $users->toSql() = '.$users->toSql());
        return $users->get();
    }

    private function resetPassword($id){
        $characters = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM@#$%&';
        $len = strlen($characters);
        $new_password = '';
        for ($i=0;$i<6;$i++){
        $new_password .= $characters[rand(0, $len-1)];
        }
        $new_password_encode = \Hash::make($new_password);
        DB::table('cms_users')->where('id', $id)->update(['password' => $new_password_encode]);
        return $new_password;
	}
    public function getResetPassword($id)
    {
        $new_password = $this->resetPassword($id);

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "Mật khẩu được đặt lại là ".$new_password, "info");
    }
    public function getBlockUser($id)
    {
        $this->resetPassword($id);
        DB::table('cms_users')->where('id', $id)->update(['status' => 'Inactive']);

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "User đã bị khóa", "info");
    }
    public function getUnblockUser($id)
    {
        $new_password = $this->resetPassword($id);
        DB::table('cms_users')->where('id', $id)->update(['status' => 'Active']);

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "User đã được mở khóa, vui lòng đăng nhập với mật khẩu mới: ".$new_password, "info");
    }


}

<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDbooster;
use CB;
use Schema;
use Illuminate\Support\Facades\Log;

class AdminCmsUsersController extends CBExtendController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = 'cms_users';
        $this->primary_key = 'id';
        $this->title_field = "name";
        $this->button_action_style = 'button_icon_text';
        $this->button_import = FALSE;
        $this->button_export = FALSE;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Name", "name" => "name");
        $this->col[] = array("label" => "Email", "name" => "email");
        $this->col[] = array("label" => "Phone", "name" => "phone");
        $this->col[] = array("label" => "Số dư", "name" => "balance", "callback_php"=>'number_price_format($row->balance, 0);');
        $this->col[] = array("label" => "Vai trò", "name" => "id_cms_privileges", "join" => "cms_privileges,name");
        $this->col[] = array("label" => "Ảnh đại diện", "name" => "photo", "image" => 1);
        $this->col[] = ["label" => "Trạng thái", "name" => "status", "callback_php" => 'get_string_in_array($row->status,\Enums::$USER_STATUS);'];
        $this->col[] = ["label" => "Lần đăng nhập cuối", "name" => "(Select L.created_at from cms_logs as L where " . $this->table . ".status is not null and L.id_cms_users = " . $this->table . ".id order by L.created_at desc limit 1) as last_login", "callback_php" => 'date_time_format($row->last_login, \'Y-m-d H:i:s\', \'d/m/Y H:i:s\');'];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = array();
        if (\CRUDBooster::getCurrentMethod() == 'getChangePassword') {
            $this->form[] = array("label" => "Tên", "name" => "name", 'required' => true, 'readonly' => true, 'width' => 'col-sm-9', 'validation' => 'required|min:3');
        } else {
            $this->form[] = array("label" => "Tên", "name" => "name", 'required' => true, 'width' => 'col-sm-9', 'validation' => 'required|min:3');
        }
        if (\CRUDBooster::getCurrentMethod() == 'getFrontendProfile' || \CRUDBooster::getCurrentMethod() == 'getChangePassword') {
            $this->form[] = array("label" => "Email", "name" => "email", 'required' => true, 'readonly' => true, 'width' => 'col-sm-9', 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
        } else {
            $this->form[] = array("label" => "Email", "name" => "email", 'required' => true, 'width' => 'col-sm-9', 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
        }
        $this->form[] = array("label" => "Phone", "name" => "phone", 'required' => true, 'width' => 'col-sm-9', 'type' => 'text', 'validation' => 'required|regex:/[0-9]{10}/|unique:cms_users,phone,' . CRUDBooster::getCurrentId());
        $this->form[] = array("label" => "Số dư", "name" => "balance", 'width' => 'col-sm-4', 'type' => 'text', 'readonly' => true);
        $this->form[] = array("label" => "Ảnh đại diện", "name" => "photo", "type" => "upload", "help" => "Recommended resolution is 200x200px", 'required' => false, 'validation' => 'image|max:1000', 'resize_width' => 90, 'resize_height' => 90);
        $this->form[] = array("label" => "Vai trò", "name" => "id_cms_privileges", "type" => "select", "datatable" => "cms_privileges,name", 'required' => true, 'width' => 'col-sm-9');
        if (\CRUDBooster::getCurrentMethod() == 'getChangePassword' || \CRUDBooster::getCurrentMethod() == 'getRegistration') {
            $this->form[] = array("label" => "Mật khẩu mới", "name" => "password", "type" => "password", 'width' => 'col-sm-9','validation' => 'required|min:8', "help" => "Ít nhất 8 ký tự.");
            $this->form[] = array("label" => "Xác nhận mật khẩu mới", "name" => "password_confirmation", "type" => "password", 'width' => 'col-sm-9','validation' => 'required|min:8', "help" => "Nhập giống mật khẩu mới");
        } else {
            $this->form[] = array("label" => "Mật khẩu", "name" => "password", "type" => "password", 'width' => 'col-sm-9','validation' => 'min:8', "help" => "Bỏ trống nếu bạn không muốn đổi mật khẩu mới");
            $this->form[] = array("label" => "Xác nhận mật khẩu", "name" => "password_confirmation", "type" => "password", 'width' => 'col-sm-9', "help" => "Bỏ trống nếu bạn không muốn đổi mật khẩu mới");
        }
        # END FORM DO NOT REMOVE THIS LINE
        $this->addaction[] = ['label' => 'Reset Password', 'url' => CRUDBooster::mainpath('reset-password/[id]'), 'icon' => 'fa fa-repeat', 'color' => 'info', 'confirmation' => true, 'confirmation_text' => 'Bạn chắc chắn muốn reset mật khẩu ?', 'confirmation_title' => 'Xác nhận', 'showIf' => "[status] != 'Inactive'"];
        $this->addaction[] = ['label' => 'Khóa', 'url' => CRUDBooster::mainpath('block-user/[id]'), 'icon' => 'fa fa-lock', 'color' => 'danger', 'confirmation' => true, 'confirmation_text' => 'Bạn muốn khóa user đang chọn ?', 'confirmation_title' => 'Xác nhận', 'showIf' => "[status] != 'Inactive'"];
        $this->addaction[] = ['label' => 'Mở khóa', 'url' => CRUDBooster::mainpath('unblock-user/[id]'), 'icon' => 'fa fa-unlock', 'color' => 'success', 'confirmation' => true, 'confirmation_text' => 'Bạn chắc chắn muốn mở khóa user đang chọn chứ?', 'confirmation_title' => 'Xác nhận', 'showIf' => "[status] == 'Inactive'"];
    }

    public function hook_query_index(&$query)
    {
        //Your code here
        $query->whereNotIn('id_cms_privileges', HIDDEN_PRIVILEGES);
        $query->whereNull('deleted_at');
    }

    public function getProfile()
    {

        $this->button_addmore = FALSE;
        $this->button_cancel = FALSE;
        $this->button_show = FALSE;
        $this->button_add = FALSE;
        $this->button_delete = FALSE;
        $this->hide_form = ['id_cms_privileges'];

        $data['page_title'] = trans("crudbooster.label_button_profile");
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        $this->cbView('crudbooster::default.form', $data);
    }

    public function getFrontendProfile()
    {
        $this->button_addmore = FALSE;
        $this->button_cancel = TRUE;
        $this->button_show = FALSE;
        $this->button_add = FALSE;
        $this->button_delete = FALSE;
        $this->hide_form = ['id_cms_privileges', 'password', 'password_confirmation'];

        $data['page_title'] = trans("crudbooster.label_button_profile");
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        $redirect_url = session("redirect_url");
        $data['return_url'] = $redirect_url ? $redirect_url : '/home';
        $this->cbView('frontend.user_form', $data);
    }

    public function getChangePassword()
    {

        $this->button_addmore = FALSE;
        $this->button_cancel = TRUE;
        $this->button_show = FALSE;
        $this->button_add = FALSE;
        $this->button_delete = FALSE;
        $this->hide_form = ['phone', 'photo', 'id_cms_privileges'];

        $data['page_title'] = 'Đổi mật khẩu';
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        $redirect_url = session("redirect_url");
        $data['return_url'] = $redirect_url ? $redirect_url : '/home';
        $this->cbView('frontend.user_form', $data);
    }
    public function getRegistration()
    {
        $this->button_addmore = FALSE;
        $this->button_cancel = TRUE;
        $this->button_show = FALSE;
        $this->button_add = FALSE;
        $this->button_delete = FALSE;
        $this->hide_form = ['id_cms_privileges'];

        $data['page_title'] = 'Đăng ký tài khoản';
        $data['row'] = null;
        $redirect_url = session("redirect_url");
        $data['return_url'] = $redirect_url ? $redirect_url : '/home';
        $this->cbView('frontend.registration', $data);
    }
    public function postRegistration() {
        $this->cbLoader();

        $this->validation();
        $this->input_assignment();

        if(Schema::hasColumn($this->table, 'created_at'))
        {
            $this->arr['created_at'] = date('Y-m-d H:i:s');
        }

        //add by NguyenVT
        if (Schema::hasColumn($this->table, 'created_by')) {
            $this->arr['created_by'] = 2; //system user
        }

        $this->hook_before_add($this->arr);


        $this->arr[$this->primary_key] = $id = CRUDBooster::newId($this->table);
        DB::table($this->table)->insert($this->arr);


        //Looping Data Input Again After Insert
        foreach($this->data_inputan as $ro) {
            $name = $ro['name'];
            if(!$name) continue;

            $inputdata = Request::get($name);

            //Insert Data Checkbox if Type Datatable
            if($ro['type'] == 'checkbox') {
                if($ro['relationship_table']) {
                    $datatable = explode(",",$ro['datatable'])[0];
                    $foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();

                    if($inputdata) {
                        $relationship_table_pk = CB::pk($ro['relationship_table']);
                        foreach($inputdata as $input_id) {
                            DB::table($ro['relationship_table'])->insert([
                                $relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey=>$id,
                                $foreignKey2=>$input_id
                            ]);
                        }
                    }

                }
            }


            if($ro['type'] == 'select2') {
                if($ro['relationship_table']) {
                    $datatable = explode(",",$ro['datatable'])[0];
                    $foreignKey2 = CRUDBooster::getForeignKey($datatable,$ro['relationship_table']);
                    $foreignKey = CRUDBooster::getForeignKey($this->table,$ro['relationship_table']);
                    DB::table($ro['relationship_table'])->where($foreignKey,$id)->delete();

                    if($inputdata) {
                        foreach($inputdata as $input_id) {
                            $relationship_table_pk = CB::pk($ro['relationship_table']); //CB::pk($row['relationship_table']); edit by NguyenVT: $row -> $ro
                            DB::table($ro['relationship_table'])->insert([
                                $relationship_table_pk=>CRUDBooster::newId($ro['relationship_table']),
                                $foreignKey=>$id,
                                $foreignKey2=>$input_id
                            ]);
                        }
                    }

                }
            }

            if($ro['type']=='child') {
                $name = str_slug($ro['label'],'');
                $columns = $ro['columns'];
                $count_input_data = count(Request::get($name.'-'.$columns[0]['name']))-1;
                $child_array = [];

                for($i=0;$i<=$count_input_data;$i++) {
                    $fk = $ro['foreign_key'];
                    $column_data = [];
                    $column_data[$fk] = $id;
                    foreach($columns as $col) {
                        $colname = $col['name'];
                        $column_data[$colname] = Request::get($name.'-'.$colname)[$i];
                    }
                    $child_array[] = $column_data;
                }

                $childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
                DB::table($childtable)->insert($child_array);
            }



        }


        $this->hook_after_add($this->arr[$this->primary_key]);


        $this->return_url = ($this->return_url)?$this->return_url:Request::get('return_url');

        //insert log
        CRUDBooster::insertLog(trans("crudbooster.log_add",['name'=>$this->arr[$this->title_field],'module'=>CRUDBooster::getCurrentModule()->name]));

        if($this->return_url) {
            return redirect('/dangnhap?redirect_url='.$this->return_url)
                ->with('message', 'Đăng ký thành công. Vui lòng đăng nhập để tiếp tục.')
                ->with('message_type', 'success');
        }else{
            return redirect('/dangnhap')
                ->with('message', 'Đăng ký thành công. Vui lòng đăng nhập để tiếp tục.')
                ->with('message_type', 'success');
        }
    }
    public function hook_before_edit(&$postdata, $id)
    {
        unset($postdata['password_confirmation']);
        if (!$postdata['photo']) {
            $postdata['photo'] = 'imgs/avatar.png';
        }

        if (!$postdata['id_cms_privileges']) {
            $postdata['id_cms_privileges'] = 4;
        }
    }

    public function hook_before_add(&$postdata)
    {
        unset($postdata['password_confirmation']);
        if (!$postdata['photo']) {
            $postdata['photo'] = 'imgs/avatar.png';
        }
        if (!$postdata['id_cms_privileges']) {
            $postdata['id_cms_privileges'] = 4;
        }
    }

    function getSearchUsers()
    {
        $para = Request::all();
        $search_term = $para['term'];
        $page = intval($para['page']);
        $page_limit = intval($para['page_limit']);
        $users = DB::table(USERS_TABLE_NAME . ' as U')
            ->leftJoin(PRIVILEGES_TABLE_NAME . ' as P', 'U.id_cms_privileges', '=', 'P.id')
            ->whereNull('U.deleted_at')
            ->whereRaw('IFNULL(U.status,\'\') <> \'Inactive\'')
            ->whereNotIn('U.id_cms_privileges', [1, 5, 7, 8])
            ->where(function ($w) use ($search_term) {
                $w->where('U.name', 'like', '%' . $search_term . '%')
                    ->orWhere('U.email', 'like', '%' . $search_term . '%');
            })
            ->select(
                'U.id as id',
                DB::raw("CONCAT(U.name, ' - ', U.email, ' (',P.name,')') as text"))
            ->orderBy('U.name', 'asc')
            ->distinct()
            ->offset(($page - 1) * $page_limit)
            ->limit($page_limit);
//        Log::debug(CRUDBooster::getCurrentMethod().' $users->toSql() = '.$users->toSql());
        return $users->get();
    }

    private function resetPassword($id)
    {
        $characters = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM@#$%&';
        $len = strlen($characters);
        $new_password = '';
        for ($i = 0; $i < 12; $i++) {
            $new_password .= $characters[rand(0, $len - 1)];
        }
        $new_password_encode = \Hash::make($new_password);
        DB::table('cms_users')->where('id', $id)->update(['password' => $new_password_encode]);
        return $new_password;
    }

    public function getResetPassword($id)
    {
        $new_password = $this->resetPassword($id);

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "Mật khẩu được đặt lại là " . $new_password, "info");
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

        CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "User đã được mở khóa, vui lòng đăng nhập với mật khẩu mới: " . $new_password, "info");
    }

    public function logout()
    {
        $me = CRUDBooster::me();
        CRUDBooster::insertLog(trans("crudbooster.log_logout", ['email' => $me->email]));

        Session::flush();

        return redirect('/home')->with('message', trans("crudbooster.message_after_logout"));
    }
}

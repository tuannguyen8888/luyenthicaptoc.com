<?php
define("QUESTION_TABLE_NAME", 'cauhoi');
define("EXAM_QUESTION_TABLE_NAME", 'dethi');
define("EXAM_QUESTION_DETAIL_TABLE_NAME", 'ctdethi');
define("CORRECT_ANSWER_TABLE_NAME", 'dapandung');
define("BLOGS_TABLE_NAME", 'blogs');
define("BLOG_CATEGORIES_TABLE_NAME", 'blog_categories');
define("PAYMENT_CHANNEL_TABLE_NAME", 'payment_channel');
define("PAYMENT_CHANNEL_DETAIL_TABLE_NAME", 'payment_channel_detail');
define("TRANSACTION_TABLE_NAME", 'transaction');
define("TRANSACTION_CASHIN_CONFIRM_TABLE_NAME", 'transaction_cashin_confirm');
define("USER_TABLE_NAME", 'cms_users');
define("HIDDEN_PRIVILEGES", [1,2]);

class Enums {
    public static $YES_NO_NUMBER = "0|Không;1|Có";
    public static $YES_NO = "NO|Không;YES|Có";
    public static $TRANSACTION_STATUS = "INIT|<lable class='label label-default'>Khởi tạo</lable>;WAITING_CONFIRM|<lable class='label label-warning'>Chờ xác nhận</lable>;CONFIRMED|<lable class='label label-info'>Đã xác nhận</lable>;COMPLETED|<lable class='label label-success'>Thành công</lable>;USER_CANCELED|<lable class='label label-danger'>Hủy</lable>;TIMEOUT_CANCELED|<lable class='label label-danger'>Thất bại</lable>";
    public static $TRANSACTION_TYPE = "CASHIN|<lable class='label label-info'>Nạp tiền</lable>;".
    "BUY_EXAM_QUESTION|<lable class='label label-primary'>Mua đề thi</lable>;";
    public static $ACTIVATION_STATUS = "ACTIVE|<lable class='label label-info'>Kích hoạt</lable>;".
    "INACTIVE|<lable class='label label-warning'>Không kích hoạt</lable>;";
    public static $USER_STATUS = "Active|<lable class='label label-info'>Active</lable>;Inactive|<lable class='label label-danger'>Inactive</lable>;|<lable class='label label-warning'>Not yet login</lable>";
    public static $CORRECT_ANSWER = 'A|A;B|B;C|C;D|D';
}

if (!function_exists('find_string_in_array')) {
    function find_string_in_array ($arr, $string) {
        return array_filter($arr, function($value) use ($string) {
            return strpos($value, $string) !== false;
        });
    }
}
if (!function_exists('send_message_to_group_telegram')) {
    function send_message_to_group_telegram( $message, $chatId = null)
    {
        $botToken = env('TELEGRAM_BOT_EFUND_TOKEN');
        $website = env('TELEGRAM_API_BOT_URL', 'https://api.telegram.org/bot') . $botToken;

        if (!isset($chatId) || $chatId == null) {
            $chatId = env('TELEGRAM_GROUP_ID'); //Receiver Chat Id
        }

        $params = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);

        curl_close($ch);
    }
}
if (!function_exists('get_string_in_array')) {
    function get_string_in_array ($key, $enums) {
        $dataenum = (is_array($enums))?$enums:explode(";",$enums);
        $results = find_string_in_array ($dataenum,$key."|");
        if( !empty($results) ) {
            foreach ($results as $value) {
                //$results = array_values($results)[0];
                $val = $lab = '';
                if(strpos($value,'|')!==FALSE) {
                    $draw = explode("|",$value);
                    $val = $draw[0];
                    $lab = $draw[1];
                }else{
                    $val = $lab = $value;
                }
                if ($key == $val){
                    return $lab;
                }
            }

        }
        return '';
    }
}

if (!function_exists('get_string_no_html_in_array')) {
    function get_string_no_html_in_array ($key, $enums) {
        return strip_tags(get_string_in_array ($key, $enums));
    }
}

if (!function_exists('convert_enums_to_array')) {
    function convert_enum_to_array ($enums_string) {
        $dataenums = explode(";",trim($enums_string));
        $results = [];
        if($dataenums && count($dataenums)){
            foreach ($dataenums as $item) {
                $id_name = explode("|",$item);
                if($id_name && count($id_name)==2){
                    $results[] = ['id'=>$id_name[0], 'name'=>$id_name[1]];
                }
            }
        }
        return $results;
    }
}
if (!function_exists('get_data_source')) {
    function get_data_source ($data_source_table, $data_source_field) {
        $data = DB::table($data_source_table)
            ->whereNull('deleted_at')
            ->select('id', $data_source_field.' as name')
            ->get();
        return $data;
    }
}
if (!function_exists('get_display_in_data_source')) {
    function get_display_in_data_source ($id, $data_source_table, $data_source_field) {
        $display_name = DB::table($data_source_table)
            ->whereNull('deleted_at')
            ->where('id',$id)
            ->value($data_source_field);
        if($display_name){
            return $display_name;
        } else {
            return '';
        }
    }
}

if (!function_exists('arrayCopy')) {
    function arrayCopy(array $array)
    {
        $result = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $result[$key] = arrayCopy($val);
            } elseif (is_object($val)) {
                $result[$key] = clone $val;
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }
}
if (!function_exists('date_time_format')) {
    function date_time_format($dateTimeStr, $formatInString, $formatOutString) {
        if(!$dateTimeStr) return $dateTimeStr;
        $dateTime = DateTime::createFromFormat($formatInString, $dateTimeStr); // 'Y-m-d H:i:s'
        return $dateTime?$dateTime->format($formatOutString):'';
    }
}
if (!function_exists('number_price_format')) {
    function number_price_format($number, $formatNumber) {
        return number_format($number, $formatNumber);
    }
}
if (!function_exists('precent_format')) {
    function precent_format($number) {
        $formatter = (float)$number . '%';
        return $formatter;
    }
}

if (!function_exists('has_permission')) {
    function has_permission($privilege_id, $module_controller, $action) {
        $field = '';
        switch ($action){
            case 'VIEW_LIST':
                $field = 'PR.is_visible';
                break;
            case 'READ':
                $field = 'PR.is_read';
                break;
            case 'CREATE':
                $field = 'PR.is_create';
                break;
            case 'EDIT':
            case 'UPDATE':
                $field = 'PR.is_edit';
                break;
            case 'DELETE':
                $field = 'PR.is_delete';
                break;
        }
        if($field) {
            $has_permission =DB::table(PRIVILEGES_ROLES_TABLE_NAME . ' as PR')
                ->leftJoin(MODULES_TABLE_NAME . ' as M', 'PR.id_cms_moduls', '=', 'M.id')
                ->whereNull('M.deleted_at')
                ->where('PR.id_cms_privileges', $privilege_id)
                ->where('M.controller', $module_controller)
                ->value($field);
            return intval($has_permission) == 1;
        }else{
            return false;
        }
    }
}
if (!function_exists('read_notification')) {
    function read_notification($url, $user_id) {
        Log::debug(CRUDBooster::getCurrentMethod().' $user_id = '.$user_id.' ; $url = '.$url);
        DB::table(NOTIFICATION_TABLE_NAME)
            ->whereRaw("'".$url."' like CONCAT('%',url)")
            ->where('is_read', 0)
//            ->where('id_cms_users', $user_id)
            ->update([
                'is_read'=>1,
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
    }
}
if (!function_exists('is_about_expire')) {
    function is_about_expire($expire_date) {
        if($expire_date) {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $expire_date);
            $expire_date = DateTime::createFromFormat('Y-m-d', $dateTime->format('Y-m-d'));
            $today = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
            return $expire_date->diff($today)->days <= 7; // <= 7 ngày thì nó là gần hết hạn
        }else{
            return false;
        }
    }
}


if (!function_exists('get_total_users')) {
    function get_total_users() {
        return DB::table('cms_users')->count();
    }
}
if (!function_exists('get_total_questions')) {
    function get_total_questions() {
        return DB::table('cauhoi')->count();
    }
}
if (!function_exists('get_total_exams')) {
    function get_total_exams() {
        return DB::table('dethi')->count();
    }
}
if (!function_exists('get_total_visitors')) {
    function get_total_visitors() {
        return DB::table('cms_logs')->count();
    }
}
if (!function_exists('remove_vietnam_sign')) {
    function remove_vietnam_sign($str) {
        $unicode = array(

            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

            'd'=>'đ',

            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

            'i'=>'í|ì|ỉ|ĩ|ị',

            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'D'=>'Đ',

            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach($unicode as $nonUnicode=>$uni){

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);

        }
        $str = str_replace(' ','_',$str);

        return $str;
    }
}
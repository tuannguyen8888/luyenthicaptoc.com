<?php
define("QUESTION_TABLE_NAME", 'cauhoi');
define("CORRECT_ANSWER_TABLE_NAME", 'dapandung');
define("HIDDEN_PRIVILEGES", [1,2]);

class Enums {
    public static $YES_NO_NUMBER = "0|Không;1|Có";
    public static $YES_NO = "NO|Không;YES|Có";
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
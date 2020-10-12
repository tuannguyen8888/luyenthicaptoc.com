<?php namespace App\Http\Controllers;

    use Psy\Util\Json;
    use Session;
    use Request;
    use DB;
    use CRUDBooster;
    use Enums;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\PDF;
    use Maatwebsite\Excel\Facades\Excel;
    use Illuminate\Support\Facades\Route;
    use Schema;
    use CB;
    use DateTime;
    use Illuminate\Support\Facades\Log;

	class AdminExamQuestionController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon_text";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = false;
			$this->button_import = true;
			$this->button_export = false;
			$this->table = "dethi";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
            $this->col[] = ["label"=>"Mã đề","name"=>"id"];
            $this->col[] = ["label"=>"Tên đề thi","name"=>"Name"];
			$this->col[] = ["label"=>"Kỳ thi","name"=>"id_ky","join"=>"kythi,tenky"];
			$this->col[] = ["label"=>"Môn học","name"=>"id_mh","join"=>"monthi,tenmh"];
			$this->col[] = ["label"=>"Thời gian thi (phút)","name"=>"thoigianthi"];
//			$this->col[] = ["label"=>"Ngày thi","name"=>"ngaythi"];
			$this->col[] = ["label"=>"Số câu hỏi","name"=>"socau"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Mã đề','name'=>'id','type'=>'text','validation'=>'integer','width'=>'col-sm-4','help'=>'Mã đề sẽ tự phát sinh khi lưu','readonly'=>'true','disabled'=>'true'];
            $this->form[] = ['label'=>'Tên đề thi','name'=>'name','type'=>'text','validation'=>'required|string','width'=>'col-sm-4'];
			$this->form[] = ['label'=>'Kỳ thi','name'=>'id_ky','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'kythi,tenky','datatable_ajax'=>'true'];
			$this->form[] = ['label'=>'Môn học','name'=>'id_mh','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Thời gian thi (phút)','name'=>'thoigianthi','type'=>'number','validation'=>'required|min:1|max:255|integer','width'=>'col-sm-10','datatable'=>'monthi,tenmh','datatable_ajax'=>'true'];
//			$this->form[] = ['label'=>'Ngày thi','name'=>'ngaythi','type'=>'text','validation'=>'required|min:1|max:255|date','width'=>'col-sm-10'];

//			$columns = [];
//            $columns[] = array("label" => 'Câu hỏi', "name" => "id_cauhoi", 'type' => 'datamodal', 'validation' => 'required', 'width' => 'col-sm-9', 'datamodal_table' => 'cauhoi', 'datamodal_columns' => 'id_cauhoi,noidung', 'datamodal_size' => 'small', 'datamodal_where' => '', 'datamodal_columns_alias' => 'ID,Nội dung câu hỏi');
//			$this->form[] = ['label' => 'Danh sách câu hỏi', 'name' => 'id_de', 'type' => 'child', 'columns' => $columns, 'table' => EXAM_QUESTION_DETAIL_TABLE_NAME, 'foreign_key' => 'id_de', 'width' => 'col-sm-10'];
            # END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"De","name"=>"id_de","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"de,id"];
			//$this->form[] = ["label"=>"Ky","name"=>"id_ky","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"ky,id"];
			//$this->form[] = ["label"=>"Khoi","name"=>"id_khoi","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"khoi,id"];
			//$this->form[] = ["label"=>"Mh","name"=>"id_mh","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"mh,id"];
			//$this->form[] = ["label"=>"Thoigianthi","name"=>"thoigianthi","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Ngaythi","name"=>"ngaythi","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Socau","name"=>"socau","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Gv","name"=>"id_gv","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"gv,id"];
			//$this->form[] = ["label"=>"Trangthai","name"=>"trangthai","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


        public function getImportData() {
            set_time_limit(0);
            ini_set('memory_limit', '4294967296');
            $this->cbLoader();
            $data['page_menu']       = Route::getCurrentRoute()->getActionName();
            $module     = CRUDBooster::getCurrentModule();
            $data['page_title']      = 'Import dữ liệu: '.$module->name;

            if(Request::get('file') && !Request::get('import')) {
                $file = base64_decode(Request::get('file'));
                $file = storage_path('app/'.$file);
                $rows = Excel::load($file,function($reader) {
                    $reader->noHeading();
//                    $reader->skipRows(4);
//                    $reader->limitRows(5);
                    $reader->limitColumns(9);
                    $reader->toArray();
                })->get();
                Log::debug('count($rows) = ', [count($rows)]);
                Session::put('total_data_import',count($rows)-1);
                $table_rows = [];
                for ($i=0; $i < 5; $i++){
                    $table_rows[] = clone $rows[$i];
                }
                $data['table_rows'] = $table_rows; /// $data['table_rows'] = $rows; chuyển qua load bằng ajax
                Session::put('table_rows',$table_rows);
                unlink($file);
                // $data_import_column = array();
//                Log::debug('$rows = ',[Json::encode($rows)]);
//                foreach($rows as $value) {
//                    $a = array();
//                    Log::debug('$value = ' . Json::encode($value));
//                    if($value == 'STT') {
//                        foreach ($value as $k => $v) {
//                            $a[] = $k;
//                        }
//                        if (count($a)) {
//                            $data_import_column = $a;
//                        }
//                        break;
//                    }
//                }
                if($rows[0][0] == 'Trường' && $rows[0][1] != null
                    && $rows[1][0] == 'Tên đề thi' && $rows[1][1] != null
                    && $rows[2][0] == 'Môn học' && $rows[2][1] != null
                    && $rows[3][0] == 'Kỳ thi' && $rows[3][1] != null
                    && $rows[4][0] == 'STT'
                    && $rows[4][1] == 'Loại câu hỏi'
                    && $rows[4][2] == 'Mức độ'
                    && $rows[4][3] == 'Nội dung'
                    && $rows[4][4] == 'A'
                    && $rows[4][5] == 'B'
                    && $rows[4][6] == 'C'
                    && $rows[4][7] == 'D'
                    && $rows[4][8] == 'Đáp án đúng (A/B/C/D)')
                {
                    Log::debug('File dung dinh dang');
                    $table_columns = $rows[4]->toArray();
                    $data['table_columns'] = $table_columns;
                    $data_import_column = $rows[4]->toArray();
                    $data['data_import_column'] = $data_import_column;
                    // Session::put('select_column',$table_columns);
                    $data_review = [];
                    for ($i=5;$i<count($rows);$i++){
                        $data_review[] = clone $rows[$i];
                    }
                    $data['data_review'] = $data_review;
                    Session::put('data_import', $data_review);
                } else {
                    //File không đúng định dạng
                    Log::debug('File KHONG dung dinh dang');
                    $message_all = [sprintf('File không đúng định dạng, vui lòng kiểm tra lại.','File')];
                    $res = redirect()->back()->with(['message'=>trans('crudbooster.alert_validation_error',['error'=>implode(', ',$message_all)]),'message_type'=>'warning'])->withInput();
                    Session::driver()->save();
                    $res->send();
                    exit();
                }
            } else {
                if (!(strpos( Request::server('HTTP_REFERER'), 'done-import') !== false || strpos(Request::server('HTTP_REFERER'), 'import-data') !== false)) {
                    Session::put('return_url',Request::server('HTTP_REFERER'));
                }
            }
            return view('import_exam_question',$data);
        }

        public function postDoneImport() {
            set_time_limit(0);
            ini_set('memory_limit', '4294967296');
            $this->cbLoader();
            $data['page_menu']       = Route::getCurrentRoute()->getActionName();
            $module     = CRUDBooster::getCurrentModule();
            $data['page_title']      = trans('crudbooster.import_page_title',['module'=>$module->name]);
            //Session::put('select_column',Request::get('select_column'));
            return view('crudbooster::import',$data);
        }
        public function postDoImportChunk() {
            set_time_limit(0);
            ini_set('memory_limit', '4294967296');
            $this->cbLoader();
            $file_md5 = md5(Request::get('file'));

            if(Request::get('file') && Request::get('resume')==1) {
                $total = Session::get('total_data_import');
                $prog = intval(Cache::get('success_'.$file_md5)) / $total * 100;
                $prog = round($prog,2);
                if($prog >= 100) {
                    Cache::forget('success_'.$file_md5);
                }
                return response()->json(['progress'=> $prog, 'last_error'=>Cache::get('error_'.$file_md5) ]);
            }

            $table_rows = Session::get('table_rows');
            $data_import = Session::get('data_import');
            $school_name = trim($table_rows[0][1]);
            $exam_question_name = trim($table_rows[1][1]);
            $subject_name = trim($table_rows[2][1]);
            $exam_name = trim($table_rows[3][1]);
            $school = DB::table('school')->where('name', $school_name)->first();
            if($school){
                $school_id = $school->id;
            }else{
                $school_id = DB::table('school')->insertGetId([
                    'code' => strtoupper(remove_vietnam_sign($school_name)),
                    'name' => $school_name,
                    'address' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
            }
            Cache::increment('success_'.$file_md5);
            $subject = DB::table('monthi')->where('tenmh', $subject_name)->first();
            if($subject){
                $subject_id = $subject->id_mh;
            }else{
                $subject_id = DB::table('monthi')->insertGetId([
                    'tenmh' => $subject_name,
                    'hinhanh' => 'imgs/totnghiep.png',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
            }
            Cache::increment('success_'.$file_md5);
            $exam = DB::table('kythi')->where('tenky', $exam_name)->first();
            if($exam){
                $exam_id = $exam->id;
            }else{
                $exam_id = DB::table('kythi')->insertGetId([
                    'tenky' => $exam_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
            }
            Cache::increment('success_'.$file_md5);
            $exam_question = DB::table('dethi')->where('name', $exam_question_name)->first();
            if($exam_question){
                $exam_question_id = $exam_question->id;
            }else{
                $exam_question_id = DB::table('dethi')->insertGetId([
                    'name' => $exam_question_name,
                    'id_ky' => $exam_id,
                    'id_mh' => $subject_id,
                    'shool_ids' => $school_id.',',
                    'thoigianthi' => 45,
                    'socau' => count($data_import),
                    'trangthai' => 'ACTIVE',
                    'price' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
            }
            Cache::increment('success_'.$file_md5);
            $pre_question_type_name = '';
            $pre_level_name = '';
            foreach ($data_import as $row){
                $question_type_name = $row[1];
                if($pre_question_type_name != $question_type_name) {
                    $question_type = DB::table('loaicauhoi')->where('tenloai', $question_type_name)->first();
                    $pre_question_type_name = $question_type_name;
                    if($question_type){
                        $question_type_id = $question_type->id;
                    }else{
                        $question_type_id = DB::table('loaicauhoi')->insertGetId([
                            'tenloai' => $question_type_name,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => CRUDBooster::myId()
                        ]);
                    }
                }
                $level_name = $row[2];
                if($pre_level_name != $level_name) {
                    $level = DB::table('mucdo')->where('tenmd', $level_name)->first();
                    $pre_level_name = $level_name;
                    if($level){
                        $level_id = $level->id_mucdo;
                    }else{
                        $level_id = DB::table('tenmd')->insertGetId([
                            'tenmd' => $level_name,
                            'created_at' => date('Y-m-d H:i:s'),
                            'created_by' => CRUDBooster::myId()
                        ]);
                    }
                }
                $question_id = DB::table('cauhoi')->insertGetId([
                    'noidung' => $row[3],
                    'hinhanh' => null,
                    'a' => $row[4],
                    'b' => $row[5],
                    'c' => $row[6],
                    'd' => $row[7],
                    'correct_answer' => strtoupper($row[8]),
                    'id_loaich' => $question_type_id,
                    'id_mucdo' => $level_id,
                    'id_mh' => $subject_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
                DB::table('dapandung')->insertGetId([
                    'id_cauhoi' => $question_id,
                    'noidung' => strtoupper($row[8]) ,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
                DB::table('ctdethi')->insertGetId([
                    'id_de' => $exam_question_id,
                    'id_cauhoi' => $question_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
                Cache::increment('success_'.$file_md5);
            }
            Session::put('table_rows',null);//đặt lại cho đỡ nặng memory
            Session::put('data_import',null);//đặt lại cho đỡ nặng memory
            return response()->json(['status'=>true]);
        }
	}
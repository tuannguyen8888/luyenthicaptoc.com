<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminQuestionController extends CBExtendController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id_cauhoi";
			$this->limit = "20";
			$this->orderby = "id_cauhoi,desc";
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
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "cauhoi";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"ID","name"=>"id_cauhoi"];
//            $this->col[] = ["label"=>"Khối","name"=>"id_khoi","join"=>"khoi,tenkhoi"];
            $this->col[] = ["label"=>"Môn học","name"=>"id_mh","join"=>"monthi,tenmh"];
            $this->col[] = ["label"=>"Loại","name"=>"id_loaich","join"=>"loaicauhoi,tenloai"];
            $this->col[] = ["label"=>"Mức độ","name"=>"id_mucdo","join"=>"mucdo,tenmd"];
			$this->col[] = ["label"=>"Nội dung","name"=>"noidung"];
//			$this->col[] = ["label"=>"Hình ảnh","name"=>"hinhanh","image"=>true];
			$this->col[] = ["label"=>"Đáp án A","name"=>"a"];
			$this->col[] = ["label"=>"Đáp án B","name"=>"b"];
			$this->col[] = ["label"=>"Đáp án C","name"=>"c"];
			$this->col[] = ["label"=>"Đáp án D","name"=>"d"];
            $this->col[] = ['label' => 'Đáp án đúng', 'name' => 'correct_answer', "callback_php"=>'get_string_in_array($row->correct_answer,\Enums::$CORRECT_ANSWER);'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
//			$this->form[] = ['label'=>'Khối','name'=>'id_khoi', 'type' => 'select2',"datatable"=>"khoi,tenkhoi",'required'=>true,'validation'=>'required|integer|min:0','width'=>'col-sm-4'];
			$this->form[] = ['label'=>'Môn học','name'=>'id_mh', 'type' => 'select2',"datatable"=>"monthi,tenmh",'required'=>true,'validation'=>'required|integer|min:0','width'=>'col-sm-4'];
			$this->form[] = ['label'=>'Loại','name'=>'id_loaich', 'type' => 'select2',"datatable"=>"loaicauhoi,tenloai",'required'=>true,'validation'=>'required|integer|min:0','width'=>'col-sm-4'];
			$this->form[] = ['label'=>'Mức độ','name'=>'id_mucdo', 'type' => 'select2',"datatable"=>"mucdo,tenmd",'required'=>true,'validation'=>'required|integer|min:0','width'=>'col-sm-4'];
			$this->form[] = ['label'=>'Nội dung','name'=>'noidung','type'=>'wysiwyg','required'=>true,'validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
//			$this->form[] = ['label'=>'Hình ảnh','name'=>'hinhanh','type'=>'upload','required'=>true,'validation'=>'required|image','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Đáp án A','name'=>'a','type'=>'wysiwyg','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Đáp án B','name'=>'b','type'=>'wysiwyg','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Đáp án C','name'=>'c','type'=>'wysiwyg','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Đáp án D','name'=>'d','type'=>'wysiwyg','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
            $this->form[] = ['label' => 'Đáp án đúng', 'name' => 'correct_answer', 'type' => 'select', 'required'=>true, 'width' => 'col-sm-4', 'dataenum' => \Enums::$CORRECT_ANSWER];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Cauhoi","name"=>"id_cauhoi","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"cauhoi,id"];
			//$this->form[] = ["label"=>"Noidung","name"=>"noidung","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Hinhanh","name"=>"hinhanh","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"A","name"=>"a","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"B","name"=>"b","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"C","name"=>"c","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"D","name"=>"d","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Loaich","name"=>"id_loaich","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"loaich,id"];
			//$this->form[] = ["label"=>"Mucdo","name"=>"id_mucdo","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"mucdo,id"];
			//$this->form[] = ["label"=>"Khoi","name"=>"id_khoi","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"khoi,id"];
			//$this->form[] = ["label"=>"Mh","name"=>"id_mh","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"mh,id"];
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
            $question = DB::table(QUESTION_TABLE_NAME.' as Q')->where('id_cauhoi', $id)->first();
            DB::table(CORRECT_ANSWER_TABLE_NAME.' as CA')->insertGetId([
                'id_cauhoi' => $id,
                'noidung' => $question->correct_answer,
                'created_at' => date('Y-m-d H:i:s'),
//                'created_by' => CRUDBooster::myId(),
            ]);
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
            $question = DB::table(QUESTION_TABLE_NAME.' as Q')->where('id_cauhoi', $id)->first();
            $correct_answer = DB::table(CORRECT_ANSWER_TABLE_NAME.' as CA')->where('id_cauhoi', $id)->first();
            if($correct_answer){
                DB::table(CORRECT_ANSWER_TABLE_NAME.' as CA')->where('id_dad', $correct_answer->id_dad)->update([
                    'noidung' => $question->correct_answer,
                    'updated_at' => date('Y-m-d H:i:s'),
//                  'updated_by' => CRUDBooster::myId(),
                ]);
            }else {
                DB::table(CORRECT_ANSWER_TABLE_NAME.' as CA')->insertGetId([
                    'id_cauhoi' => $id,
                    'noidung' => $question->correct_answer,
                    'created_at' => date('Y-m-d H:i:s'),
//                  'created_by' => CRUDBooster::myId(),
                ]);
            }
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


	}
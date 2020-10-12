<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThaoLuanDeThi;
use DB;
use Auth;
class ThaoluandethiController extends Controller
{
    public function postthemcmt($id, Request $req){
    	$id_dethi = $id;
    	
    	$this->validate($req, 
        [
          'noidung'=> 'required'
        ],
        [
          'noidung.required' =>'Vui lòng nhập nội dung!'
        ]
      );

    	DB::table('thaoluandethi')->insert([
            'noidung' => $req->noidung,
            'id_de' => $id_dethi,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => CRUDBooster::myId()
        ]);

    	return redirect("dethi/$id");
    }


}

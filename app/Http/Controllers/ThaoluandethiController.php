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

    	$thaoluan = new ThaoLuanDeThi;
    	$thaoluan->id_de = $id_dethi;
    	$thaoluan->id = Auth::user()->id;
    	$thaoluan->noidung = $req->noidung;
    	$thaoluan->save();

    	return redirect("dethi/$id");
    }


}

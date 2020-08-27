<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThaoLuanDeThi;
use DB;
use Auth;
class ContactUsController extends Controller
{
    public function getIndex()
    {
        return view('frontend.contact',[]);
    }
}

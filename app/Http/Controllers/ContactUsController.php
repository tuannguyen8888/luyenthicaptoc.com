<?php

namespace App\Http\Controllers;

use DB;
use Auth;
class ContactUsController extends Controller
{
    public function getIndex()
    {
        return view('frontend.contact',[]);
    }
}

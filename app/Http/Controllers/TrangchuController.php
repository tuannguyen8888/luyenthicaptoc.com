<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use PdfMerger;
use DB;
use Auth;
use Hash;
use Illuminate\Support\Facades\Log;

class TrangchuController extends Controller
{
    public function getArticle($id)
    {
        if (is_numeric($id)) {
            $article = DB::table(BLOGS_TABLE_NAME . ' as B')
                ->leftJoin(BLOG_CATEGORIES_TABLE_NAME . ' as C', 'B.blog_category_id', '=', 'C.id')
                ->whereNull('B.deleted_at')->where('is_active', 1)->where('B.id', $id)
                ->select(
                    'C.name as category_name',
                    'C.id as category_id',
                    'B.blog_title',
                    'B.blog_slug',
                    'B.blog_image',
                    'B.description',
                    'B.created_at',
                    'B.updated_at',
                    'B.created_by',
                    'B.updated_by'
                )->first();
        } else {
            $article = DB::table(BLOGS_TABLE_NAME . ' as B')
                ->leftJoin(BLOG_CATEGORIES_TABLE_NAME . ' as C', 'B.blog_category_id', '=', 'C.id')
                ->whereNull('B.deleted_at')->where('is_active', 1)->where('B.blog_slug', $id)
                ->select(
                    'C.name as category_name',
                    'C.id as category_id',
                    'B.blog_title',
                    'B.blog_slug',
                    'B.blog_image',
                    'B.description',
                    'B.created_at',
                    'B.updated_at',
                    'B.created_by',
                    'B.updated_by'
                )->first();
        }
        return view('frontend.article', ['article' => $article]);
    }

    public function getCategory($id)
    {
        if (is_numeric($id)) {
            $category = DB::table(BLOG_CATEGORIES_TABLE_NAME . ' as C')
                ->whereNull('C.deleted_at')->where('C.id', $id)
                ->first();
            $articles = DB::table(BLOGS_TABLE_NAME . ' as B')
                ->leftJoin(BLOG_CATEGORIES_TABLE_NAME . ' as C', 'B.blog_category_id', '=', 'C.id')
                ->whereNull('B.deleted_at')->where('B.is_active', 1)->where('C.id', $id)
                ->select(
                    'B.blog_title',
                    'B.blog_slug',
                    'B.blog_image',
                    'B.description',
                    'B.created_at',
                    'B.updated_at',
                    'B.created_by',
                    'B.updated_by'
                )->paginate(10);
        } else {
            $category = DB::table(BLOG_CATEGORIES_TABLE_NAME . ' as C')
                ->whereNull('C.deleted_at')->where('C.category_slug', $id)
                ->first();
            $articles = DB::table(BLOGS_TABLE_NAME . ' as B')
                ->leftJoin(BLOG_CATEGORIES_TABLE_NAME . ' as C', 'B.blog_category_id', '=', 'C.id')
                ->whereNull('B.deleted_at')->where('B.is_active', 1)->where('C.category_slug', $id)
                ->select(
                    'B.blog_title',
                    'B.blog_slug',
                    'B.blog_image',
                    'B.description',
                    'B.created_at',
                    'B.updated_at',
                    'B.created_by',
                    'B.updated_by'
                )->paginate(10);
        }
        return view('frontend.articles_category', ['category' => $category, 'articles' => $articles]);
    }

    public function getExamQuestions()
    {
        $dethi = DB::table('dethi as DT')
            ->leftJoin('monthi as MT', 'MT.id', '=', 'DT.id_mh')
            ->leftJoin('kythi as KT', 'KT.id', '=', 'DT.id_ky')
            ->select(
                'DT.name',
                'MT.tenmh',
                'MT.hinhanh',
                'KT.tenky',
                'DT.socau',
                'DT.thoigianthi',
                'DT.id',
                'DT.id as id_de',
                DB::raw('(Select count(*) From bailam as BL Where BL.id_de = DT.id) as used_count')
            )
            ->orderBy('DT.created_at', 'desc')
            ->paginate(20);

        $dethi2 = DB::table('dethi as DT')
            ->leftJoin('monthi as MT', 'MT.id', '=', 'DT.id_mh')
            ->leftJoin('kythi as KT', 'KT.id', '=', 'DT.id_ky')
            ->select(
                'DT.name',
                'MT.tenmh',
                'MT.hinhanh',
                'KT.tenky',
                'DT.socau',
                'DT.thoigianthi',
                'DT.id',
                'DT.id as id_de',
                DB::raw('(Select count(*) From bailam as BL Where BL.id_de = DT.id) as used_count')
            )
            ->where('DT.price', '>', 0)
            ->orderBy('DT.created_at', 'desc')
            ->paginate(20);

        $dethi3 = DB::table('dethi as DT')
            ->leftJoin('monthi as MT', 'MT.id', '=', 'DT.id_mh')
            ->leftJoin('kythi as KT', 'KT.id', '=', 'DT.id_ky')
            ->select(
                'DT.name',
                'MT.tenmh',
                'MT.hinhanh',
                'KT.tenky',
                'DT.socau',
                'DT.thoigianthi',
                'DT.id',
                'DT.id as id_de',
                DB::raw('(Select count(*) From bailam as BL Where BL.id_de = DT.id) as used_count')
            )
            ->where('DT.price', '=', 0)
            ->orderBy('DT.created_at', 'desc')
            ->paginate(20);

        return view('frontend.home', ['dethi' => $dethi, 'dethi2' => $dethi2, 'dethi3' => $dethi3]);
    }

    public function getSearch(Request $req)
    {
        $dethi = DB::table('dethi as DT')
            ->leftJoin('monthi as MT', 'MT.id', '=', 'DT.id_mh')
            ->leftJoin('kythi as KT', 'KT.id', '=', 'DT.id_ky')
            ->select(
                'DT.name',
                'MT.tenmh',
                'MT.hinhanh',
                'KT.tenky',
                'DT.socau',
                'DT.thoigianthi',
                'DT.id',
                'DT.id as id_de',
                DB::raw('(Select count(*) From bailam as BL Where BL.id_de = DT.id) as used_count')
            )
            ->where('KT.tenky', 'like', '%' . $req->key . '%')
            ->orWhere('MT.tenmh', 'like', '%' . $req->key . '%')
            ->orWhere('DT.name', 'like', '%' . $req->key . '%')
            ->paginate(20);

        return view('frontend.search', ['dethi' => $dethi, 'key' => $req->key]);
    }

    public function thamgiathi($id)
    {
//         $dethi = DB::table('dethi')->where('id',$id)->first();
        $dethi = DB::table('dethi')
            ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
            ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
            ->select('dethi.name', 'monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id', 'dethi.id as id_de')
            ->where('dethi.id', '=', $id)
            ->first();
        $user = CRUDBooster::myId();
        $soluongcau = $dethi->socau;
// dd($soluongcau);
        $ctdethi = DB::table('ctdethi')
            ->join('cauhoi', 'cauhoi.id', '=', 'ctdethi.id_cauhoi')
            ->join('dethi', 'dethi.id', '=', 'ctdethi.id_de')
            ->where('ctdethi.id_de', '=', $id)
            ->select('ctdethi.id_de', 'ctdethi.id_cauhoi', 'cauhoi.noidung', 'cauhoi.hinhanh', 'cauhoi.id_loaich', 'cauhoi.a', 'cauhoi.b', 'cauhoi.c', 'cauhoi.d')
            ->get();

        $id_bailam = DB::table('bailam')->insertGetId([
            'id_de' => $id,
            'user_id' => CRUDBooster::myId(),
            'fee' => $dethi->price ? $dethi->price : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => CRUDBooster::myId(),
        ]);
        $ctbailam = DB::table('ctbailam')
            ->where('ctbailam.id_de', '=', $id)
            ->where('ctbailam.id_bailam', '=', $id_bailam)
            ->get()->pluck('id_cauhoi');

        return view('frontend.take_test', ['id_bailam' => $id_bailam, 'dethi' => $dethi, 'ctdethi' => $ctdethi, 'user' => $user, 'ctbailam' => $ctbailam]);

    }

    public function chondapan(Request $request)
    {
        $dap_an_cu = DB::table('ctbailam')
            ->where('id_bailam', $request->id_bailam)
            ->where('id_cauhoi', $request->id_cauhoi)
            ->where('id_de', $request->id_de)
            ->where('id_user', CRUDBooster::myId())
            ->whereNull('deleted_at')
            ->first();
        if ($dap_an_cu) {
            DB::table('ctbailam')
                ->where('id', $dap_an_cu->id)
                ->update([
                    'da_chon' => $request->da_chon,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => CRUDBooster::myId()
                ]);
            return ['id_ctbailam' => $dap_an_cu->id];
        } else {
            $id_ctbailam = DB::table('ctbailam')
                ->insertGetId([
                    'id_bailam' => $request->id_bailam,
                    'id_cauhoi' => $request->id_cauhoi,
                    'da_chon' => $request->da_chon,
                    'id_de' => $request->id_de,
                    'id_user' => CRUDBooster::myId(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => CRUDBooster::myId()
                ]);
            return ['id_ctbailam' => $id_ctbailam];
        }
    }


    public function getdiemthi($id)
    {
        $ketqua = DB::table('ketqua')->where('id_bailam', $id)->whereNull('deleted_at')->first();
        if ($ketqua) {
            $ctde = DB::table('dethi')
                ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
                ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
                ->join('bailam', function ($join) {
                    $join->on('bailam.id_de', '=', 'dethi.id')
                        ->where('bailam.user_id', '=', CRUDBooster::myId());
                })
                ->select('dethi.name', 'monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id as id_de')
                ->where('bailam.id', '=', $id)
                ->get()->toArray();
            $user = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
            $email = $user->email;

            $tyle = ($ketqua->diem * 100) / 10;
            $lamtrontyle = round($tyle, 2);

            return view('frontend.test_result', [
                'id_bailam' => $id,
                'lamtrondiem' => $ketqua->diem,
                'count' => $ctde[0]->socau,
                'lamtrontyle' => $lamtrontyle,
                'ctde' => $ctde,
                'dung' => $ketqua->socaudung,
                'email' => $email
            ]);
        } else {
            $ctde = DB::table('dethi')
                ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
                ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
                ->join('bailam', function ($join) {
                    $join->on('bailam.id_de', '=', 'dethi.id')
                        ->where('bailam.user_id', '=', CRUDBooster::myId());
                })
                ->select('dethi.name', 'monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id as id_de')
                ->where('bailam.id', '=', $id)
                ->get()->toArray();
            Log::debug('$ctde = ', $ctde);
//      $socau = DB::table('dethi')->where('id','=',$id)->get()->pluck('socau');
            $socau = $ctde[0]->socau;

            $idmh = DB::table('dethi')
                ->join('bailam', function ($join) {
                    $join->on('bailam.id_de', '=', 'dethi.id')
                        ->where('bailam.user_id', '=', CRUDBooster::myId());
                })
                ->where('bailam.id', '=', $id)->get()->pluck('id_mh');
            $dapanchon = DB::table('ctbailam')
                ->where('ctbailam.id_bailam', '=', $id)
                ->select('ctbailam.id_cauhoi', 'ctbailam.da_chon')->get()->pluck('da_chon', 'id_cauhoi');
            // dd($dapanchon);


            // $dapandung = DB::table('dethi')
            // ->join('ctdethi','ctdethi.id_de','=','dethi.id_de')
            // ->join('cauhoi','ctdethi.id_cauhoi','=','cauhoi.id_cauhoi')
            // ->join('dapandung','cauhoi.id_cauhoi','=','dapandung.id_cauhoi')->where('dethi.id_de','=',$id)
            // ->select('dapandung.id_cauhoi','dapandung.noidung')
            // ->pluck('noidung','id_cauhoi');

            $dapandung = DB::table('dapandung')
                ->join('cauhoi', 'cauhoi.id', '=', 'dapandung.id_cauhoi')
                ->join('ctdethi', 'ctdethi.id_cauhoi', '=', 'cauhoi.id')
                ->where('ctdethi.id_de', '=', $ctde[0]->id_de)
                ->pluck('dapandung.noidung', 'dapandung.id_cauhoi');
            // dd($dapandung);

            $count = 0;
            foreach ($dapandung as $question => $answer) {
                if (!isset($dapanchon[$question]) || $dapanchon[$question] != $answer) {
                    // echo sprintf("Sai ở câu: %s. Đáp án  là: %s\n", $question, $answer);

                    $count++;
                }
            }


            $dung = $socau - $count;
            $tinhdiem = (10 / $socau) * $dung;
            $lamtrondiem = round($tinhdiem, 2);
            // round($diem,2);
            $tyle = ($lamtrondiem * 100) / 10;
            $lamtrontyle = round($tyle, 2);
            // dd($lamtrontyle);
            if ($lamtrondiem < 5)
                $xeploai = 'Yếu';
            if ($lamtrondiem >= 5 && $lamtrondiem <= 6)
                $xeploai = 'Trung Bình';
            if ($lamtrondiem == 7)
                $xeploai = 'Khá';
            if ($lamtrondiem >= 8)
                $xeploai = 'Giỏi';
            $id_ketqua = DB::table('ketqua')->insertGetId([
                'id_bailam' => $id,
                'id_de' => $ctde[0]->id_de,
                'id_hs' => CRUDBooster::myId(),
                'socaudung' => $dung,
                'diem' => $lamtrondiem,
                'xeploai' => $xeploai,
                'id_mh' => $idmh[0],
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => CRUDBooster::myId()
            ]);
            $user = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
            $email = $user->email;
            // dd($diem);

            return view('frontend.test_result', ['id_bailam' => $id, 'lamtrondiem' => $lamtrondiem, 'count' => $count, 'lamtrontyle' => $lamtrontyle, 'ctde' => $ctde, 'dung' => $dung, 'email' => $email]);
        }
    }

    public function getXemDapAn($id)
    {
        $dethi = DB::table('dethi')
            ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
            ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
            ->join('bailam', function ($join) {
                $join->on('bailam.id_de', '=', 'dethi.id')
                    ->where('bailam.user_id', '=', CRUDBooster::myId());
            })
            ->select('dethi.name', 'monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id as id_de', 'dethi.trangthai')
            ->where('bailam.id', '=', $id)
            ->first();

        $ctdethi2 = DB::table('ctdethi')
            ->join('cauhoi', 'cauhoi.id', '=', 'ctdethi.id_cauhoi')
            ->join('dethi', 'dethi.id', '=', 'ctdethi.id_de')
            ->join('bailam', function ($join) {
                $join->on('bailam.id_de', '=', 'dethi.id')
                    ->where('bailam.user_id', '=', CRUDBooster::myId());
            })
            ->where('bailam.id', '=', $id)
            ->select('ctdethi.id_de', 'ctdethi.id_cauhoi', 'cauhoi.noidung', 'cauhoi.id_loaich', 'cauhoi.a', 'cauhoi.b', 'cauhoi.c', 'cauhoi.d')
            // ->paginate(1);
            ->get()->toArray();

        $id_user = CRUDBooster::myId();
        $dapanchon = DB::table('ctbailam')
            ->join('bailam', function ($join) {
                $join->on('bailam.id', '=', 'ctbailam.id_bailam')
                    ->where('bailam.user_id', '=', CRUDBooster::myId());
            })
            ->where('bailam.id', '=', $id)
            ->select('ctbailam.id_cauhoi', 'ctbailam.da_chon')->get()->pluck('da_chon', 'id_cauhoi');
        // dd($dapanchon);


        $dapandung = DB::table('dethi')
            ->join('ctdethi', 'ctdethi.id_de', '=', 'dethi.id')
            ->join('cauhoi', 'ctdethi.id_cauhoi', '=', 'cauhoi.id')
            ->join('dapandung', 'cauhoi.id', '=', 'dapandung.id_cauhoi')
            ->join('bailam', function ($join) {
                $join->on('bailam.id_de', '=', 'dethi.id')
                    ->where('bailam.user_id', '=', CRUDBooster::myId());
            })
            ->where('bailam.id', '=', $id)
            ->select('dapandung.id_cauhoi', 'dapandung.noidung')
            ->get()->pluck('noidung', 'id_cauhoi');
        // dd($dapandung);


        // foreach ($dapandung as $question => $answer) {
        //     if (!isset($dapanchon[$question]) || $dapanchon[$question] != $answer) {
        //         echo sprintf("Sai ở câu: %s. Đáp án  là: %s\n", $question, $answer);

        //     }
        // }

        return view('frontend.answer', ['id_bailam' => $id, 'dethi' => $dethi, 'ctdethi2' => $ctdethi2, 'dapanchon' => $dapanchon, 'dapandung' => $dapandung]);
    }

    public function getTestHistory()
    {
        $ketqua = DB::table('ketqua as KQ')
            ->leftJoin('bailam as BL', 'BL.id', '=', 'KQ.id_bailam')
            ->leftJoin('dethi as DT', 'DT.id', '=', 'KQ.id_de')
            ->leftJoin('monthi as MT', 'MT.id', '=', 'DT.id_mh')
            ->where('KQ.id_hs', '=', CRUDBooster::myId())
            ->select(
                'KQ.id_de',
                'DT.name as dethi',
                'DT.thoigianthi',
                'DT.socau',
                'MT.tenmh',
                'BL.fee',
                'BL.created_at as start_time',
                'KQ.socaudung',
                'KQ.diem',
                'KQ.xeploai',
                'KQ.created_at as end_time',
                'BL.id as id_bailam'
            )
            ->orderBy('BL.created_at','desc')
            ->orderBy('KQ.created_at','desc')
            ->paginate(1);

        return view('frontend.test_history', ['ketqua' => $ketqua]);
    }

    public function hocsinhctdethi($id)
    {
        $dethi = DB::table('dethi')
            ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
//        ->join('khoi', 'khoi.id_khoi', '=', 'dethi.id_khoi')
            ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
            ->select('monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id', 'dethi.id as id_de')
            ->where('dethi.id', '=', $id)
            ->get()->toArray();

        $delienquan = DB::table('dethi')
            ->join('monthi', 'monthi.id', '=', 'dethi.id_mh')
//        ->join('khoi', 'khoi.id_khoi', '=', 'dethi.id_khoi')
            ->join('kythi', 'kythi.id', '=', 'dethi.id_ky')
            ->select('dethi.name', 'monthi.tenmh', 'monthi.hinhanh', 'kythi.tenky', 'socau', 'thoigianthi', 'dethi.id', 'dethi.id as id_de')
            ->where('kythi.tenky', 'like', '%' . 'THPT Quốc Gia' . '%')->paginate(4);

        $binhluan = DB::table('thaoluandethi')
            ->join('cms_users', 'cms_users.id', '=', 'thaoluandethi.created_by')
            ->join('dethi', 'dethi.id', '=', 'thaoluandethi.id_de')
            ->select('thaoluandethi.noidung', 'cms_users.id', 'cms_users.name', 'cms_users.photo', 'thaoluandethi.created_at')
            ->where('thaoluandethi.id_de', '=', $id)->paginate(10);

        $id_de = $id;
        return view('frontend.exam_question_detail', ['dethi' => $dethi, 'delienquan' => $delienquan, 'binhluan' => $binhluan, 'id_de' => $id_de]);
    }
}

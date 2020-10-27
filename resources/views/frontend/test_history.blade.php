@extends('frontend.layout.index')
@section('styles')
    <link href="{{asset('css/lichsubaithi.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('body')
    <div class="container-fluid">
        <div class="container main_lichsu" style="margin-top: 20px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="fas fa-chalkboard-teacher"></i> <b>LỊCH SỬ BÀI THI</b></h6></div>
                <div class="datatable">
                    <table class="table tbl">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời gian</th>
                            <th>Môn học</th>
                            <th>Đề thi</th>
                            <th>Phí sử dụng</th>
                            <th>Nộp bài</th>
                            <th>Số câu đúng</th>
                            <th>Điểm</th>
                            <th>Xếp loại</th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stt = 1;
                        foreach($ketqua as $kq ):$stt ?>
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$kq->start_time}}</td>
                            <td>{{$kq->tenmh}}</td>
                            <td>{{$kq->dethi}}</td>
                            <td>{{$kq->fee?$kq->fee:0}} đ</td>
                            <td>{{$kq->end_time}}</td>
                            <td>{{$kq->socaudung}}/{{$kq->socau}}</td>
                            <td>{{$kq->diem}}</td>
                            <td>{{$kq->xeploai}}</td>
                            <td><a href="/xemdapan/{{$kq->id_bailam}}">
                                    <div class="btn btn-warning"> Xem đáp án</div>
                                </a></td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {{$ketqua->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.layout.index')
@section('styles')
    <link href="{{asset('css/lichsubaithi.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('body')
    <div class="container-fluid">
        <div class="container main_lichsu" style="margin-top: 20px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="fas fa-chalkboard-teacher"></i> <b>LỊCH SỬ GIAO DỊCH</b></h6>
                </div>
                <div class="datatable">
                    <table class="table tbl">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời gian</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stt = 1;
                        foreach($trans as $tran ):$stt ?>
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$kq->date_time}}</td>
                            <td>{{$kq->description}}</td>
                            <td>{{$kq->status}}</td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    {{$trans->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

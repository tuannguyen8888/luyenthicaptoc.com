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
                            <th>Mã giao dịch</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stt = 1;
                        foreach($trans as $tran ):$stt ?>
                        <tr>
                            <td>{{$stt++}}</td>
                            <td>{{$tran->date_time}}</td>
                            <td>{{$tran->trans_type == 'CASHIN'? 'Nạp tiền' : ($tran->trans_type == 'nBUY_EXAM_QUESTION' ? 'Mua đề thi' : '')}}</td>
                            <td>{{$tran->trans_code}}</td>
                            <td>{{$tran->status == 'WAITING_CONFIRM' ? 'Chờ xác nhận' : ($tran->status == 'CONFIRMED' ? 'Đã xác nhận': ($tran->status == 'COMPLETED' ? 'Thành công' : ($tran->status == 'USER_CANCELED' ? 'Hủy giao dịch' : ($tran->status == 'TIMEOUT_CANCELED' ? 'Thất bại' : ''))))}}</td>
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

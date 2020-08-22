<?php
//=====Tổng số hồ sơ đăng ký
$sql_registered = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
        FROM ifn_working_capital_document
        WHERE (from_source = 'REGISTER' OR (from_source = 'PREAPPROVE' AND status NOT IN ('INIT', 'REQUEST_RENEW', 'AUTO_RENEW', 'AWAITING_CONFIRM')) OR from_source = 'RENEW')
            AND deleted_at IS NULL";
$r_registered = DB::select($sql_registered);

//=====Tổng hồ sơ đang hoạt động
$sql_using = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
            FROM ifn_working_capital_document
            WHERE status IN ('USING') OR second_status IN ('USING')
            AND deleted_at IS NULL";
$r_using = DB::select($sql_using);

//=====Tổng số hồ sơ từ chối/hủy
$sql_reject_canceled = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
                FROM ifn_working_capital_document
                WHERE status IN ('REJECT_DOCUMENT', 'CANCELED') OR second_status IN ('REJECT_DOCUMENT', 'CANCELED')
                AND deleted_at IS NULL";
$r_reject_canceled = DB::select($sql_reject_canceled);

//=====Hồ sơ đã phê duyệt
$sql_approved = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
                    FROM ifn_working_capital_document
                    WHERE status IN ('AWAITING_ACTIVATION', 'ACTIVATED', 'USING', 'EXPIRED', 'COMPLETED')
                        OR (status = 'CANCELED' AND id IN (SELECT ifn_working_capital_document_id FROM ifn_working_capital_document_process WHERE status = 'AWAITING_ACTIVATION') )
                        AND deleted_at IS NULL";
$r_approved = DB::select($sql_approved);

//=====Chờ thẩm định (điện thoại, thực địa)
$sql_waiting_expertise = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
                        FROM ifn_working_capital_document
                        WHERE status IN ('AWAITING_EXPERTISE_CALL', 'AWAITING_EXPERTISE_FIELD')
                            AND deleted_at IS NULL";
$r_waiting_expertise = DB::select($sql_waiting_expertise);

//======Chờ bổ sung hồ sơ
$sql_return_document = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
                    FROM ifn_working_capital_document
                    WHERE status IN ('RETURN_DOCUMENT')
                        AND deleted_at IS NULL";
$r_return_document = DB::select($sql_return_document);

//======Chờ phê duyệt
$sql_awaiting_approval = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
        FROM ifn_working_capital_document
        WHERE status IN ('AWAITING_APPROVAL_0', 'AWAITING_APPROVAL_1', 'AWAITING_APPROVAL_2')
            AND deleted_at IS NULL";
$r_awaiting_approval = DB::select($sql_awaiting_approval);

//======Chờ phê duyệt, xác nhận
$sql_awaiting_approval_confirm = "SELECT CONCAT(CONVERT(COUNT(*),char), ' hồ sơ') AS TongSo
        FROM ifn_working_capital_document
        WHERE status IN ('AWAITING_APPROVAL_0', 'AWAITING_APPROVAL_1', 'AWAITING_APPROVAL_2', 'AWAITING_CONFIRM')
            AND deleted_at IS NULL";
$r_awaiting_approval_confirm = DB::select($sql_awaiting_approval_confirm);

//======Giải ngân từ đầu đến hiện tại
$sql_disbursed = "SELECT CONCAT(CONVERT(FORMAT(SUM(advance_amount), 0),char), ' đ') AS TongSo
        FROM ifn_transaction
        WHERE status NOT IN ('CANCEL', 'PENDING')
            AND deleted_at IS NULL";
$r_disbursed = DB::select($sql_disbursed);

//======Tổng phí (quá hạn, trong hạn) đã thu
$sql_total_fee = "SELECT CONCAT(CONVERT(FORMAT(SUM(pay_amount), 0),char), ' đ') AS TongSo
        FROM ifn_transaction_payment
        WHERE pay_type IN ('INDUE_FEE', 'OVERDUE_FEE')";
$r_total_fee = DB::select($sql_total_fee);

//======Trong hạn, sắp đến hạn trong 48h
$sql_indue_ondue_48h = "SELECT CONCAT(CONVERT(IFNULL(FORMAT(SUM(advance_amount), 0), 0),char), ' đ') AS TongSo
        FROM ifn_transaction
        WHERE status IN ('INDUE', 'ONDUE')
            AND DATE_FORMAT(due_date, '%Y-%m-%d') >= DATE_FORMAT(NOW(), '%Y-%m-%d')
            AND DATE_FORMAT(due_date, '%Y-%m-%d') <= DATE_FORMAT(DATE_ADD(NOW() , INTERVAL 2 DAY), '%Y-%m-%d')
            AND deleted_at IS NULL";
$r_indue_ondue_48h = DB::select($sql_indue_ondue_48h);

//======Tổng quá hạn
$sql_overdue = "SELECT CONCAT(CONVERT(IFNULL(FORMAT(SUM(advance_amount), 0), 0),char), ' đ') AS TongSo
        FROM ifn_transaction
        WHERE (status IN ('OVERDUE')
        -- OR DATE_FORMAT(due_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')
        )
            AND deleted_at IS NULL";
$r_overdue = DB::select($sql_overdue);

?>

<div class="statistic-row row">
    <div id="area1" class="col-sm-3 connectedSortable">

        <div class="border-box">
            <div class="small-box bg-orange">
                <div class="inner inner-box">
                    <h3>{{$r_registered[0]->TongSo or 0}}</h3>
                    <p>Tổng số hồ sơ đăng ký </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-time"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-blue">
                <div class="inner inner-box">
                    <h3>{{$r_waiting_expertise[0]->TongSo or 0}}</h3>
                    <p>Chờ thẩm định (điện thoại, thực địa) </p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-location	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-green">
                <div class="inner inner-box">
                    <h3>{{$r_disbursed[0]->TongSo or 0}}</h3>
                    <p>Giải ngân từ đầu đến hiện tại </p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark"></i>
                </div>
                <a href="/admin/transaction_list" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div id="area2" class="col-sm-3 connectedSortable">

        <div class="border-box">
            <div class="small-box bg-orange">
                <div class="inner inner-box">
                    <h3>{{$r_approved[0]->TongSo or 0}}</h3>
                    <p>Hồ sơ đã phê duyệt </p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-unlocked-outline	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-blue">
                <div class="inner inner-box">
                    <h3>{{$r_return_document[0]->TongSo or 0}}</h3>
                    <p>Chờ bổ sung hồ sơ </p>
                </div>
                <div class="icon">
                    <i class="ion ion-help	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-green">
                <div class="inner inner-box">
                    <h3>{{$r_total_fee[0]->TongSo or 0}}</h3>
                    <p>Tổng phí (quá hạn, trong hạn) đã thu </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-time	"></i>
                </div>
                <a href="/admin/transaction_list" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div id="area3" class="col-sm-3 connectedSortable">

        <div class="border-box">
            <div class="small-box bg-orange">
                <div class="inner inner-box">
                    <h3>{{$r_using[0]->TongSo or 0}}</h3>
                    <p>Tổng hồ sơ đang hoạt động </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-blue">
                <div class="inner inner-box">
                    <h3>{{$r_awaiting_approval_confirm[0]->TongSo or 0}}</h3>
                    <p>Chờ phê duyệt </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkbox-outline	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-green">
                <div class="inner inner-box">
                    <h3>{{$r_indue_ondue_48h[0]->TongSo or 0}}</h3>
                    <p>Trong hạn, sắp đến hạn trong 48h </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-bicycle"></i>
                </div>
                <a href="/admin/transaction_list" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>

    <div id="area4" class="col-sm-3 connectedSortable">

        <div class="border-box">
            <div class="small-box bg-orange">
                <div class="inner inner-box">
                    <h3>{{$r_reject_canceled[0]->TongSo or 0}}</h3>
                    <p>Tổng số hồ sơ từ chối/hủy </p>
                </div>
                <div class="icon">
                    <i class="ion ion-backspace-outline	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-blue">
                <div class="inner inner-box">
                    <h3>{{$r_awaiting_approval_confirm[0]->TongSo or 0}}</h3>
                    <p>Chờ phê duyệt, xác nhận </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-call	"></i>
                </div>
                <a href="/admin/working_capital_document" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="border-box">
            <div class="small-box bg-green">
                <div class="inner inner-box">
                    <h3>{{$r_overdue[0]->TongSo or 0}}</h3>
                    <p>Tổng quá hạn </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-attach"></i>
                </div>
                <a href="/admin/transaction_list" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
</div>
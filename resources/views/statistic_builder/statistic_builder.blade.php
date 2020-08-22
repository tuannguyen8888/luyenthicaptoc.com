<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
    .highcharts-figure, .highcharts-data-table table {
        min-width: 320px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }


    input[type="number"] {
        min-width: 50px;
    }

    .highcharts-credits {
        display: none;
    }
</style>

<?php

$sql1 = "SELECT cid.value AS province_id, p.name AS TinhThanh, COUNT(*) AS SoLuong
        FROM ifn_working_capital_document wcd
        JOIN ifn_customer_info_detail cid ON wcd.ifn_customer_info_id = cid.ifn_customer_info_id AND cid.field_key = 'store_province_id'
        JOIN ifn_province p ON p.id = cid.value
        WHERE wcd.status = 'USING'
        GROUP BY cid.value";
$records1 = DB::select($sql1);
$series_data_1 = '';
foreach ($records1 as $record1) {
    $series_data_1 .= '{
                        name: "' . $record1->TinhThanh . " (" . $record1->SoLuong . ")" . '",
                        y: ' . $record1->SoLuong . '
                    },';
}
$series_data_1 = rtrim($series_data_1, ',');
//==============================================
$sql2 = "SELECT cid.value AS business_category_id, b.name AS NganhNghe, COUNT(*) AS SoLuong
        FROM ifn_working_capital_document wcd
        JOIN ifn_customer_info_detail cid ON wcd.ifn_customer_info_id = cid.ifn_customer_info_id AND cid.field_key = 'business_category_id'
        JOIN ifn_business_category b ON b.id = cid.value
        WHERE wcd.status = 'USING'
        GROUP BY cid.value";
$records2 = DB::select($sql2);
$series_data_2 = '';
foreach ($records2 as $record2) {
    $series_data_2 .= '{
                        name: "' . $record2->NganhNghe . " (" . $record2->SoLuong . ")" . '",
                        y: ' . $record2->SoLuong . '
                    },';
}
$series_data_2 = rtrim($series_data_2, ',');
//===============================================
$sql3 = "SELECT cid.value AS province_id, p.name AS TinhThanh, COUNT(*) AS SoLuongDaDangKy,
        (SELECT COUNT(*) AS SoLuongDangSuDung
            FROM ifn_working_capital_document w
            JOIN ifn_customer_info_detail d ON w.ifn_customer_info_id = d.ifn_customer_info_id AND d.field_key = 'store_province_id'
            JOIN ifn_province p ON p.id = d.value
            WHERE w.status = 'USING'
            AND d.value = cid.value) AS SoLuongDangSuDung
    FROM ifn_working_capital_document wcd
    JOIN ifn_customer_info_detail cid ON wcd.ifn_customer_info_id = cid.ifn_customer_info_id AND cid.field_key = 'store_province_id'
    JOIN ifn_province p ON p.id = cid.value
    WHERE wcd.from_source = 'REGISTER'OR (wcd.from_source = 'PREAPPROVE' AND wcd.status NOT IN ('INIT', 'REQUEST_RENEW', 'AUTO_RENEW', 'AWAITING_CONFIRM'))
        AND wcd.deleted_at IS NULL
    GROUP BY cid.value
    ORDER BY p.regional_coefficient ASC, p.name ASC";
$records3 = DB::select($sql3);
$categories = $data_registered = $data_using = $data_proportion = '';
$sum_registered = $sum_using = 0;
foreach ($records3 as $record3) {
    $categories .= '"' . $record3->TinhThanh . '"' . ',';
    $data_registered .= $record3->SoLuongDaDangKy . ',';
    $data_using .= $record3->SoLuongDangSuDung . ',';
    $data_proportion .= number_format(($record3->SoLuongDangSuDung / $record3->SoLuongDaDangKy) * 100, 2) . ',';
    $sum_registered += $record3->SoLuongDaDangKy;
    $sum_using += $record3->SoLuongDangSuDung;
}
$categories = rtrim($categories, ',');
$data_registered = rtrim($data_registered, ',');
$data_using = rtrim($data_using, ',');
$data_proportion = rtrim($data_proportion, ',');

//echo $data_registered;die();
?>

@include('statistic_builder.top_report')

<div class='statistic-row row'>
    <div id='area6' class="col-sm-6 connectedSortable">
        <div class="border-box">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Tỷ trọng theo khu vực (hồ sơ đang hoạt động)
                </div>

                <div class="panel-body" style="padding: 0px">


                    <figure class="highcharts-figure">
                        <div id="container-1"></div>
                    </figure>

                    <script type="text/javascript">

                        Highcharts.chart('container-1', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'Tỷ trọng theo khu vực (hồ sơ đang hoạt động)'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            accessibility: {
                                point: {
                                    valueSuffix: '%'
                                }
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    }
                                }
                            },
                            series: [
                                {
                                    name: 'Brands',
                                    colorByPoint: true,
                                    data: [
                                        <?php echo $series_data_1; ?>
                                    ]
                                }
                            ]
                        });

                    </script>

                </div>
            </div>


        </div>
    </div>

    <div id='area7' class="col-sm-6 connectedSortable">
        <div class="border-box">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Tỷ trọng theo ngành nghề (hồ sơ đang hoạt động)
                </div>

                <div class="panel-body" style="padding: 0px">


                    <figure class="highcharts-figure">
                        <div id="container-2"></div>
                    </figure>

                    <script type="text/javascript">

                        Highcharts.chart('container-2', {
                            chart: {
                                plotBackgroundColor: null,
                                plotBorderWidth: null,
                                plotShadow: false,
                                type: 'pie'
                            },
                            title: {
                                text: 'Tỷ trọng theo ngành nghề (hồ sơ đang hoạt động)'
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                            },
                            accessibility: {
                                point: {
                                    valueSuffix: '%'
                                }
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    }
                                }
                            },
                            series: [
                                {
                                    name: 'Brands',
                                    colorByPoint: true,
                                    data: [
                                        <?php echo $series_data_2; ?>
                                    ]
                                }
                            ]
                        });
                    </script>

                </div>
            </div>


        </div>
    </div>

</div>


<div class='statistic-row row'>
    <div id='area8' class="col-sm-12 connectedSortable">
        <div class="border-box">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Tỉ trọng Số lượng đang sử dụng / Số lượng đăng ký của mỗi khu vực
                </div>

                <div class="panel-body" style="padding: 0px">


{{--                    <figure class="highcharts-figure">--}}
{{--                        <div id="container-3"></div>--}}
{{--                    </figure>--}}

                    <figure class="highcharts-figure">
                        <div id="container-4"></div>
                    </figure>

                    <script type="text/javascript">

                        /*
                        Highcharts.chart('container-3', {
                            title: {
                                text: 'Tỉ trọng Số lượng đang sử dụng / Số lượng đăng ký của mỗi khu vực'
                            },
                            xAxis: {
                                categories: [<?php echo $categories; ?>]
                            },
                            labels: {
                                items: [{
                                    html: 'Tổng số',
                                    style: {
                                        left: '50px',
                                        top: '18px',
                                        color: ( // theme
                                            Highcharts.defaultOptions.title.style &&
                                            Highcharts.defaultOptions.title.style.color
                                        ) || 'black'
                                    }
                                }]
                            },
                            series: [
                                {
                                    type: 'column',
                                    name: 'Đã đăng ký',
                                    data: [<?php echo $data_registered; ?>]
                                },
                                {
                                    type: 'column',
                                    name: 'Đang sử dụng',
                                    data: [<?php echo $data_using; ?>]
                                },
                                {
                                    type: 'spline',
                                    name: 'Tỷ trọng',
                                    data: [<?php echo $data_proportion; ?>],
                                    marker: {
                                        lineWidth: 2,
                                        lineColor: Highcharts.getOptions().colors[3],
                                        fillColor: 'white'
                                    }
                                }, {
                                    type: 'pie',
                                    name: 'Tổng hồ sơ',
                                    data: [
                                        {
                                            name: 'Đã đăng ký',
                                            y: <?php echo $sum_registered; ?>,
                                            color: Highcharts.getOptions().colors[0] // Jane's color
                                        }, {
                                            name: 'Đang sử dụng',
                                            y: <?php echo $sum_using; ?>,
                                            color: Highcharts.getOptions().colors[1] // John's color
                                        }
                                    ],
                                    center: [100, 80],
                                    size: 100,
                                    showInLegend: false,
                                    dataLabels: {
                                        enabled: false
                                    }
                                }]
                        });
                        */
                        // ===============================================

                        Highcharts.chart('container-4', {
                            chart: {
                                zoomType: 'xy'
                            },
                            title: {
                                text: 'Tỉ trọng Số lượng đang sử dụng / Số lượng đăng ký của mỗi khu vực'
                            },
                            subtitle: {
                                text: ''
                            },
                            xAxis: [
                                {
                                    categories: [<?php echo $categories; ?>],
                                    crosshair: true
                                }
                            ],
                            yAxis: [
                                { // Secondary yAxis
                                    title: {
                                        text: 'Tỷ trọng',
                                        style: {
                                            color: Highcharts.getOptions().colors[0]
                                        }
                                    },
                                    labels: {
                                        format: '{value} %',
                                        style: {
                                            color: Highcharts.getOptions().colors[0]
                                        }
                                    },
                                    opposite: true
                                },
                                { // Primary yAxis
                                    labels: {
                                        format: '{value} HS',
                                        style: {
                                            color: Highcharts.getOptions().colors[1]
                                        }
                                    },
                                    title: {
                                        text: 'Số lượng',
                                        style: {
                                            color: Highcharts.getOptions().colors[1]
                                        }
                                    }
                                },

                            ],
                            tooltip: {
                                shared: true
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'left',
                                x: 120,
                                verticalAlign: 'top',
                                y: 100,
                                floating: true,
                                backgroundColor:
                                    Highcharts.defaultOptions.legend.backgroundColor || // theme
                                    'rgba(255,255,255,0.25)'
                            },
                            series: [
                                {
                                    name: 'Đã đăng ký',
                                    type: 'column',
                                    yAxis: 1,
                                    data: [<?php echo $data_registered; ?>],
                                    tooltip: {
                                        valueSuffix: ' HS'
                                    }

                                },
                                {
                                    name: 'Đang sử dụnǵ',
                                    type: 'column',
                                    yAxis: 1,
                                    data: [<?php echo $data_using; ?>],
                                    tooltip: {
                                        valueSuffix: ' HS'
                                    }

                                },
                                {
                                    name: 'Tỷ trọng',
                                    type: 'spline',
                                    data: [<?php echo $data_proportion; ?>],
                                    tooltip: {
                                        valueSuffix: ' %'
                                    }
                                }
                            ]
                        });
                    </script>

                </div>
            </div>


        </div>
    </div>


</div>


@extends('frontend.layout.index')
@section('styles')
    <style>
        /*basic reset*/
        /** {*/
        /*margin: 0;*/
        /*padding: 0;*/
        /*}*/

        /*html {*/
        /*height: 100%;*/
        /*background: #6441A5; !* fallback for old browsers *!*/
        /*background: -webkit-linear-gradient(to left, #6441A5, #2a0845); !* Chrome 10-25, Safari 5.1-6 *!*/
        /*}*/

        /*body {*/
        /*font-family: montserrat, arial, verdana;*/
        /*background: transparent;*/
        /*}*/

        .content-wrapper {
            background-image: url(/imgs/banner/bg-feedback-student.jpg);
        }

        /*form styles*/
        #msform {
            text-align: center;
            position: relative;
            margin-top: 30px;
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0px;
            box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
            padding: 20px 30px;
            box-sizing: border-box;
            width: 80%;
            margin: 0 10%;

            /*stacking fieldsets above each other*/
            position: relative;
        }

        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        /*inputs*/
        #msform input, #msform textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 10px;
            /*width: 100%;*/
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            font-size: 13px;
        }

        #msform input:focus, #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #ee0979;
            outline-width: 0;
            transition: All 0.5s ease-in;
            -webkit-transition: All 0.5s ease-in;
            -moz-transition: All 0.5s ease-in;
            -o-transition: All 0.5s ease-in;
        }

        /*buttons*/
        #msform .action-button {
            width: 100px;
            background: #ee0979;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }

        #msform .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #ee0979;
        }

        #msform .action-button-previous {
            width: 100px;
            background: #C5C5F1;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }

        #msform .action-button-previous:hover, #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
        }

        /*headings*/
        .fs-title {
            font-size: 18px;
            text-transform: uppercase;
            color: #2C3E50;
            margin-bottom: 10px;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .fs-subtitle {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }

        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }

        #progressbar li {
            list-style-type: none;
            color: #2c8c2e;
            text-transform: uppercase;
            font-size: 9px;
            width: 33.33%;
            float: left;
            position: relative;
            letter-spacing: 1px;
            z-index: 1;
        }

        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 24px;
            height: 24px;
            line-height: 26px;
            display: block;
            font-size: 12px;
            color: #7b7b7b;
            background: #cae7d3;
            border-radius: 25px;
            margin: 0 auto 10px auto;
        }

        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #cae7d3;
            position: absolute;
            left: -45%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }

        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }

        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active:before, #progressbar li.active:after {
            background: #ee0979;
            color: white;
        }

        /* Not relevant to this form */
        .dme_link {
            margin-top: 30px;
            text-align: center;
        }

        .dme_link a {
            background: #FFF;
            font-weight: bold;
            color: #ee0979;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 5px 25px;
            font-size: 12px;
        }

        .dme_link a:hover, .dme_link a:focus {
            background: #C5C5F1;
            text-decoration: none;
        }

        #step1 label {
            white-space: pre-line;
            padding: 35px;
        }

        #step1 label.active {
            border: 3px solid darkseagreen;
            border-radius: 10px;
        }

        #step1 label img {
            width: 100px;
            height: 100px;
        }

        label .label-inline {
            display: inline;
            white-space: nowrap;
        }

        #step2 label {
            margin: 5px;
            font-size: 20px;
            line-height: 2;
            color: rgba(10, 35, 154, 0.69);
        }

        #step2 label.payment_channel_detail {
            width: 51%;
            border: 1px solid #9dadbd;
            border-radius: 25px;
        }

        #step2 label.active {
            background-color: rgba(174, 222, 180, 0.69);
            color: #0baf36;
        }

        .action_payment_channel {
            font-size: 20px;
        }
    </style>
@endsection
@section('body')
    <div class="container-fluid">

        <div class="container" style="padding-top: 10px;">
            <div class="row">
                <div class="col-md-12 tieudetintuc">
                    <h3 style="text-transform: uppercase;"> Nạp tiền vào tài khoản</h3>
                </div>
            </div>
            <!-- MultiStep Form -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">Phương thức thanh toán</li>
                            <li>Mệnh giá nạp</li>
                            <li>Giao dịch</li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset id="step1">
                            <h2 class="fs-title">Chọn phương thức thanh toán</h2>
                            @if(count($payment_channels))
                                @foreach($payment_channels as $pc)
                                    <label id="label_for_{{$pc->id}}" class="payment_channel_label"
                                           for="payment_channel_id_{{$pc->id}}">
                                        <img src="{{asset($pc->logo)}}">
                                        <span class="label-inline"><input class="hide"
                                                                          id="payment_channel_id_{{$pc->id}}"
                                                                          value="{{$pc->id}}" type="radio"
                                                                          name="payment_channel"/>
                                            {{$pc->name}}</span>
                                    </label>
                                @endforeach
                            @endif
                            <br>
                            <input type="button" name="next" class="next action-button" value="Tiếp"/>
                        </fieldset>
                        <fieldset id="step2">
                            <h2 class="fs-title">Chọn mệnh giá nạp</h2>
                            @if(count($payment_channels))
                                @foreach($payment_channels as $pc)
                                    @if(count($pc->details))
                                        @foreach($pc->details as $detail)
                                            <label id="label_for_detail_{{$detail->id}}"
                                                   class="payment_channel_detail payment_channel_{{$pc->id}}"
                                                   for="payment_channel_detail_{{$detail->id}}">
                                                <span class="label-inline"><input class="hide"
                                                                                  id="payment_channel_detail_{{$detail->id}}"
                                                                                  value="{{$detail->id}}"
                                                                                  data-denomination-value="{{$detail->denomination_value}}"
                                                                                  type="radio"
                                                                                  name="payment_channel_detail"/>
                                                    {{$detail->name}}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            <br>
                            <input type="button" name="previous" class="previous action-button-previous"
                                   value="Quay lại"/>
                            <input id="nextSt2" type="button" name="next" class="next action-button" value="Tiếp"
                                   onclick="newTransaction()" style="display: none;"/>
                        </fieldset>
                        <fieldset id="step3">
                            <h2 class="fs-title">Thực hiện giao dịch</h2>
                            @if(count($payment_channels))
                                @foreach($payment_channels as $pc)
{{--                                    @if($pc->method == 'QRCODE')--}}
                                        <div id="action_qrcode_payment_channel_{{$pc->id}}" class="row action_payment_channel"
                                             style="display: none;">
                                            <span>Mở app <b>{{$pc->name}}</b> trên điện thoại của bạn và quét QR code dưới đây.</span>
                                            <br>
                                            @foreach($pc->details as $detail)
                                                <img class="qrcode qr-{{$detail->id}}" style="width: 400px"
                                                     src="{{$detail->qr_code_image}}">
                                            @endforeach
                                            <br>
                                            Mã giao dịch: <b class="trans_code" style="color: red;"></b>
                                            <br>
                                            <span>Nhớ nhập mã giao dịch của bạn vào nội dung chuyển tiền.</span>
                                        </div>
                                    {{--@endif--}}
{{--                                    @if($pc->method == 'TRANSFER')--}}
                                        <div id="action_transfer_payment_channel_{{$pc->id}}" class="row action_payment_channel"
                                             style="display: none;">
                                            <span>Mở app <b>{{$pc->name}}</b> trên điện thoại của bạn và thực hiện chuyển tiền theo thông tin dưới đây.</span>
                                            <br>
                                            {!! $pc->info !!}
                                            <br>
                                            @foreach($pc->details as $detail)
                                                <span class="qrcode qr-{{$detail->id}}">Số tiền: {{$detail->name}}</span>
                                            @endforeach
                                            <br>
                                            Mã giao dịch: <b class="trans_code" style="color: red;"></b>
                                            <br>
                                            <span>Nhớ nhập mã giao dịch của bạn vào nội dung chuyển tiền.</span>
                                            <br><br>
                                            @foreach($pc->details as $detail)
                                                <a class="next action-button qrcode qr-{{$detail->id}}" target="_blank" href="{!!trim($detail->link)!!}">Mở app {{$pc->name}}</a>
                                            @endforeach
                                        </div>
                                    {{--@endif--}}
                                @endforeach
                            @endif
                            {{--<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>--}}
                            {{--<input type="submit" name="submit" class="submit action-button" value="Submit"/>--}}
                        </fieldset>
                    </form>
                    <br><br>
                </div>
                <!-- /.MultiStep Form -->
            </div>
        </div>
        @endsection

        @section('script')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
            <script src="/vendor/crudbooster/assets/sweetalert/dist/sweetalert.min.js"></script>
            <link rel="stylesheet" type="text/css" href="/vendor/crudbooster/assets/sweetalert/dist/sweetalert.css">
            <script>
                //jQuery time
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $('#step1 input[type=radio][name=payment_channel]').change(function (e) {
                    console.log('select ', $(e.target).val());
                    $('.payment_channel_label').removeClass('active');
                    $('.payment_channel_detail').hide();
                    if ($(e.target).val()) {
                        $('#label_for_' + $(e.target).val()).addClass('active');
                        $('.payment_channel_' + $(e.target).val()).show();
                    }
                });
                if (!$('#step1 input[type=radio][name=payment_channel]:checked').val()) {
                    $($('#step1 input[type=radio][name=payment_channel]')[0]).prop('checked', true).trigger('change');
                }

                $('#step2 input[type=radio][name=payment_channel_detail]').change(function (e) {
                    console.log('select ', $(e.target).val());
                    $('.payment_channel_detail').removeClass('active');
                    if ($(e.target).val()) {
                        $('#label_for_detail_' + $(e.target).val()).addClass('active');
                        $('#nextSt2').show();
                    } else {
                        $('#nextSt2').hide();
                    }
                });
                $(".next").click(function () {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function (now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale current_fs down to 80%
                            scale = 1 - (1 - now) * 0.2;
                            //2. bring next_fs from the right(50%)
                            left = (now * 50) + "%";
                            //3. increase opacity of next_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                                'position': 'absolute'
                            });
                            next_fs.css({'left': left, 'opacity': opacity});
                        },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".previous").click(function () {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({opacity: 0}, {
                        step: function (now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale previous_fs from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_fs to the right(50%) - from 0%
                            left = ((1 - now) * 50) + "%";
                            //3. increase opacity of previous_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({'left': left});
                            previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                        },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                // $(".submit").click(function(){
                //     return false;
                // });
                function newTransaction() {
                    let payment_channel_id = $("#step1 input[type=radio][name=payment_channel]:checked").val();
                    $('.action_payment_channel').hide();
                    if(!isMobile.any()) {
                        $('#action_qrcode_payment_channel_' + payment_channel_id).show();
                    }else{
                        $('#action_transfer_payment_channel_' + payment_channel_id).show();
                    }
                    let payment_channel_detail_id = $("#step2 input[type=radio][name=payment_channel_detail]:checked").val();
                    $('.qrcode').hide();
                    $('.qr-' + payment_channel_detail_id).show();
                    let amount = Number($('#payment_channel_detail_' + payment_channel_detail_id).attr('data-denomination-value'));
                    $.ajax({
                        method: "POST",
                        url: '{{url('new-transaction')}}',
                        data: {
                            amount: amount,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            if (data) {
                                console.log('trans_code = ', data.trans_code)
                                transCode = data.trans_code;
                                $('.trans_code').html(data.trans_code);
                                checkCashinInterval = setInterval(()=>{
                                    checkCashin();
                                },30000)
                            }
                        },
                        error: function (request, status, error) {
                            console.error(error);
                        }
                    });
                }
                var transCode;
                var checkCashinInterval;
                function checkCashin(){
                    $.ajax({
                        method: "get",
                        url: '{{url('check-cashin')}}',
                        data: {
                            trans_code: transCode,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        async: true,
                        success: function (data) {
                            if (data && data.transaction && (data.transaction.status == 'CONFIRMED' || data.transaction.status == 'COMPLETED')) {
                                swal({
                                    title: "Giao dịch thành công",
                                    text: "Bạn đã nạp tiền vào tài khoản thành công, số dư hiện tại là "+Number(data.balance).toLocaleString()+".",
                                    icon: "success",
                                }, function(isConfirm) {
                                    let return_url = getUrlParameter('return_url');
                                    window.location.href = return_url?return_url:'/transaction-history';
                                });
                            }
                        },
                        error: function (request, status, error) {
                            console.error(error);
                        }
                    });
                }

                var isMobile = {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function() {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function() {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function() {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function() {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };
                function getUrlParameter(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                };
            </script>
@endsection
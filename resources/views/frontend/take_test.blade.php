@extends('frontend.layout.index')
@section('styles')
<style>
	.giaodienthi{
		/*height: 460px;*/
		/*width: 1000px;*/
		/*position: absolute;*/
		/*top: 380px;*/
		/*left: 50%;*/
		/*transform: translateX(-50%) translateY(-50%);*/
		/*background: rgba(255,255,255,0.5);*/
		/*padding: 20px;*/
		/*border: 1px solid #08038C;*/
		/*box-shadow: 0 0 8px 3px #fff;*/
	}
	.title{
		padding-top: 20px;
		text-align: center;
		font-size: 29px;
		text-transform: uppercase;
		color: #08038C;
	}
	#question{
		padding: 20px;
		font-size: 22px;
		background-color: #08038C;
		border-radius: 20px;
		margin: 10px 0 10px 0;
		color: #f6f6f6;
		min-height: auto !important;
	}
	.option{
		width: 100%;
		/*display: inline-block;*/
		padding: 10px 10px 10px 10px;
		/*vertical-align: middle;*/
		background: rgba(186, 216, 212, 0.3);
		margin: 10px 10px 10px 10px;
		color: #000000;
		border-radius: 20px;
	}
	.option:hover{
		background: #2C8C2E;
		color: #f6f6f6;
	}
	.next-btn{
		border:none;
		outline: none;
		background: rgba(255,25,255,0.5);
		width: 100px;
		height: 35px;
		border-radius: 20px;
		cursor: pointer;
		color: #000;
	}
	.next-btn:hover{
		background: #2c8c2e;
		color: #f6f6f6;
	}
	.result{
		height: 100px;
		text-align: center;
		font-size: 75px;
	}
	.option{
		cursor: pointer;
	}
	.option input:checked .option{
		background: #08038C;
		color: #000;
	}
	.information{
		text-align: center;
		margin-top: 5px;
	}
	.counttime{
		width: 140px;
		height: 100px;
		/*margin-left: 10px;*/
		margin-top: -100px;
		position: fixed;
		right: 0%;
		z-index: 99999;
	}

	.gio{
		margin-top: -65px;
		margin-left: 40px;
		font-size: 20px;
		color: #ff1322;
		font-weight: bold;
	}
	.btnsubmitbaithi{
		height: 30px;
		margin-top: 10px;
		padding-top: 7px;
		padding-left: 7px;
	}
	.menu_socau{
		margin-top: 30px;
		margin-left: 20px;
		width: 754px;
		height: 100px;


	}
	.socau{
		text-align: center;
		float: left;
		margin-bottom: 10px;
		border: 1px solid #8D94F5;
		margin-left: 7px;
		width: 28px;
		height: 28px;
		line-height: 28px;
		border-radius: 50%;
		background: rgba(255,255,255,0.5);
		color: #000;
		font-weight: bold
	}
	.socau:hover{
		background: #08038C;
		color: #f6f6f6;
	}

	.menu_socau ul li{
		list-style: none;
		display: inline;
	}
	.content1 p{
		display: inline;
	}
	.img_anhcauhoi{
		text-align: center;
		margin-top: -30px;
	}

 </style>
@endsection
@section('body')
<div class="container-fluid bgsearch">
	<div class="row" >
		<form action="../../ketqua" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="_token()" value="{{csrf_token()}}">
			<div id="quizContainer" class="container giaodienthi">
				<div class="title">{{$dethi->name}}</div>
				<div class="information"><b>Kỳ thi: {{$dethi->tenky}} | <b>Môn: {{$dethi->tenmh}}</b> | <b>Số câu: {{$dethi->socau}} câu</b> | <b>Thời gian thi: {{$dethi->thoigianthi}} phút</b></b></div>
				<div class="counttime">
					<img src="../../imgs/khung.png"  class="khung_hoa" width="145" height="100" height="" alt="" >
						<p class="gio">
							<span id="m">00</span> :
							<span id="s">00</span>
						</p>
				</div>
				@php
					$stt=0;
					if(isset($_GET['page'])){
						$a =$_GET['page'];
					}
					else{
						$a=1;

					}

					$stt= ($a-1);
					@endphp

				@foreach($ctdethi as $ct)
					@php  $stt++; @endphp
					<div class="content1 col-md-12 col-sm-12 col-xs-12">
						<div id="question" class="content col-md-12 col-sm-12 col-xs-12">
							<input type="hidden" value="{{$ct->id_cauhoi}}" name="id_cauhoi">
							<input type="hidden" value="{{$ct->id_de}}" name="id_dethi">
							<input type="hidden" value="{{$ct->id_loaich}}" name="id_loai">
							{{-- <input type="hidden" value="{{$user}}" name="id_user"> --}}
							{{$stt}} . {!!$ct->noidung!!}
							{{--<div class="img_anhcauhoi"><img src="../../upload/cauhoi/{{$ct->hinhanh}}"  alt="" width="90" height="70"></div>--}}
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							 <div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label class="option"><input type="{{$ct->id_loaich==2?'checkbox':'radio'}}" name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" onclick="{{"luudapan($ct->id_cauhoi,'A',$ct->id_de,$ct->id_loaich)"}}" value="A"> <span id="opt">A. {!!$ct->a!!}</span></label>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label class="option"><input type="{{$ct->id_loaich==2?'checkbox':'radio'}}" name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" onclick="{{"luudapan($ct->id_cauhoi,'B',$ct->id_de,$ct->id_loaich)"}}" value="B"> <span id="opt">B. {!!$ct->b!!}</span></label>
								</div>
							</div>
							@if($ct->id_loaich!=4)
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label class="option"><input type="{{$ct->id_loaich==2?'checkbox':'radio'}}" name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" onclick="{{"luudapan($ct->id_cauhoi,'C',$ct->id_de,$ct->id_loaich)"}}" value="C"> <span id="opt">C. {!!$ct->c!!}</span></label>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label class="option"><input type="{{$ct->id_loaich==2?'checkbox':'radio'}}" name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" onclick="{{"luudapan($ct->id_cauhoi,'D',$ct->id_de,$ct->id_loaich)"}}" value="D"> <span id="opt">D. {!!$ct->d!!}</span></label>
									</div>
								</div>
							@endif
						</div>
					</div>

				@endforeach
				<a href="/tructuyen/{{$id_bailam}}"><button  class="pull-right next-btn"  type="button">SUBMIT</button></a>
			</div>
		</form>

		<script language="javascript">
			let getid = document.getElementsByClassName('id_CH').value;
            let m = Number("{{$dethi->thoigianthi}}");
            let s = 0; // Giây
            let timeout = null; // Timeout
			window.onload = function(){
				<?php
					$stt= 0;
					foreach($ctbailam as $ch =>$id_ch):$stt++ ?>
						if ($ctbailam[$id_ch] == getid[$stt]) {
							getid[$stt].style.background = 'red';
							{{--// {{$ch[1]}}--}}
						}
				<?php endforeach ?>
                start();
			};

			function luudapan(id_cauhoi,da_chon,id_de,id_loai){
						// var checkbox = document.getElementsByName("option");
						// for (var i = 0; i < checkbox.length; i++){
			//                 if (checkbox[i].checked === true){
			//                     alert(checkbox[i].value);
			//                 }
			//             }
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
						url: '/insertdapan',
						type: 'POST',
						data: {
							'_token': $('input[name=_token]').val(),
							'id_bailam': Number('{{$id_bailam}}'),
							'id_cauhoi': id_cauhoi,
							'da_chon': da_chon,
							'id_de': id_de,
							'id_loai': id_loai
						},
						success: function (data) {
							if((data.errors)){
								alert("Thất bại!");
							}
							// else
							// 	alert("Thành công!");

						}
				});
			}
			function stop(){
				clearTimeout(timeout);
			}
			function start() {
                if (s === -1) {
                    m -= 1;
                    s = 59;
                }

                if (m == -1) {
                    clearTimeout(timeout);
                    // alert('Hết giờ');
                    window.location.assign("/tructuyen/{{$id_bailam}}");

                    return false;
                }

                document.getElementById('m').innerText = m < 10 ? ('0' + m.toString()) : m.toString();
                document.getElementById('s').innerText = s < 10 ? ('0' + s.toString()) : s.toString();


                timeout = setTimeout(function () {
                    s--;
                    start();
                }, 1000);
            }
				
	</script>
	</div>
</div>
@endsection
@extends('frontend.layout.index')
@section('styles')
	<link href="{{asset('css/lichsubaithi.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('body')

	<div class="container-fluid">
		<div class="container main_lichsu">
			<div class="header_lichsu">
				<p>ĐÁP ÁN BÀI THI</p>
				<h3 style="text-transform: uppercase;"><b>{{$dethi->name}}</b></h3>
				<div class="information"><b>Kỳ thi: {{$dethi->tenky}} | <b>Môn: {{$dethi->tenmh}}</b> | <b>Số câu: {{$dethi->socau}} câu</b> | <b>Thời gian thi: {{$dethi->thoigianthi}} phút</b></b></div>
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
		@foreach($ctdethi2 as $ct)
			@php  $stt++; @endphp
		<div class="content1 col-md-12 col-sm-12 col-xs-12">
			<div id="question" class="content col-md-12 col-sm-12 col-xs-12">
				<input type="hidden" value="{{$ct->id_cauhoi}}" name="id_cauhoi">
				<input type="hidden" value="{{$ct->id_de}}" name="id_dethi">
				{{-- <input type="hidden" value="{{$user}}" name="id_user"> --}}
				{{$stt}} . {!!$ct->noidung!!} {{$dapanchon[$ct->id_cauhoi]}}
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<label class="option {{$dapanchon[$ct->id_cauhoi]=='A'?'bg-green':''}}">
							<input type="radio" {{$dapanchon[$ct->id_cauhoi]=='A'?'checked readonly':'disabled'}} name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" value="A" readonly>
							<span id="opt"> A. {!!$ct->a!!} <i class="{{$dapandung[$ct->id_cauhoi] != 'A'?'hide':''}} fa fa-check pull-right" aria-hidden="true"></i></span>
						</label>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<label class="option {{$dapanchon[$ct->id_cauhoi]=='B'?'bg-green':''}}">
							<input type="radio" {{$dapanchon[$ct->id_cauhoi]=='B'?'checked readonly':'disabled'}} name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" value="B">
							<span id="opt"> B. {!!$ct->b!!} <i class="{{$dapandung[$ct->id_cauhoi] != 'B'?'hide':''}} fa fa-check pull-right" aria-hidden="true"></i></span>
						</label>
					</div>
				</div>
			</div>
			@if($ct->id_loaich!=4)
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="option {{$dapanchon[$ct->id_cauhoi]=='C'?'bg-green':''}}">
								<input type="radio" {{$dapanchon[$ct->id_cauhoi]=='C'?'checked readonly':'disabled'}} name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}" value="C" readonly>
								<span id="opt"> C. {!!$ct->c!!} <i class="{{$dapandung[$ct->id_cauhoi] != 'C'?'hide':''}} fa fa-check pull-right" aria-hidden="true"></i></span>
							</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label class="option {{$dapanchon[$ct->id_cauhoi]=='D'?'bg-green':''}}">
								<input type="radio" {{$dapanchon[$ct->id_cauhoi]=='D'?'checked readonly':'disabled'}} name="bailam_{{$id_bailam}}_cauhoi_{{$ct->id_cauhoi}}"  value="D" readonly>
								<span id="opt"> D. {!!$ct->d!!} <i class="{{$dapandung[$ct->id_cauhoi] != 'D'?'hide':''}} fa fa-check pull-right" aria-hidden="true"></i></span>
							</label>
						</div>
					</div>
				</div>
			@endif
		</div>
		@endforeach
		</div>
		
	</div>
@endsection


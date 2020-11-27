@extends('frontend.layout.index')

@section('body')	

			{{--<div class="row anhbanner" style="width: 1550px">--}}
				{{----}}
				{{--<div class="col-md-12 banner">--}}
					{{--<h3 class="dream">FOLLOW YOUR DREAM</h3>--}}
					{{--<div class="up">--}}
						{{--<h2 class="online">Learn From Best Online</h2>--}}
					{{--<h2 class="training">Training Exam</h2>--}}
					{{--</div>--}}
					{{--<p class="canbtn">--}}
						{{--<a href="trangchu"><span class="view">VIEW MORE</span></a>--}}
						{{--<a href="trangchu"><span class="thamgia">JOIN EXAMIN</span></a>--}}
					{{--</p>--}}
				{{--</div>--}}
			{{--</div>--}}
			
	<div class="container-fluid main_test_container">
			<div class="container ">
			<div class="row main_test" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<form method="get" action="search" class="searchform" style="margin-bottom:10px;">
					<div class="email-box">
						<i class="fas fa-search"></i>
						<input type="text" class="form-control" name="key" placeholder="  Nhập từ khóa tìm kiếm" style="height: 100%;">
						<input type="submit" value="Tìm kiếm" class="btntk">
					</div>
				</form>
					<div class="thanh_menu">
						<ul class="nav nav-tabs ">
							<li class="active thpt1"><a data-toggle="tab" class="kythi" id="THPT" href="#menu1">Đề mới nhất</a></li>
							<li class="thpt2"><a data-toggle="tab" class="kt1" href="#menu2">Có phí</a></li>
							<li class="thpt3"><a data-toggle="tab" class="kt2" href="#menu3">Miễn phí</a></li>
							{{--<li class="thpt4"><a data-toggle="tab" class="kt3" href="#menu3">Miễn phí</a></li>--}}
						 </ul>
					</div>

					  <div class="tab-content">
							<div id="menu1" class="tab-pane fade in active">
							 <div class="row hinhanh">
								  @foreach($dethi as $dt)
									<a href="exam-question/{{$dt->id_de}}" style="color: #000">
										<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dethi ">
											<img src="{{$dt->hinhanh}}" style="width:60%;">
											<p class="tenmon">{{ $dt->name?$dt->name:$dt->tenmh }}</p>
											<p class="title"><b>Môn:</b> {{ $dt->tenmh }}</p>
											<p class="title"><b>Kỳ thi:</b> {{ $dt->tenky }}</p>
											<p class="title">Gồm {{ $dt->socau }} câu, thời gian thi {{ $dt->thoigianthi }} phút</p>
											<p class="danhgia">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>
												<i class="fas fa-users hscmt"></i> {{$dt->used_count>0?$dt->used_count:''}}
											</p>
										</div>
									</a>
									 @endforeach

							 </div>

							</div>
							<div id="menu2" class="tab-pane fade">

								<div class="row hinhanh">
									@foreach($dethi2 as $dt2)
											<a href="hocsinh/dethi/{{$dt2->id_de}}" style="color: #000">
												<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dethi">
													<img src="{{$dt2->hinhanh}}" style="width:60%;">
													<p class="tenmon">{{ $dt2->name?$dt2->name:$dt2->tenmh }}</p>
													<p class="title"><b>Môn:</b> {{ $dt2->tenmh }}</p>
													<p class="title"><b>Kỳ thi:</b> {{ $dt2->tenky }}</p>
													<p class="title">Gồm {{ $dt2->socau }} câu, thời gian thi {{ $dt2->thoigianthi }} phút</p>
													<p class="danhgia">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="far fa-star"></i>
														<i class="fas fa-users hscmt"></i> {{$dt2->used_count>0?$dt2->used_count:''}}
													</p>
												</div>
											 </a>
										@endforeach
								</div>
							</div>
							<div id="menu3" class="tab-pane fade">
								<div class="row hinhanh">
									@foreach($dethi3 as $dt3)
											<a href="exam-question/{{$dt3->id_de}}" style="color: #000">
												<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 dethi">
													<img src="{{$dt3->hinhanh}}" style="width:60%;">
													<p class="tenmon">{{ $dt3->name?$dt3->name:$dt3->tenmh }}</p>
													<p class="title"><b>Môn:</b>> {{ $dt3->tenmh }}</p>
													<p class="title"><b>Kỳ thi:</b> {{ $dt3->tenky }}</p>
													<p class="title">Gồm {{ $dt3->socau }} câu, thời gian thi {{ $dt3->thoigianthi }} phút</p>
													<p class="danhgia">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="far fa-star"></i>
														<i class="fas fa-users hscmt"></i> {{$dt3->used_count>0?$dt3->used_count:''}}
													</p>
												</div>
											 </a>
										@endforeach
								</div>

							</div>


					  </div>


			</div>
		</div>
	</div>

	</div>

	<div class="row loiich">
		{{--<div class="col-md-4"></div>--}}
		<div class="col-md-12 camnhan">

			<h3>Các Tiện Ích Luyện Thi Cấp Tốc</h3>

		</div>


		{{--<div class="col-md-3"></div>--}}

	</div>
	<div class="row gt">
		<div class="col-md-12">
			<p>Giúp các học viên nâng cao kiến thức, đạt kết quả cao, phát huy năng lực và yêu thích học tập. Đồng thời tiết kiệm tối đa thời gian, và chi phí.</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-2 col-md-1 hide-for-mobile hide-for-desktop-max-1024">
			<img src="{{ asset('imgs/banner/bg-utility_.png') }}" alt="" width="250" height="400">
		</div>
		<div class="col-lg-8 col-md-10">
			<div class="row ctloi">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-kiem-tra-thi-8.png') }}" alt="">
					<p>Phù hợp với quy trình thi</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-cau-hoi-da-dang-6.png') }}" alt="">
					<p>Hỗ trợ phần mềm nhanh, hiệu quả</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-hoc-tu-vung-2.png') }}" alt="">
					<p>Tránh gian lận trong thi cử</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-nhac-lich-hoc-4.png') }}" alt="">
					<p>Nhắc nhở lịch học hằng ngày</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-noi-dung-9.png') }}" alt="">
					<p>Quản lý ngân hàng câu hỏi</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-thong-ke-ky-nang-5.png') }}" alt="">
					<p>Quản lý đề thi đa dạng</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-tra-tu-dien-1.png') }}" alt="">
					<p>Tiết kiệm thời gian</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-tuong-tac-cao-7.png') }}" alt="">
					<p>Tính tương tác cao(Chat, Bình luận)</p>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<img src="{{ asset('imgs/banner/icon-xem-live-stream-3.png') }}" alt="">
					<p>Tương tác và giải đáp trực tiếp</p>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-1 hide-for-mobile hide-for-desktop-max-1024">
			<img src="{{ asset('imgs/banner/bg-utility_.png') }}" width="250" height="400" alt="">
		</div>
	</div>

	@include('frontend.part.feedback')

@endsection

@section('script')
	@include('frontend.part.exam_question_card_script')
@endsection
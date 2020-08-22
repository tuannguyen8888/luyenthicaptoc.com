@extends('admin.layout.index')

@section('body')	

			<div class="row anhbanner" style="width: 1550px">
				
				<div class="col-md-12 banner">
					<h3 class="dream">FOLLOW YOUR DREAM</h3>
					<div class="up">
						<h2 class="online">Learn From Best Online</h2>
					<h2 class="training">Training Exam</h2>
					</div>
					<p class="canbtn">
						<a href="trangchu"><span class="view">VIEW MORE</span></a>
						<a href="trangchu"><span class="thamgia">JOIN EXAMIN</span></a>
					</p>
				</div>
			</div>
			
		<div class="container-fluid main_test_container">
				<div class="container ">
				<div class="row main_test" >
				<div class="col-md-12">
						<div class="thanh_menu">
							<ul class="nav nav-tabs ">
							    <li class="active thpt1"><a data-toggle="tab" class="kythi" id="THPT" href="#home">Ôn Thi THPT Quốc Gia</a></li>
							    <li class="thpt2"><a data-toggle="tab" class="kt1" href="#menu1">KT Học Kỳ</a></li>
							    <li class="thpt3"><a data-toggle="tab" class="kt2" href="#menu2">KT 45 Phút</a></li>
							    <li class="thpt4"><a data-toggle="tab" class="kt3" href="#menu3">KT 15 Phút</a></li>
							 </ul>
						</div>

						  <div class="tab-content">
							    <div id="home" class="tab-pane fade in active">
							     <div class="row hinhanh">
							     	  @foreach($dethi as $dt)
							     		<a href="dethi/{{$dt->id_de}}" style="color: #000">
							     			<div class="col-md-3 dethi ">
									     		<img src="imgs/monhoc/{{ $dt->hinhanh}}" width="199" height="150" alt="">
									     		<p class="tenmon">{{ $dt->tenmh}}</p>
									     		<p class="title">Đề thi {{ $dt->tenky}} gồm {{ $dt->socau}} câu, thời gian thi 
									     			{{ $dt->thoigianthi}} phút</p>
									     		<p class="danhgia">
									     			
									     				<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
									     			

									     			<i class="fas fa-users hscmt"></i> 134
									     		</p>
								     		</div>
							     		</a>
							     		 @endforeach

							     </div>
							     
							    </div>
							    <div id="menu1" class="tab-pane fade">
							     	
							     	<div class="row hinhanh">
							     		@foreach($dethi2 as $dt2)
							     				<a href="hocsinh/dethi/{{$dt2->id_de}}" style="color: #000">
										     		<div class="col-md-3 dethi">
											     		<img src="imgs/monhoc/{{ $dt2->hinhanh}}" width="199" height="150" alt="">
											     		<p class="tenmon">{{ $dt2->tenmh}}</p>
											     		<p class="title">Đề thi {{ $dt2->tenky}} gồm {{ $dt2->socau}} câu, thời gian thi {{ $dt2->thoigianthi}} phút</p>
											     		<p class="danhgia">
											     			
											     				<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
											     			

											     			<i class="fas fa-users hscmt"></i> 134
											     		</p>
											     	</div>
											     </a>
											@endforeach
							     	</div>
							    </div>
							    <div id="menu2" class="tab-pane fade">
							     	<div class="row hinhanh">
							     		@foreach($dethi3 as $dt3)
							     				<a href="dethi/{{$dt3->id_de}}" style="color: #000">
										     		<div class="col-md-3 dethi">
											     		<img src="imgs/monhoc/{{ $dt3->hinhanh}}" width="199" height="150" alt="">
											     		<p class="tenmon">{{ $dt3->tenmh}}</p>
											     		<p class="title"><b>Đề thi {{ $dt3->tenky}}</b> gồm {{ $dt3->socau}} câu, thời gian thi {{ $dt3->thoigianthi}} phút</p>
											     		<p class="danhgia">
											     			
											     				<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
											     			

											     			<i class="fas fa-users hscmt"></i> 134
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
			<div class="col-md-4"></div>
			<div class="col-md-5 camnhan">
				
				<h3>Các Tiện Ích Luyện Thi Cấp Tốc</h3>

			</div>


			<div class="col-md-3"></div>
			
		</div>	
		<div class="row gt">
			<div class="col-md-12">
				<p>Giúp các học viên nâng cao kiến thức, đạt kết quả cao, phát huy năng lực và yêu thích học tập. Đồng thời tiết kiệm tối đa thời gian, và chi phí.</p>
			</div>
		</div>

	<div class="row">
		<div class="col-md-2">
			<img src="{{ asset('imgs/banner/bg-utility_.png') }}" alt="" width="250" height="400">
		</div>
		<div class="col-md-8">
			<div class="row ctloi">
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-kiem-tra-thi-8.png') }}" alt="">
					<p>Phù hợp với quy trình thi</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-cau-hoi-da-dang-6.png') }}" alt="">
					<p>Hỗ trợ phần mềm nhanh, hiệu quả</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-hoc-tu-vung-2.png') }}" alt="">
					<p>Tránh gian lận trong thi cử</p>
				</div>
			</div>
			<div class="row ctloi">
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-nhac-lich-hoc-4.png') }}" alt="">
					<p>Nhắc nhở lịch học hằng ngày</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-noi-dung-9.png') }}" alt="">
					<p>Quản lý ngân hàng câu hỏi</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-thong-ke-ky-nang-5.png') }}" alt="">
					<p>Quản lý đề thi đa dạng</p>
				</div>
			</div>
			<div class="row ctloi">
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-tra-tu-dien-1.png') }}" alt="">
					<p>Tiết kiệm thời gian</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-tuong-tac-cao-7.png') }}" alt="">
					<p>Tính tương tác cao(Chat, Bình luận)</p>
				</div>
				<div class="col-md-4">
					<img src="{{ asset('imgs/banner/icon-xem-live-stream-3.png') }}" alt="">
					<p>Tương tác và giải đáp trực tiếp</p>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<img src="{{ asset('imgs/banner/bg-utility_.png') }}" width="250" height="400" alt="">
		</div>
	</div>


	

		

	<div class="container-fluid thisinhcamnhan">
		<div class="container">
			<div class="row emotion">
				<div class="col-md-4"></div>
				<div class="col-md-5 camnhan">
					
					<h3>CẢM NHẬN THÍ SINH VỀ CHÚNG TÔI</h3>
				</div>

				<div class="col-md-3"></div>
		</div>	

		<div class="row abc">
			<div class="col-md-4">
				<div class="card middle">
					<div class="front anhfb1">
						
						<p class="fb1"><img src="{{ asset('imgs/fb1.png') }}" alt=""></p>
						<p class="tenthisinh">Lê Thị Ngọc Thảo</p>
						<p class="cmt"><span class="icon fa fa-quote-left"> </span>&nbsp;&nbsp; Trước tiên cho em gửi lời cảm ơn chân thành tới đội ngũ phát trển đã tạo ra cho em một môi trường học tập bổ ích và lý thú cùng  với số lượng câu hỏi đa dạng rất phù hợp với xu hướng hiện nay. Hệ thống có các bài giảng, bài tập, bài thi qua đó giúp em cải thiện được điểm số khả quan. &nbsp;<span class="icon fa fa-quote-right"> </span></p>
						<p class="decoration"></p>
					</div>
					<div class="back">
						<div class="back-content middle">
							<h2>EXAMIN</h2>
							<span>Join Exam Now !</span>
							<div class="sm">
								<a href="#"><i class="fab fa-facebook"></i></a>
								<a href="#"><i class="fab fa-youtube"></i></a>
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card middle">
					<div class="front anhfb2">
						<p class="fb1"><img src="{{ asset('imgs/fb2.jpg') }}" alt=""></p>
						<p class="tenthisinh">Nguyễn Thị Quỳnh</p>
						<p class="cmt"> <span class="icon fa fa-quote-left"> </span>&nbsp;&nbsp;  Trước tiên cho em gửi lời cảm ơn chân thành tới đội ngũ phát trển đã tạo ra cho em một môi trường học tập bổ ích và lý thú cùng  với số lượng câu hỏi đa dạng rất phù hợp với xu hướng hiện nay. Hệ thống có các bài giảng, bài tập, bài thi qua đó giúp em cải thiện được điểm số khả quan. &nbsp;<span class="icon fa fa-quote-right"> </span></p>
						<p class="decoration"></p>
					</div>
					<div class="back">
						<div class="back-content middle">
							<h2>EXAMIN</h2>
							<span>Join Exam Now !</span>
							<div class="sm">
								<a href="#"><i class="fab fa-facebook"></i></a>
								<a href="#"><i class="fab fa-youtube"></i></a>
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card middle">
					<div class="front anhfb3">
						<p class="fb1"><img src="{{ asset('imgs/fb3.png') }}" alt=""></p>
						<p class="tenthisinh">Đoàn Thị Linh</p>
						<p class="cmt"><span class="icon fa fa-quote-left"> </span>&nbsp;&nbsp; Trước tiên cho em gửi lời cảm ơn chân thành tới đội ngũ phát trển đã tạo ra cho em một môi trường học tập bổ ích và lý thú cùng  với số lượng câu hỏi đa dạng rất phù hợp với xu hướng hiện nay. Hệ thống có các bài giảng, bài tập, bài thi qua đó giúp em cải thiện được điểm số khả quan. &nbsp;<span class="icon fa fa-quote-right"> </span></p>
						<p class="decoration"></p>
					</div>
					<div class="back">
						<div class="back-content middle">
							<h2>EXAMIN</h2>
							<span>Join Exam Now !</span>
							<div class="sm">
								<a href="#"><i class="fab fa-facebook"></i></a>
								<a href="#"><i class="fab fa-youtube"></i></a>
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>

@stop

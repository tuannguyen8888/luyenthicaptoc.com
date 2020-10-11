<div class="menu-top hide-for-mobile">
	<div class="row">
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 doc">
			<p class="add"><i class="fas fa-map"></i> ADDRESS</p>
			<p class="diachi">{{CRUDBooster::getSetting('top_address')}}</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 doc" >
			<p class="add"><i class="fas fa-envelope-open"></i> EMAIL</p>
			<p class="diachi a">{{CRUDBooster::getSetting('top_email')}}</p>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 doc">
			<p class="add"><i class="fas fa-phone"></i> CONTACT</p>
			<p class="diachi">{{CRUDBooster::getSetting('top_phone')}}</p>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-1"></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 infor_user">
			@if(CRUDBooster::myId())
				@php
					$user = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
				@endphp
				<img src="{{asset($user->photo) }}" alt="" width="35" height="35">
				{{CRUDBooster::myName()}} <i class="fas fa-sort-down checklichsu" ></i>
				<div class="menunguoidung">
					{{--<p><a href="{{url('lichsu')}}"><b>Lịch Sử Bài Thi</b> <i class="fas fa-chevron-right"></i></a></p>--}}
					{{--<p><a href="{{url('dangxuat')}}"><div class="login"><i class="fas fa-sign-out-alt"></i> Logout</div></a></p>--}}
					<ul>
						<li><a href="{{url('lichsu')}}"><span class="fa fa-history"></span> Lịch Sử Bài Thi</a></li>
						<li><a href="{{url('dangxuat')}}"><span class="fas fa-sign-out-alt"></span> Đăng xuất</a></li>
					</ul>
				</div>
			@else
				<a href="{{url('dangnhap').'?redirect_url='.url()->full()}}" class="pull-right"><div class="login "><i class="fas fa-user"></i> Đăng nhập</div></a>
			@endif
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
		</div>
	</div>
</div>
<div class="menu-ngang hide-for-mobile">
	<div class="row"  data-spy="affix" data-offset-top="85">
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<a href="{{url('home') }}">
				<img id="logo" src="{{asset('imgs/logo.png') }}" alt="luyenthicapttoc.com" style="height: 97px;margin-top: -20px;border: 1px solid #f5f5f5;border-radius: 10px;background: #f5f5f5;">
			</a>

		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 ngang">
			@php
				$menus = DB::table('frontend_menus')->where('is_active', 1)->orderBy('sorting', 'asc')->get();
			@endphp
			<ul>
				@foreach ($menus as $menu)
					<li><a style="text-transform: uppercase;" href="{{$menu->path }}">{{$menu->name}} </a> </li>
				@endforeach
				<li class="hide-for-mobile">
					<form  method="get" id="searchform" action="search">
						<div class="email-box">
							<i class="fas fa-search"></i>
							<input type="text" class="tbox" name="key" placeholder="  Nhập từ khóa tìm kiếm">
							<input type="submit" value="Tìm kiếm" class="btntk">

						</div>
					</form>
				</li>

			</ul>
		</div>

		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ngang"></div>
	</div>
	<span id="scrolltopbtn" class="gotop"><i class="fas fa-arrow-up"></i></span>
</div>
<div class="menu-mobile show-for-mobile hide-for-desktop" style="height: 50px;">
	<nav class="navbar navbar-default navbar-fixed-top navbar-slide-nav">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				{{--<a class="navbar-brand" href="#">Luyện Thi Cấp Tốc</a>--}}
				<a href="{{url('home') }}" style="margin-left: 20px;">
					<img id="logo" src="{{asset('imgs/logo.png') }}" alt="luyenthicapttoc.com" style="height: 47px;">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav" style="border-bottom: solid 1px #8080805e;">
					{{--<li class="active"><a href="#">Home</a></li>--}}
					{{--<li><a href="#">Page 1</a></li>--}}
					{{--<li><a href="#">Page 2</a></li>--}}
					{{--<li><a href="#">Page 3</a></li>--}}
					@foreach ($menus as $menu)
						<li><a style="text-transform: uppercase;" href="{{$menu->path }}"><span class="{{$menu->icon}}"></span> {{$menu->name}} </a> </li>
					@endforeach
				</ul>
				<ul class="nav navbar-nav navbar-right">
					{{--<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>--}}
					{{--<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>--}}

					@if(CRUDBooster::myId())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="true">
								<span class="glyphicon glyphicon-user"></span> {{CRUDBooster::myName()}} <span class="caret pull-right"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="{{url('lichsu')}}"><span class="fa fa-history"></span> Lịch Sử Bài Thi</a></li>
								<li><a href="{{url('dangxuat')}}"><span class="fas fa-sign-out-alt"></span> Đăng xuất</a></li>
							</ul>
						</li>
					@else
						<li><a href="{{url('dangnhap').'?redirect_url='.url()->full()}}"><span class="fas fa-user"></span> Đăng nhập</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
</div>
<style>

	.gotop{
		margin-top: 600px;
		position: fixed;
		padding: 6px 13px 6px 13px;
		color: #fff;
		background: #4A9FF5;
		cursor: pointer;
	}

	.gotop:hover{
		color: #fff;
		background: #4A9FF5;
	}
	.infor_user{
		color: #fff;
		margin-top: 20px;
		text-align: right;
	}

	.infor_user img{
		border-radius: 50%;
	}
	.menunguoidung{
		background: #ffb606;
		color: #000;
		/*width: 150px;*/
		/*height: 50px;*/
		position: absolute;
		/*margin-left: 90px;*/
		right: 0;
		margin-top: 15px;
		top: 1;
		z-index: 1;
		text-align: left;
		line-height: 30px;
		border: 1px solid #9C9A9A;
		display: none;
	}
	.menunguoidung a, .menunguoidung ul li a{
		color: white;
	}
	.menunguoidung ul{
		padding: 0px !important;
	}
	.menunguoidung ul li{
		list-style: none;
		padding: 0 10px;
	}
	.menunguoidung ul li:hover{
		background: #ff9e05;
	}
	
</style>
<script type="text/javascript">

	$(document).ready(function(){
		var state=0;
		$(".infor_user").click(function(){
			if(state==0){
				$(".menunguoidung").css("display", "block");
				state=1;
			}else if(state==1){
				$(".menunguoidung").css("display", "none");
				state=0;
			}
		})
	})

	$('#scrolltopbtn').click(function(){
		$('html,body').animate({scrollTop:0}, 2000)
	});

	 // const button = document.getElementById('scrolltopbtn');

	 // function scrollToTop(){
	 // 	function scrolling(){
	 // 		if(window.scrollY>0){
	 // 			window.scrollTo(0, window.scrollY -30);

	 // 	}
	 // }
	 // scrolling();


	 // 		}
	 // 			button.addEventListener('click', scrollToTop);
</script>
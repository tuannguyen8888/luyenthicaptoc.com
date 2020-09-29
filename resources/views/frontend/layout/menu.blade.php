


<div class="menu-top hide-for-mobile">
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-1 doc">
			<p class="add"><i class="fas fa-map"></i> ADDRESS</p>
			<p class="diachi">{{CRUDBooster::getSetting('top_address')}}</p>
		</div>
		<div class="col-md-2 doc" >
			<p class="add"><i class="fas fa-envelope-open"></i> EMAIL</p>
			<p class="diachi a">{{CRUDBooster::getSetting('top_email')}}</p>
		</div>
		<div class="col-md-1 doc">
			<p class="add"><i class="fas fa-phone"></i> CONTACT</p>
			<p class="diachi">{{CRUDBooster::getSetting('top_phone')}}</p>
		</div>
		<div class="col-md-3"></div>
		<div class="col-md-2 infor_user">
			@if(CRUDBooster::myName())
				@php
					$user = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
				@endphp
				<img src="{{asset($user->photo) }}" alt="" width="35" height="35">
				{{CRUDBooster::myName()}} <i class="fas fa-sort-down checklichsu" ></i>
			@endif
			<div class="menunguoidung">
				<p><a href="{{url('lichsu')}}"><b>Lịch Sử Bài Thi</b> <i class="fas fa-chevron-right"></i></a></p>

			</div>
		</div>
		<div class="col-md-2">
			@if(CRUDBooster::myName())
					<a href="{{url('dangxuat')}}"><div class="login"><i class="fas fa-sign-out-alt"></i> Logout</div></a>
				@else

					<a href="{{url('dangnhap').'?redirect_url='.url()->full()}}"><div class="login "><i class="fas fa-user"></i> Login</div></a>
				@endif
			</div>
		</div>
</div>
<div class="menu-ngang" >
	<div class="row"  data-spy="affix" data-offset-top="85">
		<div class="col-md-1"></div>
		<div class="col-md-2">
			<a href="{{url('home') }}">
				<img id="logo" src="{{asset('imgs/logo.png') }}" alt="luyenthicapttoc.com" style="height: 97px;margin-top: -20px;border: 1px solid #f5f5f5;border-radius: 10px;background: #f5f5f5;">
			</a>

		</div>
		<div class="col-md-9 ngang">
			@php
				$menus = DB::table('frontend_menus')->where('is_active', 1)->orderBy('sorting', 'asc')->get();
			@endphp
			<ul>
				@foreach ($menus as $menu)
					<li><a style="text-transform: uppercase;" href="{{$menu->path }}">{{$menu->name}} </a> </li>
				@endforeach
				<li>
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

		<div class="col-md-1 ngang"></div>
	</div>
	<span id="scrolltopbtn" class="gotop"><i class="fas fa-arrow-up"></i></span>
</div>
<style>

	.gotop{
		margin-top: 600px;
		position: fixed;
		padding: 6px 13px 6px 13px;
		color: #fff;
		background: #4A9FF5;
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
		width: 150px;
		height: 50px;
		position: fixed;
		margin-left: 90px;
		margin-top: 15px;
		top: 1;
		z-index: 1;
		text-align: center;
		line-height: 50px;
		border: 1px solid #9C9A9A;
		display: none;
	}
	.menunguoidung a{
		color: #000;

	}
	
</style>
		<script type="text/javascript">

			$(document).ready(function(){
				var state=0;
				$(".checklichsu").click(function(){
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
				$('html,body').animate({scrollTop:600}, 2000)
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

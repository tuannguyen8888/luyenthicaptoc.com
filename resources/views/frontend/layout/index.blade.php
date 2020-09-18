<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Luyện Thi Cấp Tốc</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<script src="{{ asset('js/jquery3.3.1.min.js') }}"></script>
	<script  src="{{ asset('js/bootstrap.min.js') }}"></script>	
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<script  src="{{ asset('js/jquery/1.10.1/jquery.min.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('imgs/favicon16.png') }}">
	<link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/hocsinh.css') }}" rel="stylesheet" >
	<link href="{{ asset('css/chitiet/lienhe.css') }}" rel="stylesheet" >
	<link href="{{ asset('css/anhchuyendong.css') }}" rel="stylesheet" type="text/css">
	<!-- 2 follow links is to count number up -->
	<script src="{{ asset('js/counter_up/jquery.counterup.js') }}"></script>
	<script src="{{ asset('js/waypoint/jquery.waypoints.js') }}"></script>
	{{-- <script type="text/javascript" src="{{ asset('editor/ckeditor/ckeditor.js')}}"></script> --}}
	<link href="{{ asset('css/OwlCarousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/OwlCarousel/dist/assets/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css">
<style>
	.affix{
		left: 9px;
	}
	.main_test_container{
		background-image: url('imgs/banner/bg-feedback-student.jpg');
		margin-bottom: 30px;
	}
	.bgsearch{
		background-image: url('imgs/banner/bg-feedback-student.jpg');
	}
	.login{
		float: left;
		margin-left: 15px;
	}
	
</style>
 
<script>
(function(s, u, b, i, z){
  u[i]=u[i]||function(){
    u[i].t=+new Date();
    (u[i].q=u[i].q||[]).push(arguments);
  };
  z=s.createElement('script');
  var zz=s.getElementsByTagName('script')[0];
  z.async=1; z.src=b; z.id='subiz-script';
  zz.parentNode.insertBefore(z,zz);
})(document, window, 'https://widgetv4.subiz.com/static/js/app.js', 'subiz');
subiz('setAccount', 'acqdqbopxrdhtmizzgjf');
</script>


</head>
<body>
	@include('frontend.layout.menu')
		

	@yield('body')
	
	@include('frontend.layout.footer')






	{{--<script type="text/javascript">--}}
		{{----}}
		{{--$(".num").counterUp()({--}}
                {{--delay: 10,--}}
                {{--time: 1000--}}
            {{--});--}}
    {{--</script>--}}

    <script>   


	$(document).ready(function(){
		  $(".hinhanh").click(function(){
		    $(".thpt1").css({"border-radius":"25px","text-align":"center","width":"200px","background-color":"#002147","color": "#fff"});
		     $(".kythi").css({"border-radius":"25px","width":"200px","text-align":"center","background-color":"#002147","color": "#fff"});
		     $(".thpt3").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".thpt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		  });
		});

		$(document).ready(function(){
		  $(".thpt1").click(function(){
		    $(".thpt1").css({"border-radius":"25px","text-align":"center","width":"200px","background-color":"#002147","color": "#fff"});
		     $(".kythi").css({"border-radius":"25px","width":"200px","text-align":"center","background-color":"#002147","color": "#fff"});
		     $(".thpt3").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".thpt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		  });
		});

		$(document).ready(function(){
		  $(".thpt2").click(function(){
		    $(".thpt2").css({"border-radius":"25px","text-align":"center","width":"150px","background-color":"#002147","color": "#fff"});
		     $(".kt1").css({"border-radius":"25px","width":"150px","text-align":"center","background-color":"#002147","color": "#fff"});
		     $(".thpt3").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".thpt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kythi").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		  });
		});

		$(document).ready(function(){
		  $(".thpt3").click(function(){
		    $(".thpt3").css({"border-radius":"25px","text-align":"center","width":"150px","background-color":"#002147","color": "#fff"});
		    $(".kt2").css({"border-radius":"25px","text-align":"center","width":"150px","background-color":"#002147","color": "#fff"});
		    $(".thpt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kythi").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".thpt2").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		     $(".kt1").css({"border-radius":"25px","background-color":"#D0CDCD","color": "#000"});
		  });
		});
	</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Luyện Thi Cấp Tốc</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="{{ asset('js/jquery3.3.1.min.js') }}"></script>
	<script  src="{{ asset('js/bootstrap.min.js') }}"></script>	
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<!-- Bootstrap 3.4.1 -->
{{--	<link href="{{ asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>--}}
	<!-- Font Awesome Icons -->
	<link href="{{asset("vendor/crudbooster/assets/adminlte/font-awesome/css")}}/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<!-- Ionicons -->
	<link href="{{asset("vendor/crudbooster/ionic/css/ionicons.min.css")}}" rel="stylesheet" type="text/css"/>
	<!-- Theme style -->
	<link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css"/>


	<script  src="{{ asset('js/jquery/1.10.1/jquery.min.js') }}"></script>
    <link rel="shortcut icon" href="{{ asset('imgs/favicon16.png') }}">
	<link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/hocsinh.css') }}" rel="stylesheet" >
	<link href="{{ asset('css/anhchuyendong.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/mobile.css') }}" rel="stylesheet" type="text/css">
	<!-- 2 follow links is to count number up -->
	<script src="{{ asset('js/counter_up/jquery.counterup.js') }}"></script>
	<script src="{{ asset('js/waypoint/jquery.waypoints.js') }}"></script>
	{{-- <script type="text/javascript" src="{{ asset('editor/ckeditor/ckeditor.js')}}"></script> --}}
	<link href="{{ asset('css/OwlCarousel/dist/assets/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/OwlCarousel/dist/assets/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css">
    @yield('styles')
<style>
	.affix{
		left: 9px;
	}
	.main_test_container{
		background-image: url('/imgs/banner/bg-feedback-student.jpg');
		margin-bottom: 30px;
	}
	.bgsearch{
		background-image: url('/imgs/banner/bg-feedback-student.jpg');
	}
	.login{
		float: left;
		margin-left: 15px;
	}
	
</style>
 
{{--<script>--}}
{{--(function(s, u, b, i, z){--}}
  {{--u[i]=u[i]||function(){--}}
    {{--u[i].t=+new Date();--}}
    {{--(u[i].q=u[i].q||[]).push(arguments);--}}
  {{--};--}}
  {{--z=s.createElement('script');--}}
  {{--var zz=s.getElementsByTagName('script')[0];--}}
  {{--z.async=1; z.src=b; z.id='subiz-script';--}}
  {{--zz.parentNode.insertBefore(z,zz);--}}
{{--})(document, window, 'https://widgetv4.subiz.com/static/js/app.js', 'subiz');--}}
{{--subiz('setAccount', 'acqdqbopxrdhtmizzgjf');--}}
{{--</script>--}}


</head>
<body style="overflow-x: hidden;">
	@include('frontend.layout.menu')
		

	@yield('body')
	
	@include('frontend.layout.footer')

</body>
@yield('script')
</html>

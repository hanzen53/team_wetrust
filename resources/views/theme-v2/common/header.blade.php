<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="{{secure_asset('theme-wetrust/images/favicon.ico')}}">

	<title>WETRUSTGPS.COM</title>

	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">

	<!-- Bootstrap-extend -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/css/bootstrap-extend.css')}}">

	<!-- Morris charts -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/assets/vendor_components/morris.js/morris.css')}}">

	<!-- date picker -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">

	<!-- daterange picker -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.css')}}">

	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.css')}}">

	<!-- theme style -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/css/master_style.css')}}">

	<!-- Unique_Admin skins -->
	<link rel="stylesheet" href="{{secure_asset('theme-wetrust/css/skins/_all-skins.css')}}">

	<link rel="stylesheet" href="{{asset('/js/jquery.Thailand.js/dist/jquery.Thailand.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/datepicker.css')}}">


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<header class="main-header">
		<!-- Logo -->
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>

			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">

					<!-- User Account -->
					@if(Auth::check())
					<li class="dropdown user user-menu">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="{{secure_asset('uploads/'.Auth::user()->avatar)}}" class="user-image rounded-circle" alt="User Image">
						</a>
						<ul class="dropdown-menu scale-up">
							<!-- User image -->
							<li class="user-header">
								<img src="{{secure_asset('uploads/'.Auth::user()->avatar)}}" class="float-left rounded-circle" alt="User Image">

								<p>
									{{Auth::user()->name}}
									<small class="mb-5">{{Auth::user()->email}}</small>
									<a href="/user/profile" class="btn btn-danger btn-sm btn-rounded">View Profile</a>
								</p>
							</li>
							<!-- Menu Body -->
							<li class="user-body">
								<div class="row no-gutters">
									<div class="col-12 text-left">
										<a href="#"><i class="ion ion-person"></i> My Profile</a>
									</div>
									<div class="col-12 text-left">
										<a href="#"><i class="ion ion-email-unread"></i> Inbox</a>
									</div>
									<div class="col-12 text-left">
										<a href="#"><i class="ion ion-settings"></i> Setting</a>
									</div>
									<div role="separator" class="divider col-12"></div>
									<div class="col-12 text-left">
										<a href="#"><i class="ti-settings"></i> Account Setting</a>
									</div>
									<div role="separator" class="divider col-12"></div>
									<div class="col-12 text-left">
										<a href="#"><i class="fa fa-power-off"></i> Logout</a>
									</div>
								</div>
								<!-- /.row -->
							</li>
						</ul>
					</li>
					<!-- Control Sidebar Toggle Button -->
					@endif
					{{--<li>--}}
						{{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>--}}
					{{--</li>--}}
				</ul>
			</div>
		</nav>
	</header>


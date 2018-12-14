<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css') }}">
		<!-- Morris chart -->
		<link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css') }}">
		<!-- jvectormap -->
		<link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
		<!-- Date Picker -->
		<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
		<!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		<style>
		#profile_picture {
			padding: 0;
			border: none;
		}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="index2.html" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>A</b>LT</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Admin</b>LTE</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="{{$profile->profile_picture }}" class="user-image" alt="User Image">
								<span class="hidden-xs">{{ Auth::user()->name }}</span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="{{$profile->profile_picture }}" class="img-circle" alt="User Image">
									<p>
										{{ Auth::user()->name }}
										<small>Member since {{ Auth::user()->created_at }}</small>
									</p>
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="{{ route('profile')}}" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="@if($profile->profile_picture) {{ $profile->profile_picture }} @else {{ asset('img/avatar5.png') }} @endif" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>{{ Auth::user()->name }}</p>
					</div>
				</div>
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" data-widget="tree">
					<li>
						<a href="{{ route('home') }}">
							<i class="fa fa-globe"></i> <span>Back to Website</span>
						</a>
					</li>						
					<li class="header">MAIN NAVIGATION</li>

					<li class="@if(Route::is('dashboard') || Route::is('account') ) active @endif">
						<a href="{{ route('dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li  class="@if(Route::is('profile')) active @endif">
						<a href="{{ route('profile') }}">
							<i class="fa fa-user"></i> <span>Profile</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-edit"></i> <span>Forms</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
							<li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
							<li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
						</ul>
					</li>
					<li><a href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
					<li class="header">HELP</li>
					<li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
					<li>
						<!-- search form -->
						<form action="#" method="get" class="sidebar-form">
							<div class="input-group">
								<input type="text" name="q" class="form-control" placeholder="Search...">
								<span class="input-group-btn">
									<button type="submit" name="" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
									</button>
								</span>
							</div>
						</form>
						<!-- /.search form -->

					</li>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->

			<section class="content-header">
				<h1>
					@if(isset($title))
					{{$title}}
					@else
					Account
					@endif
					<small>@if(isset($description)) {{$description}} @endif</small>
				</h1>
				<ol class="breadcrumb">
					<li class="@if(!isset($title)) active @endif"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">@if(isset($title)){{$title}}@endif</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				@if(session('success'))
				<div class="alert alert-dismissible alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					{{session('success')}}
				</div>
				@endif

				@if(session('error'))
				<div class="alert alert-dismissible alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					{{session('error')}}
				</div>
				@endif

				@if (isset($flash))
				<div class="alert alert-dismissible alert-{{$flash['type']}}">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					{{$flash['message']}}
				</div>
				@endif

				@yield('content')
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.4.0
			</div>
			<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
			reserved.
		</footer>
		<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
		immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->


	<!-- Scripts -->
	<!-- jQuery 3 -->
	<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Morris.js charts -->
	<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>
	<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>
	<!-- Sparkline -->
	<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
	<!-- jvectormap -->
	<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
	<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<!-- datepicker -->
	<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
	<!-- Slimscroll -->
	<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<!-- FastClick -->
	<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('js/adminlte.min.js') }}"></script>
	<script src="{{ asset('js/common.js') }}"></script>
</body>
</html>

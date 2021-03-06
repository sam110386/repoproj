<!DOCTYPE html>
@extends('layouts.default')
@section('content')
<!--div class="register-page" -->
	<div class="register-box">


		<div class="register-box-body">
			@if(session('error'))
			<div class="alert alert-dismissible alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{{session('error')}}
			</div>
			@endif
			<p class="login-box-msg">Register a new membership</p>

			<form action="{{ route('register') }}" method="post">
				{{ csrf_field() }}
				<div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
					<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Full name">
					@if ($errors->has('name'))
					<span class="help-block">
						<strong>{{ $errors->first('name') }}</strong>
					</span>
					@endif
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

					@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					<span class="glyphicon glyphicon-envelope form-control-feedback {{ $errors->has('password') ? ' has-error' : '' }}"></span>
				</div>
				<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
					<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
					@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype Password" required>
					@if ($errors->has('password'))
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif					
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck">
							<label>
								<input type="checkbox"> I agree to the <a href="#">terms</a>
							</label>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
					</div>
					<!-- /.col -->
				</div>
			</form>

			<!--div class="social-auth-links text-center">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
				Facebook</a>
				<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
				Google+</a>
			</div-->

			<a href="{{ route('login') }}" class="text-center">I already have an Account</a>
		</div>
		<!-- /.form-box -->
	</div>
<!--/div-->
@endsection
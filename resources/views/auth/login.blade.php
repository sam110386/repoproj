@extends('layouts.default')
@section('content')
<!--div class="login-page"-->
	<div class="login-box ">
		<div class="login-box-body panel-body ">
			<p class="login-box-msg">Sign in to start your session</p>

			<form action="{{ route('login') }}" method="post">
				{{ csrf_field() }}
				<div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
					@if ($errors->has('email'))
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
					<input id="password" type="password" class="form-control" name="password" required>
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
								<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
							</label>
						</div>
					</div>
					<!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
	<a href="{{ route('password.request') }}">
		Forgot Your Password?
	</a><br>
	<a href="{{ route('register') }}" class="text-center">Don't have account</a>
	
</div>
<!-- /.form-box -->
</div>
<!--/div-->

@endsection
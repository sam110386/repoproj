@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box box-primary">	
			<div class="box-header with-border">
				<h3 class="box-title">Profile Information</h3>
			</div>	
			<div class="box-body box-profile">

				<img class="profile-user-img img-responsive img-circle" src="{{ $profile->profile_picture }}" alt="{{ $profile->name }}">

				<h3 class="profile-username text-center">{{ $profile->name }}</h3>

				<p class="text-muted text-center">{{ $profile->email }}</p>
				<p>&nbsp;</p>
				<form class="form-horizontal" action="{{ route('profile-info-save') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-4 control-label">Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="name" placeholder="Name" name="name" value="@if(old('name')){{old('name')}}@else{{ $profile->name }}@endif" >
							@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
						<label for="phone" class="col-sm-4 control-label">Phone Number</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value="@if(old('phone')){{old('phone')}}@else{{ $profile->phone }}@endif" >
							@if ($errors->has('phone'))
							<span class="help-block">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
							@endif
						</div>
					</div>					
					<div class="form-group {{ $errors->has('profile_picture') ? ' has-error' : '' }}">
						<label for="profile_picture" class="col-sm-4 control-label">Profile Picture</label>
						<div class="col-sm-8">
							<input type="file" class="form-control custom-file-input" id="profile_picture" name="profile_picture">
							@if ($errors->has('profile_picture'))
							<span class="help-block">
								<strong>{{ $errors->first('profile_picture') }}</strong>
							</span>
							@endif							
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn bg-blue">Update Profile</button>
						</div>
					</div>					
				</form>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Update Information</h3>
			</div>
			<div class="box-body">
				<form class="form-horizontal" action="{{ route('profile-password-save')}}" method="POST">
					{{ csrf_field() }}
					<div class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">
						<label for="old_password" class="col-sm-4 control-label">Old Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="old_password" placeholder="Old Password" autocomplete="off" name="old_password" required>
							@if ($errors->has('old_password'))
							<span class="help-block">
								<strong>{{ $errors->first('old_password') }}</strong>
							</span>
							@endif									
						</div>
					</div>
					<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="inputName" class="col-sm-4 control-label">New Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="inputName" placeholder="New Password" autocomplete="off" name="password" required>
							@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
							@endif							
						</div>
					</div>
					<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="inputName" class="col-sm-4 control-label">Confirm New Password</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="inputName" placeholder="Confirm New Password" autocomplete="off" name="password_confirmation" required >
							@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
							@endif							
						</div>
					</div>					
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn bg-blue">Update Password</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.box-body -->
		</div>
	</div>	
</div>

@endsection

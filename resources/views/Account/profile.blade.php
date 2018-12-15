@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-7">
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
					<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="email" placeholder="Email" name="email" value="@if(old('email')){{old('email')}}@else{{ $profile->email }}@endif" >
							@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
						<label for="phone" class="col-sm-4 control-label">Phone #</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value="@if(old('phone')){{old('phone')}}@else{{ $profile->phone }}@endif" >
							@if ($errors->has('phone'))
							<span class="help-block">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<legend>Address Information</legend>
					<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
						<label for="address" class="col-sm-4 control-label">Street Address</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="address" placeholder="Street Address" name="address" value="@if(old('address')){{old('address')}}@else{{ $profile->address }}@endif" >
							@if ($errors->has('address'))
							<span class="help-block">
								<strong>{{ $errors->first('address') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('region') ? ' has-error' : '' }}">
						<label for="region" class="col-sm-4 control-label">Region</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="region" placeholder="Region" name="region" value="@if(old('region')){{old('region')}}@else{{ $profile->region }}@endif" >
							@if ($errors->has('region'))
							<span class="help-block">
								<strong>{{ $errors->first('region') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('district') ? ' has-error' : '' }}">
						<label for="district" class="col-sm-4 control-label">District</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="district" placeholder="District" name="district" value="@if(old('district')){{old('district')}}@else{{ $profile->district }}@endif" >
							@if ($errors->has('district'))
							<span class="help-block">
								<strong>{{ $errors->first('district') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('ward') ? ' has-error' : '' }}">
						<label for="ward" class="col-sm-4 control-label">Ward</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="ward" placeholder="Ward" name="ward" value="@if(old('ward')){{old('ward')}}@else{{ $profile->ward }}@endif" >
							@if ($errors->has('ward'))
							<span class="help-block">
								<strong>{{ $errors->first('ward') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('zipcode') ? ' has-error' : '' }}">
						<label for="zipcode" class="col-sm-4 control-label">Zip Code</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="zipcode" placeholder="Zip Code" name="zipcode" value="@if(old('zipcode')){{old('zipcode')}}@else{{ $profile->zipcode }}@endif" >
							@if ($errors->has('zipcode'))
							<span class="help-block">
								<strong>{{ $errors->first('zipcode') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					<legend>Staff Information</legend>
					<div class="row">
					<div class="form-group">
						<label class="col-sm-4 control-label">Client</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input type="text" class="form-control" id="client_male" placeholder="Male" name="client_male" value="@if(old('client_male')){{old('client_male')}}@else{{ $profile->client_male }}@endif" >
							</div>
							@if ($errors->has('client_male'))
								<span class="help-block">
									<strong>{{ $errors->first('client_male') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-female"></i></span>
								
							<input type="text" class="form-control" id="client_female" placeholder="Male" name="client_female" value="@if(old('client_female')){{old('client_female')}}@else{{ $profile->client_female }}@endif" >
							</div>
							@if ($errors->has('client_female'))
							<span class="help-block">
								<strong>{{ $errors->first('client_female') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>	
					<div class="row">
					<div class="form-group">
						<label class="col-sm-4 control-label">Staff</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input type="text" class="form-control" id="staff_male" placeholder="Male" name="staff_male" value="@if(old('staff_male')){{old('staff_male')}}@else{{ $profile->staff_male }}@endif" >
							</div>
							@if ($errors->has('staff_male'))
								<span class="help-block">
									<strong>{{ $errors->first('staff_male') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-female"></i></span>
								
							<input type="text" class="form-control" id="staff_female" placeholder="Male" name="staff_female" value="@if(old('staff_female')){{old('staff_female')}}@else{{ $profile->staff_female }}@endif" >
							</div>
							@if ($errors->has('staff_female'))
							<span class="help-block">
								<strong>{{ $errors->first('staff_female') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>	
					<div class="row">
					<div class="form-group">
						<label class="col-sm-4 control-label">Board Memeber</label>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-male"></i></span>
								<input type="text" class="form-control" id="boardmember_male" placeholder="Male" name="boardmember_male" value="@if(old('boardmember_male')){{old('boardmember_male')}}@else{{ $profile->boardmember_male }}@endif" >
							</div>
							@if ($errors->has('boardmember_male'))
								<span class="help-block">
									<strong>{{ $errors->first('boardmember_male') }}</strong>
								</span>
							@endif
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-female"></i></span>
								
							<input type="text" class="form-control" id="boardmember_female" placeholder="Male" name="boardmember_female" value="@if(old('boardmember_female')){{old('boardmember_female')}}@else{{ $profile->boardmember_female }}@endif" >
							</div>
							@if ($errors->has('boardmember_female'))
							<span class="help-block">
								<strong>{{ $errors->first('boardmember_female') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>		
					<div class="form-group {{ $errors->has('profile_picture') ? ' has-error' : '' }}">
						<label for="profile_picture" class="col-sm-4 control-label">Logo</label>
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
	<div class="col-md-5">
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

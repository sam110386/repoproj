<style type="text/css">
.flex-container {display: flex;}
.flex-container div.small-box{margin-bottom:10%;height: 90%; }
.flex-container .small-box > .small-box-footer{position: absolute;width: 100%;bottom: 0;}
.flex-container .small-box > .inner {padding: 10px;position: absolute;top: 50%;transform: translateY(-50%);width: 100%;}
</style>
<div class="flex-container">
	<div class="col-md-2">
		<div class="small-box bg-aqua">
			<div class="inner">
				<p></p>
				<center>Clients</center>
				<h3><center>{{$clients}}</center></h3>


			</div>
			<div class="icon">
				<i class="fa fa-"></i>
			</div>
			<a href="/admin/institutes" class="small-box-footer">
				More&nbsp;
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<div class="col-md-2">
		<div class="small-box bg-green">
			<div class="inner">
				<p></p>
				<center>Staffs</center>
				<h3><center>{{$staff}}</center></h3>


			</div>
			<div class="icon">
				<i class="fa fa-"></i>
			</div>
			<a href="/admin/institutes" class="small-box-footer">
				More&nbsp;
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<div class="col-md-2">
		<div class="small-box bg-red">
			<div class="inner">
				<p></p>
				<center>Board Memebers</center>
				<h3><center>{{$boardmember}}</center></h3>


			</div>
			<div class="icon">
				<i class="fa fa-"></i>
			</div>
			<a href="/admin/institutes" class="small-box-footer">
				More&nbsp;
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<div class="col-md-5">
		<div class="table-responsive panel">
			<table class="table table-striped">
				<tr>
					<td width="120px" colspan="2" align="center"><strong>Top Performer</strong></td>

				</tr>
				@foreach($institutes as $institute)
				<tr>
					<td width="120px">{{$institute->name}}</td>
					<td>
						@if($institute->ratio>0)
						<div style="width:{{$institute->ratio*100}}%;background:green;float:left;color:#fff;text-align: center;">{{ $institute->total-$institute->totalfemail}}</div><div style="width:{{(1-$institute->ratio)*100}}%;background:red;float:right;color:#fff;text-align: center;">{{$institute->totalfemail}}</div>
						@else
						<div style="width:100%;background:green;float:left;color:#fff;text-align: center;">0</div>
						@endif
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

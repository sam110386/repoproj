@extends('layouts.app')

@section('content')
<div class="box">
	<div class="box-header with-border">
		<!--h3 class="box-title">Title</h3-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-2"><div class="small-box bg-aqua">
					<div class="inner">
						<p></p>
						<center>Clients</center>
						<h3><center>{{number_format($profile->client_male+$profile->client_female,0,'',',')}}</center></h3>
					</div>
					<div class="icon">
						<i class="fa fa-"></i>
					</div>
					
				</div>
			</div>
			<div class="col-md-2"><div class="small-box bg-green">
				<div class="inner">
					<p></p>
					<center>Staffs</center>
					<h3><center>{{number_format($profile->staff_male+$profile->staff_female,0,'',',')}}</center></h3>
				</div>
				<div class="icon">
					<i class="fa fa-"></i>
				</div>
			</div>
		</div>
		<div class="col-md-2"><div class="small-box bg-red">
			<div class="inner">
				<p></p>
				<center>Board Memebers</center>
				<h3><center>{{number_format($profile->boardmember_male+$profile->boardmember_female,0,'',',')}}</center></h3>

			</div>
			<div class="icon">
				<i class="fa fa-"></i>
			</div>
			
		</div>
	</div>
	<div class="col-md-3"></div>
</div>
</div>
<div class="box-footer">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Report Category</th>
					<th>Period</th>
					<th>Total Capital</th>
					<th>Total Assest</th>
					<th>Total Liability</th>
					<th>Loan Advance</th>
					<th>Customer Deposits</th>
					<th>Profit Exc Tax</th>
					<th>Return Ave Assets</th>
					<th>Return Equity</th>
					<th>Timestamp</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if(!empty($reports))
				@foreach($reports as $report)
				<tr>
					<td>{{$report->id}}</td>
					<td>{{$report->report_category}}</td>
					@if ($report->report_category=="Monthly")							
					<td>{{$report->submission_period}}</td>
					@endif
					@if($report->report_category=="Quaterly")
					<td>{{'Q'.$report->submission_quater}}</td>
					@endif
					@if($report->report_category=="Audited")
					<td>{{$report->report_year}}</td>
					@endif
					<td>{{$report->total_capital}}</td>
					<td>{{$report->total_assest}}</td>
					<td>{{$report->total_liability}}</td>
					<td>{{$report->loan_advance}}</td>
					<td>{{$report->customer_deposits}}</td>
					<td>{{$report->profit_before_tax}}</td>
					<td>{{$report->return_average_assets}}</td>
					<td>{{$report->return_equity}}</td>
					<td>{{App\Helpers\CommonMethod::formatDateWithTime($report->created_at)}}</td>
					<td>
						<a href="{{ route('report')}}/{{$report->id}}" class="link" title="View" alt="view"><i class="fa fa-search"></i></a>
					</td>
				</tr>
				@endforeach
				@endif
				
				
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
@endsection

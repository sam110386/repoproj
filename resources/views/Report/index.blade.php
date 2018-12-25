@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">	
			
			<div class="box-body box-profile">
				<!-- Bordered table -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">My Reports</h5>
							<a href="{{ route('report-add') }}" class="pull-right btn bg-blue" >
								 <span>Add Reports</span>
							</a>
						</div>

						<div class="panel-body">
							
						</div>

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
									@php $i=1; @endphp
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
							{{ $reports->appends($request->all())->links() }}
						</div>
					</div>
					<!-- /bordered table -->
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	
</div>

@endsection

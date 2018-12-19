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
							Example of a table with fully <code>bordered</code> cells. Add <code>.table-bordered</code> to the base <code>.table</code> class for borders on all sides of the table and cells. This is a default Bootstrap option for the table, for more advanced border options check <a href="table_borders.html">Table borders</a> page. Bordered table can be combined with other table styles.
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
										<td>{{$i++}}</td>
										<td>{{$report->report_category}}</td>
										<td>{{$report->submission_period}}</td>
										<td>{{$report->total_capital}}</td>
										<td>{{$report->total_assest}}</td>
										<td>{{$report->total_liability}}</td>
										<td>{{$report->loan_advance}}</td>
										<td>{{$report->customer_deposits}}</td>
										<td>{{$report->profit_before_tax}}</td>
										<td>{{$report->return_average_assets}}</td>
										<td>{{$report->return_equity}}</td>
										<td>{{$report->created_at}}</td>
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
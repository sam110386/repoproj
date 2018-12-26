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

						<form action="" class="form-horizontal"  method="get" id="reportsearch">

							<div class="row">
								<div class="col-md-6">
									<div class="box-body">
										<div class="fields-group">
											<div class="form-group">
												<label class="col-sm-2 control-label"> Category</label>
												<div class="col-sm-8">
													<select class="form-control report_category select2-hidden-accessible" name="report_category" style="width: 100%;" tabindex="-1" aria-hidden="true">
														<option></option>
														<option value="Monthly" {{$request->report_category=='Monthly'?"selected":''}}>Monthly</option>
														<option value="Quaterly" {{$request->report_category=='Quaterly'?"selected":''}}>Quaterly</option>
														<option value="Audited" {{$request->report_category=='Audited'?"selected":''}}>Audited</option>
													</select></div>
												</div>

												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="box-body">
												<div class="fields-group">
													<div class="form-group">
														<label class="col-sm-2 control-label">Created</label>
														<div class="col-sm-8" style="width: 390px">
															<div class="input-group input-group-sm input-daterange" id="datepicker">
																<div class="input-group-addon">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control" id="created_at_start" placeholder="Created" name="start" value="{{$request->start}}">
																<span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
																<input type="text" class="form-control" id="created_at_end" placeholder="Created" name="end" value="{{$request->end}}">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.box-body -->

									<div class="box-footer">
										<div class="row">
											<div class="col-md-6">
												<div class="col-md-2"></div>
												<div class="col-md-8">
													<div class="btn-group pull-left">
														<button class="btn btn-info submit btn-sm" type="submit"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
													</div>

												</div>
											</div>
											<div class="col-md-6">
												<div class="col-md-2"></div>
												<div class="col-md-8">
													<div class="btn-group pull-left">
														<a class="btn btn-danger  btn-sm" href="/account/report/export?report_category={{$request->report_category}}&start={{$request->start}}&end={{$request->end}}"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export</a>
													</div>

												</div>
											</div>
										</div>
									</div>

								</form>
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
											<td>{{\App\Helpers\CommonMethod::getMonthName($report->submission_period)}}</td>
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


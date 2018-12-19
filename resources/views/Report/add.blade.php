@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">	
			<div class="box-header with-border">
				<h3 class="box-title">Report Submission Information</h3>
			</div>	
			<div class="box-body box-profile">

				
				<p>&nbsp;</p>
				<form class="form-horizontal" action="{{ route('report-info-save') }}" method="POST" enctype="multipart/form-data"  >
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group {{ $errors->has('report_category') ? ' has-error' : '' }}">
								<label for="name" class="col-sm-5 control-label">Report Category</label>
								<div class="col-sm-7">							
									<select class="form-control m-bot15" name="report_category">								  
										   <option value="Monthly" {{(old('report_category')=='Monthly')?'slected':''}}>Monthly</option>
										   <option value="Quaterly" {{(old('report_category')=='Quaterly')?'slected':''}}>Quaterly</option>
										   <option value="Audited" {{(old('report_category')=='Audited')?'slected':''}}>Audited</option>								 
										</select>
									@if ($errors->has('report_category'))
									<span class="help-block">
										<strong>{{ $errors->first('report_category') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('submission_period') ? ' has-error' : '' }}">
								<label for="submission_period" class="col-sm-5 control-label">Submission Period</label>
								<div class="col-sm-7">
									<div id="show1">
									<select class="form-control m-bot15" name="submission_period">								  
										   <option value="1" {{(old('submission_period')=='1')?'slected':''}}>January</option>
										   <option value="2" {{(isset($report) && $report->submission_period=='2')?'slected':''}}>February</option>
										   <option value="3" {{(old('submission_period')=='3')?'slected':''}}>March</option>	
										   <option value="4" {{(old('submission_period')=='4')?'slected':''}}>April</option>	
										   <option value="5" {{(old('submission_period')=='5')?'slected':''}}>May</option>	
										   <option value="6" {{(old('submission_period')=='36')?'slected':''}}>June</option>	
										   <option value="7" {{(old('submission_period')=='7')?'slected':''}}>July</option>	
										   <option value="8" {{(old('submission_period')=='8')?'slected':''}}>August</option>	
										   <option value="9" {{(old('submission_period')=='9')?'slected':''}}>September</option>	
										   <option value="10" {{(old('submission_period')=='10')?'slected':''}}>October</option>	
										   <option value="11" {{(old('submission_period')=='11')?'slected':''}}>November</option>	
										   <option value="12" {{(old('submission_period')=='12')?'slected':''}}>December</option>								 
										</select>
									</div>													
									@if ($errors->has('submission_period'))
									<span class="help-block">
										<strong>{{ $errors->first('submission_period') }}</strong>
									</span>
									@endif
								</div>
							</div>
							</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('total_capital') ? ' has-error' : '' }}">
						<label for="total_capital" class="col-sm-5 control-label">Total capital #</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="total_capital" placeholder="Total Capital" name="total_capital" value="{{old('total_capital')}}" >
							@if ($errors->has('total_capital'))
							<span class="help-block">
								<strong>{{ $errors->first('total_capital') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>
						<div class="col-md-6">				
					<div class="form-group {{ $errors->has('total_assest') ? ' has-error' : '' }}">
						<label for="total_assest" class="col-sm-5 control-label">Total Assets</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="total_assest" placeholder="Total Assets" name="total_assest" value="{{old('total_assest')}}" >
							@if ($errors->has('total_assest'))
							<span class="help-block">
								<strong>{{ $errors->first('total_assest') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('total_liability') ? ' has-error' : '' }}">
						<label for="total_liability" class="col-sm-5 control-label">Total Liability</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="total_liability" placeholder="Total Liability" name="total_liability" value="{{old('total_liability')}}" >
							@if ($errors->has('total_liability'))
							<span class="help-block">
								<strong>{{ $errors->first('total_liability') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('loan_advance') ? ' has-error' : '' }}">
						<label for="loan_advance" class="col-sm-5 control-label">Loans & advances</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="loan_advance" placeholder="Loans & advances" name="loan_advance" value="{{old('loan_advance')}}" >
							@if ($errors->has('loan_advance'))
							<span class="help-block">
								<strong>{{ $errors->first('loan_advance') }}</strong>
							</span>
							@endif
						</div>
					</div>
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('customer_deposits') ? ' has-error' : '' }}">
						<label for="customer_deposits" class="col-sm-5 control-label">Customer deposits</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="customer_deposits" placeholder="Customer deposits" name="customer_deposits" value="{{old('customer_deposits')}}" >
							@if ($errors->has('customer_deposits'))
							<span class="help-block">
								<strong>{{ $errors->first('customer_deposits') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('profit_before_tax') ? ' has-error' : '' }}">
						<label for="profit_before_tax" class="col-sm-5 control-label">Profit before tax</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="profit_before_tax" placeholder="Profit before tax" name="profit_before_tax" value="{{old('profit_before_tax')}}" >
							@if ($errors->has('profit_before_tax'))
							<span class="help-block">
								<strong>{{ $errors->first('profit_before_tax') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('return_average_assets') ? ' has-error' : '' }}">
						<label for="zipcode" class="col-sm-5 control-label">Return on average assets (in %)</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="return_average_assets" placeholder="Return on average assets" name="return_average_assets" value="{{old('return_average_assets')}}" >
							@if ($errors->has('return_average_assets'))
							<span class="help-block">
								<strong>{{ $errors->first('return_average_assets') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					</div>
						<div class="col-md-6">
					<div class="form-group {{ $errors->has('return_equity') ? ' has-error' : '' }}">
						<label for="equity" class="col-sm-5 control-label">Return on equity (%)</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="return_equity" placeholder="Return on equity" name="return_equity" value="{{old('return_equity')}}" >
							@if ($errors->has('return_equity'))
							<span class="help-block">
								<strong>{{ $errors->first('equity') }}</strong>
							</span>
							@endif
						</div>
					</div>						
					</div>
					</div>	
					<div class="row">
						<div class="col-md-6">
						<div class="form-group ">
							<label for="files" class="col-sm-5 control-label">Financial Report</label>
							<div class="col-sm-7">
								<input type="file" class="form-control" name="files[]" id="files[]" multiple />
								@if ($errors->has('files'))
								<span class="help-block">
									<strong>{{ $errors->first('files') }}</strong>
								</span>
								@endif	
								<em>You can select multiple files</em>						
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn bg-blue">Save Report</button>
						</div>
					</div>					
				</form>
			</div>
			<!-- /.box-body -->
		</div>	
			<!-- /.box-body -->
		</div>
	</div>	
</div>

@endsection

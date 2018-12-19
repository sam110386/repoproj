@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-7">
		<div class="box box-primary">	
			<div class="box-header with-border">
				<h3 class="box-title">Report Submission Information</h3>
			</div>	
			<div class="box-body box-profile">

				
				<p>&nbsp;</p>
				<form class="form-horizontal" action="{{ route('report-info-save') }}" method="POST" enctype="multipart/form-data"  >
					{{ csrf_field() }}
					<div class="form-group {{ $errors->has('report_category') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-4 control-label">Report Category</label>
						<div class="col-sm-8">							
							<select class="form-control m-bot15" name="report_category">								  
								   <option value="Monthly">Monthly</option>
								   <option value="Quaterly">Quaterly</option>
								   <option value="Audited">Audited</option>								 
								</select>
							@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('submission_period') ? ' has-error' : '' }}">
						<label for="submission_period" class="col-sm-4 control-label">Submission Period</label>
						<div class="col-sm-8">
							<div id="show1">
							<select class="form-control m-bot15" name="submission_period">								  
								   <option value="Jan">Jan</option>
								   <option value="Feb">Feb</option>
								   <option value="March">March</option>								 
								</select>
							</div>													
							@if ($errors->has('submission_period'))
							<span class="help-block">
								<strong>{{ $errors->first('submission_period') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('total_capital') ? ' has-error' : '' }}">
						<label for="total_capital" class="col-sm-4 control-label">Total capital #</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="total_assest" placeholder="Total Capital" name="total_capital" value="" >
							@if ($errors->has('total_capital'))
							<span class="help-block">
								<strong>{{ $errors->first('total_capital') }}</strong>
							</span>
							@endif
						</div>
					</div>					
					<div class="form-group {{ $errors->has('total_assest') ? ' has-error' : '' }}">
						<label for="total_assest" class="col-sm-4 control-label">Total Assets</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="total_assest" placeholder="Total Assets" name="total_assest" value="" >
							@if ($errors->has('total_assest'))
							<span class="help-block">
								<strong>{{ $errors->first('total_assest') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('total_liability') ? ' has-error' : '' }}">
						<label for="total_liability" class="col-sm-4 control-label">Total Liability</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="total_liability" placeholder="Total Liability" name="total_liability" value="" >
							@if ($errors->has('total_liability'))
							<span class="help-block">
								<strong>{{ $errors->first('total_liability') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('loan_advance') ? ' has-error' : '' }}">
						<label for="loan_advance" class="col-sm-4 control-label">Loans & advances</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="loan_advance" placeholder="Loans & advances" name="loan_advance" value="" >
							@if ($errors->has('loan_advance'))
							<span class="help-block">
								<strong>{{ $errors->first('loan_advance') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('customer_deposits') ? ' has-error' : '' }}">
						<label for="customer_deposits" class="col-sm-4 control-label">Customer deposits</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="customer_deposits" placeholder="Customer deposits" name="customer_deposits" value="" >
							@if ($errors->has('customer_deposits'))
							<span class="help-block">
								<strong>{{ $errors->first('customer_deposits') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					<div class="form-group {{ $errors->has('profit_before_tax') ? ' has-error' : '' }}">
						<label for="profit_before_tax" class="col-sm-4 control-label">Profit before tax</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="profit_before_tax" placeholder="Profit before tax" name="profit_before_tax" value="" >
							@if ($errors->has('profit_before_tax'))
							<span class="help-block">
								<strong>{{ $errors->first('profit_before_tax') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					<div class="form-group {{ $errors->has('return_average_assets') ? ' has-error' : '' }}">
						<label for="zipcode" class="col-sm-4 control-label">Return on average assets (in %)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="return_average_assets" placeholder="Return on average assets" name="return_average_assets" value="" >
							@if ($errors->has('return_average_assets'))
							<span class="help-block">
								<strong>{{ $errors->first('return_average_assets') }}</strong>
							</span>
							@endif
						</div>
					</div>	
					<div class="form-group {{ $errors->has('return_equity') ? ' has-error' : '' }}">
						<label for="equity" class="col-sm-4 control-label">Return on equity (%)</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="return_equity" placeholder="Return on equity" name="return_equity" value="" >
							@if ($errors->has('return_equity'))
							<span class="help-block">
								<strong>{{ $errors->first('equity') }}</strong>
							</span>
							@endif
						</div>
					</div>						
					
					
					<div class="form-group ">
						<label for="files" class="col-sm-4 control-label">Document</label>
						<div class="col-sm-8">
							
							<input type="file" class="form-control" name="files[]" id="files[]" multiple />
							
							@if ($errors->has('files'))
							<span class="help-block">
								<strong>{{ $errors->first('files') }}</strong>
							</span>
							@endif							
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

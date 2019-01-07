@if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">	
			<div class="box-header with-border">
				<h3 class="box-title">Update Report Submission Information</h3>
			</div>	
			<div class="box-body box-profile">
				
				<p>&nbsp;</p>
				<form class="form-horizontal" action="/admin/reports/update/{{$report->id}}" method="POST" enctype="multipart/form-data"  >
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">		
							<div class="form-group {{ $errors->has('report_category') ? ' has-error' : '' }}">
								<label for="name" class="col-sm-5 control-label">Report Category</label>
								<div class="col-sm-7">							
									<select class="form-control m-bot15" id="report_category" name="report_category">	
										<option value="Monthly" {{$report->report_category=='Monthly'?'selected':''}}>Monthly</option>
										<option value="Quaterly" {{$report->report_category=='Quaterly'?'selected':''}}>Quaterly</option>
										<option value="Audited" {{$report->report_category=='Audited'?'selected':''}}>Audited</option>								 
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
										<select class="form-control m-bot15" id="submission_period" name="submission_period">
											<option value="">Select</option>
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
							<div class="form-group {{ $errors->has('report_year') ? ' has-error' : '' }}">
								<label for="report_year" class="col-sm-5 control-label">Submission Year</label>
								<div class="col-sm-7">
									<div id="show1">
										<select class="form-control m-bot15" id="report_year" name="report_year">
											<option value="">Select</option>
										</select>
									</div>													
									@if ($errors->has('report_year'))
									<span class="help-block">
										<strong>{{ $errors->first('report_year') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('total_capital') ? ' has-error' : '' }}">
								<label for="total_capital" class="col-sm-5 control-label">Total capital #</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" id="total_capital" placeholder="Total Capital" name="total_capital" value="{{$report->total_capital}}" >
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
									<input type="text" class="form-control" id="total_assest" placeholder="Total Assets" name="total_assest" value="{{$report->total_assest}}" >
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
									<input type="text" class="form-control" id="total_liability" placeholder="Total Liability" name="total_liability" value="{{$report->total_liability}}" >
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
									<input type="text" class="form-control" id="loan_advance" placeholder="Loans & advances" name="loan_advance" value="{{$report->loan_advance}}" >
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
									<input type="text" class="form-control" id="customer_deposits" placeholder="Customer deposits" name="customer_deposits" value="{{$report->customer_deposits}}" >
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
									<input type="text" class="form-control" id="profit_before_tax" placeholder="Profit before tax" name="profit_before_tax" value="{{$report->profit_before_tax}}" >
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
									<input type="text" class="form-control" id="return_average_assets" placeholder="Return on average assets" name="return_average_assets" value="{{$report->return_average_assets}}" >
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
									<input type="text" class="form-control" id="return_equity" placeholder="Return on equity" name="return_equity" value="{{$report->return_equity}}" >
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
					</div>
					<div class="row">
						<div class="col-sm-offset-3 col-sm-2">	
							<div class="form-group">

								<a href="/admin/reports" class=" btn bg-black" >
									<i class="fa fa-arrow-left"></i>
									<span>Back</span>
								</a>
							</div>
						</div>
						<div class="col-sm-offset-3 col-sm-2">
							<div class="form-group">
								
								<button type="submit" class="btn bg-blue">Save Report <i class="fa fa-arrow-right"></i></button>

							</div>
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
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#report_category").change(function() {
		    var el = $(this) ;    
		    if(el.val() === "Monthly" ) {
		    	$('#submission_period').attr('disabled',false);
				$('#submission_period').find('option:not(:first)').remove();
				$("#submission_period").append("<option value='1'>January</option>");
				$("#submission_period").append("<option value='2'>February</option>");
				$("#submission_period").append("<option value='3'>March</option>");
				$("#submission_period").append("<option value='4'>April</option>");			
				$("#submission_period").append("<option value='5'>May</option>");
				$("#submission_period").append("<option value='6'>June</option>");
				$("#submission_period").append("<option value='7'>July</option>");
				$("#submission_period").append("<option value='8'>Agust</option>");		
				$("#submission_period").append("<option value='9'>September</option>");
				$("#submission_period").append("<option value='10'>October</option>");
				$("#submission_period").append("<option value='11'>November</option>");
				$("#submission_period").append("<option value='12'>December</option>");	
		    }
		    else if(el.val() === "Quaterly" ) {
		    	$('#submission_period').attr('disabled',false);
				$('#submission_period').find('option:not(:first)').remove();
		        $("#submission_period").append("<option value='1'>Q1</option>");
		        $("#submission_period").append("<option value='2'>Q2</option>");
		        $("#submission_period").append("<option value='3'>Q3</option>");
		        $("#submission_period").append("<option value='4'>Q4</option>");
		    }
		    else if(el.val() === "Audited" ) {
		    	$('#submission_period').attr('disabled',true);
		        $('#submission_period').find('option:not(:first)').remove();
		        var today = new Date();
		        var years=today.getFullYear();
		        for(var i=(years-20);i<=years;i++){
		            $("#submission_period").append("<option value='"+i+"'>"+i+"</option>");
		        }
		        
		    }

	  
	  });
	var today = new Date();
    var years=today.getFullYear();
    for(var i=(years-20);i<=years;i++){
        $("#report_year").append("<option value='"+i+"'>"+i+"</option>");
    }
	
		$("#report_category").val("{{$report->report_category}}").trigger('change');
		setTimeout(function(){
			if($("#report_category").val()=='Monthly'){
				$('#submission_period').find('option[value="{{$report->submission_period}}"]').prop('selected', 'selected');/*val("{{$report->submission_period}}").change();*/
			}else if($("#report_category").val()=='Quaterly'){
				$('#submission_period').find('option[value="{{$report->submission_quater}}"]').prop('selected', 'selected');/*.val("{{$report->submission_quater}}").change();*/
			}else if($("#report_category").val()=='Audited'){
				$('#submission_period').find('option[value="{{$report->report_year}}"]').prop('selected', 'selected');/*.val("{{$report->report_year}}").change();*/
			}
			$("#report_year").val("{{$report->report_year}}");
		},500);
	});
</script>


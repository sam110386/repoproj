@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">	
			<div class="box-header with-border">
				<h3 class="box-title">Report Information</h3>
			</div>	
			<div class="box-body box-profile">

				
				<p>&nbsp;</p>
				<form class="form-horizontal" action="{{ route('report-info-save') }}" method="POST" enctype="multipart/form-data"  >
					{{ csrf_field() }}
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Report Category</label>
						<div class="col-sm-8">							
							{{$report->report_category}}
						</div>
					</div>
					<div class="form-group ">
						<label for="submission_period" class="col-sm-2 control-label">Submission Period</label>
						<div class="col-sm-8">
							{{$report->submission_period}}
						</div>
					</div>
					<div class="form-group ">
						<label for="total_capital" class="col-sm-2 control-label">Total capital #</label>
						<div class="col-sm-8">
							{{$report->total_assest}}
						</div>
					</div>					
					<div class="form-group ">
						<label for="total_assest" class="col-sm-2 control-label">Total Assets</label>
						<div class="col-sm-8">
							{{$report->total_assest}}
						</div>
					</div>
					<div class="form-group ">
						<label for="total_liability" class="col-sm-2 control-label">Total Liability</label>
						<div class="col-sm-8">
							{{$report->total_liability}}
						</div>
					</div>
					<div class="form-group ">
						<label for="loan_advance" class="col-sm-2 control-label">Loans & advances</label>
						<div class="col-sm-8">
							{{$report->loan_advance}}
						</div>
					</div>
					<div class="form-group ">
						<label for="customer_deposits" class="col-sm-2 control-label">Customer deposits</label>
						<div class="col-sm-8">
							{{$report->customer_deposits}}
						</div>
					</div>	
					<div class="form-group ">
						<label for="profit_before_tax" class="col-sm-2 control-label">Profit before tax</label>
						<div class="col-sm-8">
							{{$report->profit_before_tax}}
						</div>
					</div>	
					<div class="form-group ">
						<label for="zipcode" class="col-sm-2 control-label">Return on average assets (in %)</label>
						<div class="col-sm-8">
							{{$report->return_average_assets}}
						</div>
					</div>	
					<div class="form-group ">
						<label for="equity" class="col-sm-2 control-label">Return on equity (%)</label>
						<div class="col-sm-8">
							{{$report->return_equity}}
						</div>
					</div>						
					
					
					<div class="form-group ">
						<label for="files" class="col-sm-2 control-label">Financial Report</label>
						<div class="col-sm-8">
							@if(!empty($reportfiles))
								<ul>
									@foreach($reportfiles as $reportfile)
										<li class="trigger" rel-file="{{$reportfile->filename}}">{{$reportfile->filename}}</li>
									@endforeach
								</ul>
							@endif
												
						</div>
					
					
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<a href="{{ route('report') }}" class=" btn bg-blue" >
								 <span>Back</span>
							</a>
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
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       	<iframe src"" width="100%" height="100%"></iframe>
      </div>
      
    </div>

  </div>
</div>

@endsection
<script  type="text/javascript">
  window.onload = function () {
    jQuery('.trigger').click(function(){
    	var filename=jQuery(this).attr('rel-file');
    	jQuery("#myModal .modal-body").find('iframe').attr('src','/uploads/user/doc/'+filename);
      	jQuery("#myModal").modal('show');
    }); 
  };                  
</script>

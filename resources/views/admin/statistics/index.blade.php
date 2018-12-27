<script src="{{ asset('bower_components/chart.js/Chart.min.js') }}"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <form id="statisticform" name="statisticform">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom:10px; ">
                                <div class="form-group">
                                    <label for="name" class="col-sm-1 control-label">Institute</label>
                                    <div class="col-sm-7">  
                                        <select class="form-control m-bot15" id="instiute_id" name="instiute_id[]" multiple="true"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-sm-5 control-label">Report Category</label>
                                    <div class="col-sm-7">  
                                        <select class="form-control m-bot15" id="report_category" name="report_category"> 
                                            <option value="Monthly" >Monthly</option>
                                            <option value="Quaterly" >Quaterly</option>
                                            <option value="Audited" >Audited</option>                               
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-sm-5 control-label">Period</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" id="submission_period" name="submission_period">   
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-sm-5 control-label">Entity Type</label>
                                    <div class="col-sm-7">
                                        <select class="form-control m-bot15" id="entity_type" name="entity_type"> 
                                            <option value="total_capital" >Total Capital</option>  
                                            <option value="total_asset" >Total Assets</option>
                                            <option value="total_liability" >Total Liability</option>
                                            <option value="loan_advance" >Loans & advances</option>
                                            <option value="customer_deposits" >Customer deposits</option>
                                            <option value="profit_before_tax" >Profit before tax</option>
                                            <option value="return_average_assets" >Return on average assets</option>
                                            <option value="return_equity" >Return on equity</option>
                                            <option value="clients" >Number of Client</option>
                                            <option value="staff" >Number of Staff</option>
                                            <option value="board_members" >Board members</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button name="refresh" id="refresh" type="button" class="btn btn-success" onclick="refreshchart()">Refresh</button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="myChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#report_category").change(function() {
            var el = $(this) ;    
            if(el.val() === "Monthly" ) {
                $('#submission_period').find('option').remove();
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
                $('#submission_period').find('option').remove();   
                $("#submission_period").append("<option value='1'>Q1</option>");
                $("#submission_period").append("<option value='2'>Q2</option>");
                $("#submission_period").append("<option value='3'>Q3</option>");
                $("#submission_period").append("<option value='4'>Q4</option>");
            }
            else if(el.val() === "Audited" ) {
                $('#submission_period').find('option').remove();
                var today = new Date();
                var years=today.getFullYear();
                for(var i=(years-20);i<=years;i++){
                    $("#submission_period").append("<option value='"+i+"'>"+i+"</option>");
                }
                
            }

        });
        $("#report_category").val("Monthly").trigger('change');
        setTimeout(function(){
            var dt=new Date();
            $("#submission_period").val(dt.getMonth()+1);
        },200);
        
    });


</script>
<script type="text/javascript">
    //$(document).off('change', "#instiute_id");
    $(document).ready(function () {
        $("#instiute_id").select2({
            placeholder: "Select Institutes ",
            minimumInputLength: 1,
              ajax: {
                url: "/admin/statistics/instituteautocomplete",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                  return {q: params.term,page: params.page};
                },
                processResults: function (data, params) {
                  params.page = params.page || 1;
                  return {
                    results: $.map(data.data, function (d) {return {id: d.id,text:d.name}}),
                    pagination: {more: data.next_page_url}
                  };
                },
                cache: true
              },
             escapeMarkup: function (markup) {return markup;}
            });
    });
    
</script>
<script>
    
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var gradientStroke = 'rgba(255,0,0, 0.6)',
    gradientFill = 'rgba(0,255,0, 0.4)';
    //var Institutes=[@php echo implode(',',$Institutes) @endphp]
    var Institutes=@php $label=array_values($Institutes); echo json_encode($label);@endphp;
    var plotdata=@php $plotdata=array_map(function($var){return $var->total_capital;},$reprts->toArray()); echo json_encode($plotdata);@endphp;
    var barChartData = {

        labels: Institutes,//["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: 'Total Capital',
            data: plotdata,
            borderColor: gradientStroke,
            pointBorderColor: gradientStroke,
             pointBackgroundColor: gradientStroke,
             pointHoverBackgroundColor: gradientStroke,
             pointHoverBorderColor: gradientStroke,
             pointBorderWidth: 5,
             pointHoverRadius: 5,
             pointHoverBorderWidth: 1,
             pointRadius: 3,
             fill: true,
             backgroundColor: gradientFill,
            borderWidth: 1
        }]
    }
    $(function () {
        var ctx = document.getElementById("myChart").getContext("2d");
        var myBarChart;

        // Global Options:
        Chart.defaults.global.defaultFontColor = 'grey';
        Chart.defaults.global.defaultFontSize = 16;
        window.myBarChart = new Chart(ctx).Bar(barChartData, {
            responsive : true
        });
        /*var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: [{x:'2016-12-25', y:20}, {x:'2016-12-26', y:10}],
            options: []
        });*/
    });
    function addData(label, dta,myBarChart) {
        window.myBarChart.data.labels=label;
        window.myBarChart.data.datasets[0].data = dta;
        window.myBarChart.update();
 }
</script>
<script type="text/javascript">
    function refreshchart(){
        var formdata=$("#statisticform").serialize();
        alert(JSON.stringify(formdata));
        $.post('/admin/statistics/loadchartdata',formdata,function(reponse,myBarChart){
            var label=[],dta=[];
            $.each(reponse.institutes,function(i,v){label.push(v)});
            $.each(reponse.data,function(i,v){dta.push(v.total)});
            alert(JSON.stringify(label));
            alert(JSON.stringify(dta));
            //addData(label, dta,myBarChart);
            window.myBarChart.data.labels=label;
            window.myBarChart.data.datasets[0].data = dta;
            window.myBarChart.update();
        },'json');
    }
</script>
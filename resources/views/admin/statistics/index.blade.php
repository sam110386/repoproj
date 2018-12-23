<script src="{{ asset('bower_components/chart.js/Chart.min.js') }}"></script>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <form id="statisticform" name="statisticform">
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
                                        <option value="" >Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="col-sm-5 control-label">Entity Type</label>
                                <div class="col-sm-7">
                                    <select class="form-control m-bot15" id="entity_type" name="entity_type">    
                                        <option value="total_assets" >Total assets</option>
                                        <option value="total_liability" >Total Liability</option>
                                        <option value="loan_advance" >Loans & advances</option>
                                        <option value="customer_deposits" >Customer deposits</option>
                                        <option value="profit_before_tax" >Profit before tax</option>
                                        <option value="return_average_assets" >Return on average assets</option>
                                        <option value="return_equity" >Return on equity</option>
                                        <option value="clints" >Number of Client</option>
                                        <option value="staff" >Number of Staff</option>
                                        <option value="board_members" >Board members</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"><button name="refresh" id="refresh" class="btn btn-success" onclick="refreshchart()">Refresh</button></div>
                    </form>
                    </div>
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
                $('#submission_period').find('option:not(:first)').remove();
                $("#submission_period").append("<option value='1'>Q1</option>");
                $("#submission_period").append("<option value='2'>Q2</option>");
                $("#submission_period").append("<option value='3'>Q3</option>");
                $("#submission_period").append("<option value='4'>Q4</option>");
            }
            else if(el.val() === "Audited" ) {
                $('#submission_period').find('option:not(:first)').remove();
                var today = new Date();
                var years=today.getFullYear();
                for(var i=(years-20);i<=years;i++){
                    $("#submission_period").append("<option value='"+i+"'>"+i+"</option>");
                }
                
            }

        });
        $("#report_category").val("Monthly").trigger('change');
    });

    function refreshchart(){
        var formdata=$("#statisticform").serialize();
    }
</script>
<script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    //var Institutes=[@php echo implode(',',$Institutes) @endphp]
    var Institutes=@php $label=array_values($Institutes); echo json_encode($label);@endphp;
    var plotdata=@php $plotdata=array_map(function($var){return $var->total_capital;},$reprts->toArray()); echo json_encode($plotdata);@endphp;
    var barChartData = {

        labels: Institutes,//["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: 'Total Capital',
            data: plotdata,
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
            ],
            borderWidth: 1
        }]
    }
    $(function () {
        var ctx = document.getElementById("myChart").getContext("2d");
        window.chart = new Chart(ctx).Bar(barChartData, {
            responsive : true
        });
        /*var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: [{x:'2016-12-25', y:20}, {x:'2016-12-26', y:10}],
            options: []
        });*/
    });
    function addData(chart, data, datasetIndex) {
       window.chart.data.datasets[datasetIndex].data = data;
       window.chart.update();
    }
</script>
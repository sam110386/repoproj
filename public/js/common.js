$(document).ready(function(){
    var months=[];
    months['1']='January';
    months['2']='February';
    months['3']='March';
    months['4']='April';
    months['5']='May';
    months['6']='June';
    months['7']='July';
    months['8']='Agust';
    months['9']='September';
    months['10']='October';
    months['11']='November';
    months['12']='December';
	$('.alert-dismissible').delay(5000).slideUp(1000);

	$("#report_category").change(function() {
    var el = $(this) ;    
    if(el.val() === "Monthly" ) {
        $('#submission_period').attr('disabled',false);
		/*$('#submission_period').find('option:not(:first)').remove();
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
		$("#submission_period").append("<option value='12'>December</option>");*/
    }
    else if(el.val() === "Quaterly" ) {
        $('#submission_period').attr('disabled',false);
		/*$('#submission_period').find('option:not(:first)').remove();
        $("#submission_period").append("<option value='1'>Q1</option>");
        $("#submission_period").append("<option value='2'>Q2</option>");
        $("#submission_period").append("<option value='3'>Q3</option>");
        $("#submission_period").append("<option value='4'>Q4</option>");*/
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

    $("#report_year").change(function() {
        var el = $("#report_category");
        var selectedyear=$(this).val();
        var today = new Date();
        var years=today.getFullYear();
        if(el.val() === "Monthly" ) {
            $('#submission_period').attr('disabled',false);
            $('#submission_period').find('option:not(:first)').remove();
            if(selectedyear<years){
                for(var i=1;i<=12;i++){
                    $("#submission_period").append("<option value='"+i+"'>"+months[i]+"</option>");
                }
            }else if(selectedyear==years){
                for(var i=1;i<=today.getMonth()+1;i++){
                    $("#submission_period").append("<option value='"+i+"'>"+months[i]+"</option>");
                }
            }
        }
        else if(el.val() === "Quaterly" ) {
            $('#submission_period').attr('disabled',false);
            $('#submission_period').find('option:not(:first)').remove();
            var quarter=4;
            if(selectedyear==years){
                if(today.getMonth()<=2){
                    quarter=1;
                }else if(today.getMonth()>2 && today.getMonth()<=5){
                    quarter=2;
                }else if(today.getMonth()>5 && today.getMonth()<=8){
                    quarter=3;
                }
            }
            for(var i=1;i<=quarter;i++){
                $("#submission_period").append("<option value='"+i+"'>Q"+i+"</option>");
            }
        }
    });
});

/**report listing page***/
$(document).ready(function(){
    $('#reportsearch .input-daterange').datepicker({});
    var today = new Date();
        var years=today.getFullYear();
        for(var i=(years-20);i<=years;i++){
            $("#report_year").append("<option value='"+i+"'>"+i+"</option>");
        }
/*$('#created_at_start').datetimepicker({format: 'MM/DD/YYYY',minDate:moment()});
        $('#created_at_end').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'MM/DD/YYYY'
        });
        $("#created_at_start").on("dp.change", function (e) {
            $('#created_at_end').data("DateTimePicker").minDate(e.date);
        });
        $("#created_at_end").on("dp.change", function (e) {
            $('#created_at_start').data("DateTimePicker").maxDate(e.date);
        });*/
    });
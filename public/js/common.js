$(document).ready(function(){
	$('.alert-dismissible').delay(5000).slideUp(1000);

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
})

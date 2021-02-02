//for organization filter we will get cohortid 

$("#id_org_id").click(function(){

	$.get(M.cfg.wwwroot+'/local/access_level_org_report/cohort.php?id='+this.value,function(data,status){
		$("#id_cohort_id").empty();
		var list = '';
		list += '<option value="'+'select-all'+'">'+'Select All'+'</option>';
		for(var i in data){
			
			list += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
		}

		$("#id_cohort_id").html(list);
	});
});
//coursecat
$("#id_course_cat").click(function(){
	var e = document.getElementById("id_cohort_id");
	var strCohort = e.options[e.selectedIndex].value;

	$.get(M.cfg.wwwroot+'/local/access_level_org_report/coursefilter.php?id='+this.value+'&cid='+strCohort,function(data1,status){
		$("#id_courseid").empty();
		var list1 = '';
		list += '<option value="'+'select-all'+'">'+'Select All'+'</option>';
		for(var i in data1){	
			list1 += '<option value="'+data1[i].id+'">'+data1[i].fullname+'</option>';
		}
		$("#id_courseid").html(list1);
	});
});
//course 
$("#id_cohort_id").click(function(){
	var e = document.getElementById("id_org_id");
	var strOrg = e.options[e.selectedIndex].value;
	
	var selectedValue = [];
	$.each($("#id_cohort_id option:selected"), function(){            
		selectedValue.push($(this).val());

	});
        //alert("You have selected value is - " + selectedValue.join(", "));
        var val = selectedValue.join(",");
        //alert(val);
        $.get(M.cfg.wwwroot+'/local/access_level_org_report/course.php?id='+val+'&orgid='+strOrg,function(data,status){

        	$("#id_courseid").empty();
        	var list = '';
        	list += '<option value="'+'select-all'+'">'+'Select All'+'</option>';
        	for(var i in data){
        		list += '<option value="'+data[i].id+'">'+data[i].fullname+'</option>';
        	}
        	$("#id_courseid").html(list);
        });
    });

/*$('#id_courseid').change() function() {
	
    if (this.value == 'select-all') {
        $('option').prop('disabled', true);
    } else {
        $('option').prop('disabled', false);
    }
});*/
/*$("#id_cohort_id").click(function(){
	var e = document.getElementById("id_cohort_id");
	var strOrg = e.options[e.selectedIndex].value;
	if(strOrg=='select-all'){
		alert('hi');
	}else{
		alert('hello');
	}
});*/

/*$("#id_cohort_id").click(function(){
var op = document.getElementById("id_cohort_id").getElementsByTagName("option");
for (var i = 0; i < op.length; i++) {
  // lowercase comparison for case-insensitivity
  (op[i].value.toLowerCase() == "select-all") 
    ? op[i].disabled = true 
    : op[i].disabled = false ;
}
});*/

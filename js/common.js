//validate form 
$(document).ready(function(){
		//validating admin and student change password				   
		$( "#changePwdForm" ).validate({
			rules: {
			currentPassword: {
				required: true,
				minlength: 6,
				maxlength: 20
			},	
			newPassword: {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			confirmPassword: {
				required: true,
				minlength: 6,
				maxlength: 20
			}
			}
		});
		//validating admin and student login
		$( ".login" ).validate({
			rules: {
			txtUName: {
				required: true,
				minlength: 5,
				maxlength: 20
			},	
			txtPwd: {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			}
		});
		$("#frmSubjectGroup").validate();
		$("#session_upload").validate();		
});
//Function to validate the email ID
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}
function stripslashes(str) {
 return str.replace(/\\'/g,'\'').replace(/\"/g,'"').replace(/\\\\/g,'\\').replace(/\\0/g,'\0');
}
$(function() {
	$("#fromSPS").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toSPS").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#toSPS").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromSPS").datepicker("option", "maxDate", selectedDate);
		}
	});
});
/* To open pop up for current semester subject detail of a student */
$(document).ready(function(){
	$('.basic').click(function (e) {
		var subject_link_id=$(this).attr("id");
		var sub_sees_id='#sub_sees_detail_'+subject_link_id;
		$(sub_sees_id).modal();
		return false;
	});
});
//getting subjects for career 
$(document).ready(function() {
  $('#career').on('change', function(){
	var selected=$("#career option:selected").map(function(){ return this.value }).get().join(",");
	var subject="subject";
	ajaxCommonSubjects(selected,subject);
  });
});
$(document).ready(function() {
  $('#subject').on('change', function(){
	var selected=$("#subject option:selected").map(function(){ return this.value }).get().join(",");
	var subject_requistie="subject_requistie";
	var career=$("#career option:selected").val();
	ajaxCommonSubjectsRequistie(selected,subject_requistie,career);
  });
});
//ajax function for fetching subjects
function ajaxCommonSubjects(selectedVal,slctID){
	var slctID = '#'+slctID;
$.ajax({
        url: "../ajax_common.php",
        type: "POST",
        data: {
			'course': selectedVal,
			'codeBlock': 'getSubjects'
            },
        success: function(data) {
			 $(slctID).html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });	
}
function ajaxCommonSubjectsRequistie(selectedVal,slctID,career){
	var slctID = '#'+slctID;
$.ajax({
        url: "../ajax_common.php",
        type: "POST",
        data: {
			'id':selectedVal,
			'course': career,
			'codeBlock': 'getSubjects'
            },
        success: function(data) {
			 $(slctID).html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });	
}
//ajax delete the configuration
function deleteConf($id){
	if($id==""){
		alert("Please select a configuration range to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the configuration?")) {
	    $.ajax({
                type: "POST",
                url: "../ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_conf',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected configuration, Please try again.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
function updatePrerequistie(){
		max = $("#total_rows").val();
		for ( var i = 1; i <= max; i++ ){
			max_stu = $("#max_students"+i).val();
			if(!$.isNumeric(max_stu))
			{
				alert("Please select a numeric value for maximum students of row-"+i);
				return false;
			}
			min_stu = $("#min_students"+i).val();
			if(!$.isNumeric(min_stu))
			{
				alert("Please select a numeric value for minimum students of row-"+i);
				return false;
			}
		}
	    var Id = new Array();
		$.each($("input[name='row_id[]']"), function() {
  			Id.push($(this).val());
    	});
		var maxStudents = new Array();
		$.each($("input[name='max_students[]']"), function() {
  			maxStudents.push($(this).val());
    	});
		var minStudents = new Array();
		$.each($("input[name='min_students[]']"), function() {
  			minStudents.push($(this).val());
    	});
		if(confirm("Are you sure ,you want to change the values?")){
			$.ajax({
				   type: "POST",
				   url: "../ajax_common.php",
				   data: {
							'Id':Id,
							'maxStudents': maxStudents,
							'minStudents': minStudents,
							'codeBlock': 'updatePrerequistie'
						 },
						success: function($succ){
							if($succ==1){
								window.location.href = 'prerequisite_view.php?msg=1';
							}else if($succ==0){
								 alert('Data is not corrected');	
							}
						}
				});
		}
		return false;
}
//active and deactive pre requistie
function setStatus($id){
	if($id==""){
		alert("Please select a row to change the status");
		return false;
	}else {
	    $.ajax({
                type: "POST",
                url: "../ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'set_requistie_status',
				},
                success: function($succ){
					var imageId='#status-user'+$id;
					if($succ==1){
						//$(imageId).css('background-image','url(./images/bar-circle.gif)');
                       	$(imageId).attr({src: '../images/status-active.png'});
						$(imageId).attr({title: 'Desable'});
					}else{
						$(imageId).attr({src: '../images/status-deactive.png'});
						$(imageId).attr({title: 'Enable'});
					}
                }
        });
    }
 }
 /* To open pop up for other available subject groups 
$(document).ready(function(){
	$('.basic-sub-grp').click(function (e) {
		var subject_grp_link_id=$(this).attr("id");
		var sub_grp_id='#sub_grp_detail_'+subject_grp_link_id;
		$(sub_grp_id).modal();
		return false;
	});
});*/
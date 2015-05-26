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
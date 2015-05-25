/*
 * SimpleModal Basic Modal Dialog
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();
	// Load dialog on click
	$('.basic').click(function (e) {
		var subject_link_id=$(this).attr("id");
		var sub_sees_id='#sub_sees_detail_'+subject_link_id;
		$(sub_sees_id).modal();
		return false;
	});
});
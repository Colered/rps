<?php
/* $Id: day.php,v 1.78.2.4 2008/03/31 21:03:41 umcesrjones Exp $ */
include_once 'includes/init.php';
include_once '../header.php';

//check UAC
$subRuleId=(isset($_GET['subRuleId'])? $_GET['subRuleId']:'');
$subGrpId=(isset($_GET['subGrpId'])? $_GET['subGrpId']:'');
$subject_filter_id=(isset($_GET['subject_id']))?$_GET['subject_id']:'';

if ( ! access_can_access_function ( ACCESS_DAY ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();
  
load_user_layers ( $user != $login && $is_nonuser_admin ? $user : '' );

load_user_categories ();

$wday = strftime ( '%w', mktime ( 0, 0, 0, $thismonth, $thisday, $thisyear ) );
$now = mktime ( 23, 59, 59, $thismonth, $thisday, $thisyear );
$nowYmd = date ( 'Ymd', $now );

$next = mktime ( 0, 0, 0, $thismonth, $thisday + 1, $thisyear );
$nextday = date ( 'd', $next );
$nextmonth = date ( 'm', $next );
$nextyear = date ( 'Y', $next );
$nextYmd = date ( 'Ymd', $next );

$prev = mktime ( 0, 0, 0, $thismonth, $thisday - 1, $thisyear );
$prevday = date ( 'd', $prev );
$prevmonth = date ( 'm', $prev );
$prevyear = date ( 'Y', $prev );
$prevYmd = date ( 'Ymd', $prev );

if ( empty ( $TIME_SLOTS ) )
  $TIME_SLOTS = 24;

$boldDays = ( $BOLD_DAYS_IN_YEAR == 'Y' );

$startdate = mktime ( 0, 0, 0, $thismonth, 0, $thisyear );
$enddate = mktime ( 23, 59, 59, $thismonth + 1, 0, $thisyear );

$printerStr = $unapprovedStr = '';

/* Pre-Load the repeated events for quckier access */
/*$repeated_events = read_repeated_events ( empty ( $user )
  ? $login : $user, $startdate, $enddate, $cat_id );*/

/* Pre-load the non-repeating events for quicker access */
$events=$sub_data=array();
if($subRuleId !="" && $subGrpId!=''){
	$obj_fedena=new Fedena();
	$obj_ras=new RAS();
	$student_subjects=$obj_fedena->getCurrentStuSemSub();
	$course_name = $obj_fedena->getCourseName();
	$all_subjects = $obj_fedena->getAllSubjectsDetails();
	foreach($all_subjects as $subgrp_id=>$subgrp_detail ){
		if($subgrp_id==$subGrpId){
			$sub_cnt =  count($subgrp_detail['subjects']);
			if($sub_cnt>0){
				foreach($subgrp_detail['subjects'] as $sub_code=>$sub_detail){
					if(!$obj_fedena->search_array($sub_detail['name'],$student_subjects)){
						$sub_ids=$obj_ras->ruleAllSubject($subRuleId,$sub_detail['name']);
						$sub_data = read_events_student_sub_next_sem ( ( ! empty ( $user ) && strlen ( $user ) ) ? $user : $login, $startdate, $enddate, $cat_id ,$sub_ids[0],$subRuleId);
						$events=array_merge($events,$sub_data);	
					}
				}
		  	}	
		}
	}
}elseif($subject_filter_id!=''){
  $events = read_events_student_sub_next_sem ( ( ! empty ( $user ) && strlen ( $user ) ) ? $user : $login, $startdate, $enddate, $cat_id ,$subject_filter_id);
}
//$events = read_events_student_sub_next_sem ( ( ! empty ( $user ) && strlen ( $user ) ) ? $user : $login, $startdate, $enddate, $cat_id ,$subject_id);
if ( empty ( $DISPLAY_TASKS_IN_GRID ) || $DISPLAY_TASKS_IN_GRID == 'Y' )
  /* Pre-load tasks for quicker access */
  $tasks = read_tasks ( ! empty ( $user ) && strlen ( $user ) && $is_assistant
    ? $user : $login, $now, $cat_id );

$smallTasks = ( $DISPLAY_TASKS == 'Y' ? '<div id="minitask">
           ' . display_small_tasks ( $cat_id ) . '
          </div>' : '' );
$dayStr = print_day_at_a_glance ( $nowYmd, ( empty ( $user )
    ? $login : $user ), $can_add );
$navStr = display_navigation ( 'day' );
$smallMonthStr = display_small_month ( $thismonth, $thisyear, true );
if ( empty ( $friendly ) ) {
  $unapprovedStr = display_unapproved_events (
    $is_assistant || $is_nonuser_admin ? $user : $login );
  $printerStr = generate_printer_friendly ( 'day.php' );
}
$eventinfo = ( empty ( $eventinfo ) ? '' : $eventinfo );
$trailerStr = print_trailer ();
print_header ( array ( 'js/popups.php/true' ), generate_refresh_meta (), '',
  false, false, false, false );

echo <<<EOT

    <table width="100%" cellpadding="1">
      <tr>
        <td width="80%">
          {$navStr}
        </td>
        <td class="aligntop" rowspan="2">
          <!-- START MINICAL -->
          <div class="minicalcontainer">
            {$smallMonthStr}
          </div>
          {$smallTasks}
        </td>
      </tr>
      <tr>
        <td>
          {$dayStr}
        </td>
      </tr>
    </table>
    {$eventinfo}
    {$unapprovedStr}
    {$printerStr}
    {$trailerStr}
EOT;

include_once '../footer.php';
?>

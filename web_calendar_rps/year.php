<?php
/* $Id: year.php,v 1.67.2.4 2008/03/31 21:03:41 umcesrjones Exp $ */
include_once 'includes/init.php';
include_once '../header.php';
send_no_cache_header ();

//check UAC
$subRuleId=(isset($_GET['subRuleId'])? $_GET['subRuleId']:'');
$subGrpId=(isset($_GET['subGrpId'])? $_GET['subGrpId']:'');
$subject_filter_id=(isset($_GET['subject_id']))?$_GET['subject_id']:'';
if ( ! access_can_access_function ( ACCESS_YEAR ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();
      
if ( ( $user != $login ) && $is_nonuser_admin )
  load_user_layers ( $user );
else
  load_user_layers ();

load_user_categories ();

if ( empty ( $year ) )
  $year = date ( 'Y' );

$thisyear = $year;
if ( $year != date ( 'Y' ) )
  $thismonth = 1;

// Set up global $today value for highlighting current date.
set_today ( $date );

$nextYear = $year + 1;
$prevYear = $year - ( $year > '1903' ? 1 : 0 );

$startdate = mktime ( 0, 0, 0, 1, 1, $year );
$enddate = mktime ( 23, 59, 59, 12, 31, $year );

if ( $ALLOW_VIEW_OTHER != 'Y' && ! $is_admin )
  $user = '';

/*$subject_filter_id=(isset($_REQUEST['subject_id']))?$_REQUEST['subject_id']:'';
if($subject_filter_id!=""){
	$subject_id=$subject_filter_id;
}else{
	$subject_id='162';
}*/
$boldDays = false;
$catSelectStr = '';
if ( ! empty ( $BOLD_DAYS_IN_YEAR ) && $BOLD_DAYS_IN_YEAR == 'Y' ) {
  /* Pre-Load the repeated events for quckier access */
  /*$repeated_events = read_repeated_events (
    ( ! empty ( $user ) && strlen ( $user ) ? $user : $login ),
    $startdate, $enddate, $cat_id );*/

  /* Pre-load the non-repeating events for quicker access */
 // $events = read_events (( ! empty ( $user ) && strlen ( $user ) ? $user : $login ),$startdate, $enddate, $cat_id );
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
  $boldDays = true;
  $navStr = display_navigation ( 'year' );
 // $catSelectStr = print_category_menu ( 'year', $thisyear, $cat_id );
}

// Disable $DISPLAY_ALL_DAYS_IN_MONTH.
$DISPLAY_ALL_DAYS_IN_MONTH = 'N';

//Enable empty weekend days to be visible
$SHOW_EMPTY_WEEKENDS = true;

// Include unapproved events?
$get_unapproved = ( $DISPLAY_UNAPPROVED == 'Y' );

$nextStr = translate ( 'Next' );
$prevStr = translate ( 'Previous' );
$userStr = ( empty ( $user ) ? '' : '&amp;user=' . $user )
	   . ( empty ( $_GET['subGrpId'] ) ? '' : '&amp;subGrpId=' .$_GET['subGrpId'] )
	   . ( empty ( $_GET['subRuleId'] ) ? '' : '&amp;subRuleId=' .$_GET['subRuleId'] )
	   . ( empty ( $_GET['subject_id'] ) ? '' : '&amp;subject_id=' .$_GET['subject_id'] );

if ( $single_user == 'N' ) {
  if ( ! empty ( $user ) ) {
    user_load_variables ( $user, 'user_' );
    $fullnameStr = $user_fullname;
  } else
    $fullnameStr = $fullname;
}
$asstModeStr = ( $is_assistant
  ? '      <span class="asstmode">-- '
   . translate ( 'Assistant mode' ) . ' --</span>' : '' );

if ( empty ( $friendly ) ) {
  $unapprovedStr = display_unapproved_events ( ( $is_assistant || $is_nonuser_admin
      ? $user : $login ) );
  $printerStr = generate_printer_friendly ( 'year.php' );
} else
  $unapprovedStr = $printerStr = '';

$yr_rows = 3;
/* TODO: Move $yr_rows = 3 to webcal_config as default.
 * Add to webcal_user_prefs for each user.
 */
$yr_cols = intval ( 12 / $yr_rows );
$m = 1;

$gridOmonths = '';

for ( $r = 1; $r <= $yr_rows; $r++ ) {
  $gridOmonths .= '        <tr>';

  for( $c = 1; $c <= $yr_cols; $c++, $m++ ) {
    $gridOmonths .= '
          <td>' . display_small_month ( $m, $year, false ) . '</td>';
  }
  $gridOmonths .= '
        </tr>';
}

$trailerStr = print_trailer ();
print_header ();
echo <<<EOT
   {$navStr}
EOT;
echo <<<EOT
    <div class="title">
	  <a title="{$prevStr}" class="prev" href="year.php?year={$prevYear}{$userStr}">
        <img src="images/leftarrow.gif" alt="{$prevStr}" /></a>
      <a title="{$nextStr}" class="next" href="year.php?year={$nextYear}{$userStr}">
        <img src="images/rightarrow.gif" alt="{$nextStr}" /></a>
      <span class="date">{$thisyear}</span><br />
      <span class="user"></span><br />
      {$asstModeStr}
      {$catSelectStr}
    </div><br />
    <div align="center">
      <table id="monthgrid">
        {$gridOmonths}
      </table>
    </div><br />
    {$unapprovedStr}<br />
    {$printerStr}
    {$trailerStr}
EOT;

include_once '../footer.php';
?>



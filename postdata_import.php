<?php
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case "uploadSession":
			if($_FILES['uploadSess']['name'] == '')
			{
				session_start();
				$_SESSION['error_msg'] = "Please choose a file to upload.";
				header('Location: admin/prerequistie_upload.php');
			}else{
			$course_id='';$batch_id = '';
			require 'classes/PHPExcel.php';
			require_once 'classes/PHPExcel/IOFactory.php';
			$path = $_FILES['uploadSess']['tmp_name'];//"datafile.xlsx";
			$objPHPExcel = PHPExcel_IOFactory::load($path);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
			}
			$dataArr = array();
			for ($row = 1; $row <= $highestRow; ++ $row) 
			{
				$val=array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) 
				{
				   $cell = $worksheet->getCellByColumnAndRow($col, $row);
				   if($col == 10){
				   		$val[] = (string)$cell->getFormattedValue();
				   }else{
				   		$val[] = (string)$cell->getValue();
					}
				}
				$dataArr[] = $val;
			}
			$errorArr = array();
			if(count($dataArr)>1){
			$count = 1;
			require_once('config.php');
			//get all courses in the array
			$objF = new Fedena();								
			$respF = $objF->getAllCourses();
			$courseNameArr = array(); $courseIdsArr = array(); $courseCodeArr = array();	
			while($row = mysqli_fetch_array($respF))
			{
				$courseNameArr[] = $row['course_name'];
				$courseIdsArr[] = $row['id'];
				$courseCodeArr[] = $row['code'];
			}			
			foreach($dataArr as $values){
				//check if file headers are in expected format
				if($count == 1){
					if(strtolower(trim($values[0]))=="course" && strtolower(trim($values[1]))=="course code" && strtolower(trim($values[2]))=="batch" && strtolower(trim($values[3]))=="subject" && strtolower(trim($values[4]))=="subject code" && strtolower(trim($values[5]))=="subject pre-requistie"  && strtolower(trim($values[6]))=="subject pre-requistie code" && strtolower(trim($values[7]))=="maximum students" && strtolower(trim($values[8]))=="minimum students" &&  strtolower(trim($values[9]))=="subject costs" &&  strtolower(trim($values[10]))=="status"){
						//File format is correct
					}else{
						$errorArr[] = "File format is not same, one or more header names are not matching";
						$_SESSION['error_msgArr'] = $errorArr;
						header('Location: admin/prerequistie_upload.php');
						exit;
					}
					$count++;
				}elseif(strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!="" &&  strtolower(trim($values[8]))!="" &&  strtolower(trim($values[9]))!="" &&  strtolower(trim($values[10]))!="") {
					//check if course name exist
					$coursekey =array_search(trim(strtolower($values[1])), array_map('trim', array_map('strtolower', $courseCodeArr)));
					if(($coursekey === 0) || ($coursekey > 0)){
						$course_id = $courseIdsArr[$coursekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." Course Code does not exist in the system";
					}					
					//check if batch name exist 					
					$respB = $objF->getAllBatches($course_id);
					$batchNameArr = array(); $batchIDArr = array(); 
					while($row = mysqli_fetch_array($respB))
					{
						$batchNameArr[] = $row['name'];
						$batchIDArr[] = $row['id'];
					}
					$batchNamekey =array_search(trim(strtolower($values[2])), array_map('trim', array_map('strtolower', $batchNameArr)));
					if(($batchNamekey === 0) || ($batchNamekey > 0)){
						 $batch_id = $batchIDArr[$batchNamekey];
					}else{
						$errorArr[] = "Error in Row no:" .$count." This Batch Name does not exist in the Course";
					}
					//check if subject exist
					if ((isset($values[2]) && $values[2]!='') && (isset($values[3]) && $values[3]!='') && (isset($values[4]) && $values[4]!='')){
						$resultQRY = mysqli_query($db_FED, "SELECT s.id FROM subjects s WHERE batch_id = '".$batch_id."' and school_id='".$_SESSION['school_id']."' and s.name='".trim($values[3])."' and s.code='".trim($values[4])."' LIMIT 1");
						$dRowQ = mysqli_fetch_assoc($resultQRY);
						if(count($dRowQ) > 0){
							$subject_id = $dRowQ['id'];
						}else{
							$errorArr[] = "Error in Row no:" .$count." Subject is not associated to given course and batch";
						}
					}
					//check if required subject exist
					if ((isset($values[2]) && $values[2]!='') && (isset($values[5]) && $values[5]!='') && (isset($values[6]) && $values[6]!=''))
					{
						$cnt = 0;
						$subject_id_arr = array();
						$req_sub_arr = explode(",",trim($values[6]));
						foreach($req_sub_arr as $req_sub)
						{
							$resultQRY = mysqli_query($db_FED, "SELECT s.id FROM subjects s WHERE batch_id ='".$batch_id."' and school_id='".$_SESSION['school_id']."' and s.code='".trim($req_sub)."' LIMIT 1");
							$dRowQ = mysqli_fetch_assoc($resultQRY);
							if(count($dRowQ) > 0){
								$subject_id_arr[] = $dRowQ['id'];
								$cnt++;
							}
						}
						if($cnt != count($req_sub_arr))
						{
							$errorArr[] = "Error in Row no:" .$count." PRE-Requisite subjects are not associated to given course and batch";
						}
					}	
					$count++;
				}
			}
			//if file have no errors create activity and sessions else return error messages array
			if(count($errorArr)==0){
				$total = 0;
				foreach($dataArr as $values){
						if($total > 0 && strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!="" && strtolower(trim($values[8]))!="" &&  strtolower(trim($values[9]))!="" &&  strtolower(trim($values[10]))!=""){
								//get the course_id
								$coursekey =array_search(trim(strtolower($values[1])), array_map('trim', array_map('strtolower', $courseCodeArr)));
								if(($coursekey === 0) || ($coursekey > 0)){
									$course_id = $courseIdsArr[$coursekey];
								}
								//get the batch id													
								$respB = $objF->getAllBatches($course_id);
								$batchNameArr = array(); $batchIDArr = array(); 
								while($row = mysqli_fetch_array($respB))
								{
									$batchNameArr[] = $row['name'];
									$batchIDArr[] = $row['id'];
								}
								$batchNamekey =array_search(trim(strtolower($values[2])), array_map('trim', array_map('strtolower', $batchNameArr)));
								if(($batchNamekey === 0) || ($batchNamekey > 0)){
									 $batch_id = $batchIDArr[$batchNamekey];
								}
								//get the subject id
								$resultQRY = mysqli_query($db_FED, "SELECT s.id FROM subjects s WHERE batch_id = '".$batch_id."' and school_id='".$_SESSION['school_id']."' and s.name='".trim($values[3])."' and s.code='".trim($values[4])."' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if(count($dRowQ) > 0){
									$subject_id = $dRowQ['id'];
								}
								//get the required subject id
								$subject_id_arr = array();
								$req_sub_arr = explode(",",trim($values[6]));
								foreach($req_sub_arr as $req_sub)
								{
									$resultQRY = mysqli_query($db_FED, "SELECT s.id FROM subjects s WHERE batch_id ='".$batch_id."' and school_id='".$_SESSION['school_id']."' and s.code='".trim($req_sub)."' LIMIT 1");
									$dRowQ = mysqli_fetch_assoc($resultQRY);
									if(count($dRowQ) > 0){
										$subject_id_arr[] = $dRowQ['id'];										
									}
								}
								$subject_id_str = implode(',',$subject_id_arr);
								//check if the combination already exist in database
								$resultQRY = mysqli_query($db_RPS, "SELECT id FROM subjects_prerequistie WHERE course_id='$course_id' and batch_id='$batch_id' and subject_id='$subject_id' and school_id='".$_SESSION['school_id']."' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if (count($dRowQ) > 0) {
									//$sessionId = $dRowQ['id'];
									$sql_upd = "update subjects_prerequistie set course_id = '".$course_id."',
																				 course_name = '".mysql_real_escape_string(trim($values[0]))."',
																				 course_code = '".mysql_real_escape_string(trim($values[1]))."',
																				 batch_id = '".$batch_id."',
																				 batch_name = '".mysql_real_escape_string(trim($values[2]))."',
																				 subject_id = '".$subject_id."',
																				 subject_name = '".mysql_real_escape_string(trim($values[3]))."',
																				 subject_code = '".mysql_real_escape_string(trim($values[4]))."',
																				 required_subject_id = '".$subject_id_str."',
																				 required_subject_name = '".mysql_real_escape_string(trim($values[5]))."',
																				 required_subject_code = '".mysql_real_escape_string(trim($values[6]))."',
																				 max_students = '".mysql_real_escape_string(trim($values[7]))."',
																				 min_students = '".mysql_real_escape_string(trim($values[8]))."',
																				 cost = '".mysql_real_escape_string(trim($values[9]))."',
																				 school_id = '".$_SESSION['school_id']."',
																				 status = '".mysql_real_escape_string(trim($values[10]))."' where id='".$dRowQ['id']."'";
									mysqli_query($db_RPS,$sql_upd);
								}else{									
									$result = mysqli_query($db_RPS, "INSERT INTO subjects_prerequistie(course_id,course_name,course_code,batch_id,batch_name,subject_id,subject_name,subject_code,required_subject_id,required_subject_name,required_subject_code,max_students,min_students,cost,school_id,status) VALUES ('" .$course_id. "', '" .mysql_real_escape_string(trim($values[0])). "','" .mysql_real_escape_string(trim($values[1])). "', '" .$batch_id. "', '" .mysql_real_escape_string(trim($values[2])). "', '" .$subject_id. "','".mysql_real_escape_string(trim($values[3]))."', '" .mysql_real_escape_string(trim($values[4])). "', '" .$subject_id_str. "', '".mysql_real_escape_string(trim($values[5]))."', '" .mysql_real_escape_string(trim($values[6])). "', '" .mysql_real_escape_string(trim($values[7])). "', '" .mysql_real_escape_string(trim($values[8])). "', '" .mysql_real_escape_string(trim($values[9])). "','".$_SESSION['school_id']."','" .mysql_real_escape_string(trim($values[10])). "');");
								}								
						} $total++ ; 
				}
				
				$_SESSION['succ_msg'] = "Data has been uploaded successfully.";
				header('Location: admin/prerequistie_upload.php');
			}else{
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: admin/prerequistie_upload.php');
			}
		}else{
				session_start();
				$errorArr[] = "File do not have any data to import.";
				$_SESSION['error_msgArr'] = $errorArr;
				header('Location: admin/prerequistie_upload.php');
		}
		break;	
		}
 }
}
?>
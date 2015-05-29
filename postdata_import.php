<?php
if (isset($_POST['form_action']) && $_POST['form_action']!=""){
	$formPost = $_POST['form_action'];
	switch ($formPost) {
		case "uploadSession":
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
					if(strtolower(trim($values[0]))=="course" && strtolower(trim($values[1]))=="course code" && strtolower(trim($values[2]))=="batch" && strtolower(trim($values[3]))=="subject" && strtolower(trim($values[4]))=="subject pre-requistie" && strtolower(trim($values[5]))=="maximum students" && strtolower(trim($values[6]))=="minimum students" &&  strtolower(trim($values[7]))=="subject costs" &&  strtolower(trim($values[8]))=="status"){
						//File format is correct
					}else{
						$errorArr[] = "File format is not same, one or more header names are not matching";
						$_SESSION['error_msgArr'] = $errorArr;
						header('Location: admin/prerequistie_upload.php');
						exit;
					}
					$count++;
				}elseif(strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!="" &&  strtolower(trim($values[8]))!=""){
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
					if ((isset($values[2]) && $values[2]!='') && (isset($values[3]) && $values[3]!='')){
						$eg_name = iconv('UTF-8', 'ISO-8859-1',$values[3]);
						$resultQRY = mysqli_query($db_FED, "SELECT eg.id FROM elective_groups eg inner join batches b on b.id = eg.batch_id inner join courses c on c.id = b.course_id WHERE b.course_id='".$course_id."' and b.name = '".trim($values[2])."' and eg.school_id='".$_SESSION['school_id']."' and eg.name='". trim($eg_name)."' LIMIT 1");
						$dRowQ = mysqli_fetch_assoc($resultQRY);
						if(count($dRowQ) > 0){
							$subject_id = $dRowQ['id'];
						}else{
							$errorArr[] = "Error in Row no:" .$count." Subject is not associated to given course and batch";
						}
					}
					if (isset($values[4]) && $values[4]!='')
					{
						$cnt = 0;
						$subject_id_arr = array();
						$req_sub_arr = explode(",",trim($values[4]));
						foreach($req_sub_arr as $req_sub)
						{
							$eg_name = iconv('UTF-8', 'ISO-8859-1',$req_sub);
							$resultQRY = mysqli_query($db_FED, "SELECT eg.id FROM elective_groups eg inner join batches b on b.id = eg.batch_id inner join courses c on c.id = b.course_id WHERE b.course_id='".$course_id."' and b.name = '".trim($values[2])."' and eg.school_id='".$_SESSION['school_id']."' and eg.name='".trim($eg_name)."' LIMIT 1");
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
			//echo $subject_id;die;
			//if file have no errors create activity and sessions else return error messages array
			if(count($errorArr)==0){
				$total = 0;
				foreach($dataArr as $values){
						if($total > 0 && strtolower(trim($values[0]))!="" && strtolower(trim($values[1]))!="" && strtolower(trim($values[2]))!="" && strtolower(trim($values[3]))!="" && strtolower(trim($values[4]))!="" && strtolower(trim($values[5]))!="" && strtolower(trim($values[6]))!="" && strtolower(trim($values[7]))!="" && strtolower(trim($values[8]))!=""){
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
								$eg_name = iconv('UTF-8', 'ISO-8859-1',$values[3]);
								$resultQRY = mysqli_query($db_FED, "SELECT eg.id FROM elective_groups eg inner join batches b on b.id = eg.batch_id inner join courses c on c.id = b.course_id WHERE b.course_id='".$course_id."' and b.name = '".trim($values[2])."' and eg.school_id='".$_SESSION['school_id']."' and eg.name='". trim($eg_name)."' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if(count($dRowQ) > 0){
									$subject_id = $dRowQ['id'];
								}
								//get the required subject id
								$subject_id_arr = array();
								$req_sub_arr = explode(",",trim($values[4]));
								foreach($req_sub_arr as $req_sub)
								{
									$eg_name = iconv('UTF-8', 'ISO-8859-1',$req_sub);
									$resultQRY = mysqli_query($db_FED, "SELECT eg.id FROM elective_groups eg inner join batches b on b.id = eg.batch_id inner join courses c on c.id = b.course_id WHERE b.course_id='".$course_id."' and b.name = '".trim($values[2])."' and eg.school_id='".$_SESSION['school_id']."' and eg.name='".trim($eg_name)."' LIMIT 1");
									$dRowQ = mysqli_fetch_assoc($resultQRY);
									if(count($dRowQ) > 0){
										$subject_id_arr[] = $dRowQ['id'];										
									}
								}
								//check if the combination already exist in database
								$resultQRY = mysqli_query($db_RPS, "SELECT id FROM subjects_prerequistie WHERE course_id='$course_id' and batch_id='$batch_id' and subject_id='$subject_id' and school_id='".$_SESSION['school_id']."' LIMIT 1");
								$dRowQ = mysqli_fetch_assoc($resultQRY);
								if (count($dRowQ) > 0) {
									//$sessionId = $dRowQ['id'];
								}else{
									$subject_id_str = implode(',',$subject_id_arr);
									$result = mysqli_query($db_RPS, "INSERT INTO subjects_prerequistie(course_id,course_name,course_code,batch_id,batch_name,subject_id,subject_name,required_subject_id,required_subject_name,max_students,min_students,cost,school_id,status) VALUES ('" .$course_id. "', '" .mysql_real_escape_string(trim($values[0])). "','" .mysql_real_escape_string(trim($values[1])). "', '" .$batch_id. "', '" .mysql_real_escape_string(trim($values[2])). "', '" .$subject_id. "', '" .mysql_real_escape_string(trim($values[3])). "', '" .$subject_id_str. "', '" .mysql_real_escape_string(trim($values[4])). "', '" .mysql_real_escape_string(trim($values[5])). "', '" .mysql_real_escape_string(trim($values[6])). "', '" .mysql_real_escape_string(trim($values[7])). "','".$_SESSION['school_id']."','" .mysql_real_escape_string(trim($values[8])). "');");
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
?>
<?php
class Users extends Base {
    public function __construct(){
   		 parent::__construct();
   	}
	/*function for admin login*/
	public function userLogin() {
		if(isset($_POST['txtUName']))
		{
			//check if user account exists
			$encPwd = base64_encode($_POST['txtPwd']);
			$login_query="select * from users where username='".$_POST['txtUName']."' and password='".$encPwd."' and is_active='1'";
			$q_res = mysqli_query($this->connrps, $login_query);
			if(mysqli_num_rows($q_res)>0)
			{
				while($data = mysqli_fetch_assoc($q_res))
	  			{
					$_SESSION['user_id']=$data['id'];
					$_SESSION['username']=$data['username'];
					$_SESSION['user_email']=$data['email'];
					$_SESSION['role']=$data['isAdmin'];
				}
				return 1;
			}else{
				$message="Incorrect Username or Password";
				$_SESSION['error_msg'] = $message;
				return 0;
			}
		}
	}
	/*function for student log in*/
	public function stuUserLogin() {
		if(isset($_POST['txtUName']) && isset($_POST['subDomain'])){
			$schl_query="select id from schools where code='".trim($_POST['subDomain'])."'";
			$schl_query_res = mysqli_query($this->connfed, $schl_query);
		  if(mysqli_num_rows($schl_query_res)>0){
			$school_data=mysqli_fetch_assoc($schl_query_res);
			$hash_salt_query="select id,hashed_password,salt,email from users where username='".trim($_POST['txtUName'])."' and school_id='".$school_data['id']."' and admin!=1 and employee!=1 and student!=0";
			$hash_salt_res = mysqli_query($this->connfed, $hash_salt_query);
			if(mysqli_num_rows($hash_salt_res)>0){	
			 	$row=mysqli_fetch_assoc($hash_salt_res);
				$hash_pwd = $row['hashed_password'];
				$salt = $row['salt'];
				$pwd=$salt.$_POST['txtPwd'];
				$hash_new_pwd=hash('sha1',$pwd);
				if ($hash_pwd==$hash_new_pwd) {
					 $_SESSION['user_id']=$row['id'];
					 $_SESSION['username']=$row['username'];
					 $_SESSION['user_email']=$row['email'];
					 $_SESSION['school_id']=$school_data['id'];
					 return 1;
				}else{
					 $message="Paasword does not matched.";
					 $_SESSION['error_msg'] = $message;	
					 return 0;
				}
			  }else{
			  		$message="Incorrect Username or Password";
					$_SESSION['error_msg'] = $message;
					return 0;
			  }
			}else{
				$message="Incorrect Username or Password";
				$_SESSION['error_msg'] = $message;
				return 0;
			}
		}
	}
	//function to forgot the password
	public function forgotPwd() {
		if (isset($_POST['email'])){
				$email = $_POST['email'];
				$query="select * from users where email='$email'";
				$result   = mysqli_query($this->connrps,$query);
				$count=mysqli_num_rows($result);
				// If the count is equal to one, we will send message other wise display an error message.
				if($count==1){
					$rows=mysqli_fetch_array($result);
					$pass  =  base64_decode($rows['password']);
					$to = $rows['email'];
					$url = $_SERVER['HTTP_HOST'];
					$body  =  "
					Website Url : $url <br/>
					Your Email Id : $to <br/>
					Here is your password  : $pass <br/><br/><br/><br/>
					Sincerely,<br/>
					BARNA";
					$from = "roa57113@gmail.com";
					$subject = "Your password has been recovered";
					$headers1 = 'From: Password Recovered <$from>' . "\r\n";
					$headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
					$headers1 .= "X-Priority: 1\r\n";
					$headers1 .= "X-MSMail-Priority: High\r\n";
					$headers1 .= "X-Mailer: Password Recovered\r\n";
					$sentmail = mail ( $to, $subject, $body, $headers1 );
					//If the message is sent successfully, display sucess message otherwise display an error message.
					if($sentmail==1){
						$message= "Your password has been sent to your email address.";
						$_SESSION['succ_msg'] = $message;
						return 1;
					}else{
						if($_POST['email']!=""){
							$message= "Cannot send password to your e-mail address.Problem with sending mail...";
							$_SESSION['error_msg'] = $message;
							return 0;
						}
					 }
				} else {
					if ($_POST ['email'] != "") {
					$message= "Email does not exist.";
					$_SESSION['error_msg'] = $message;
					return 0;
					}
				}
		 }
   }
   //function to chnage the admin password
   public function changePwd(){
        $uesr_id=$_SESSION['user_id'];
		$sql="select * from users where id='$uesr_id'";
		$query = mysqli_query($this->connrps, $sql);
		while ($row = mysqli_fetch_array($query)) {
			$username = $row['username'];
			$password = $row['password'];
		}
		$cur_password=base64_encode($_POST['currentPassword']);
		$new_pwd=base64_encode($_POST['newPassword']);
		$confirm_pwd=base64_encode($_POST['confirmPassword']);
		if ($cur_password != $password) {
			$message= "Current password does not matched.";
			$_SESSION['error_msg'] = $message;
			return 0;
		}else if ($new_pwd != $confirm_pwd) {
			$message= "Confirm password does not matched";
			$_SESSION['error_msg'] = $message;
			return 0;
		}else {
			$query_updt = "UPDATE users SET password = '$new_pwd' WHERE id='$uesr_id'";
			$query_updt = mysqli_query($this->connrps, $query_updt);
			$message= "New password has been updated successfully";
			$_SESSION['succ_msg'] = $message;
			return 1;
		}
	}
   //function to chnage the student password
   public function changeStuPwd(){
        $uesr_id=$_SESSION['user_id'];
		$sql="select * from users where id='$uesr_id'";
		$query = mysqli_query($this->connfed, $sql);
		while ($row = mysqli_fetch_array($query)) {
			$hase_pwd= $row['hashed_password'];
			$salt = $row['salt'];
		}
		$cur_password=$salt.$_POST['currentPassword'];
		$hash_new_curr_pwd=hash('sha1',$cur_password);
		$new_pwd=$_POST['newPassword'];
		$confirm_pwd=$_POST['confirmPassword'];
		if ($hash_new_curr_pwd != $hase_pwd) {
				$message= "Current password does not matched.";
				$_SESSION['error_msg'] = $message;
				return 0;
		}else if ($new_pwd != $confirm_pwd) {
				$message= "Confirm password does not matched";
				$_SESSION['error_msg'] = $message;
				return 0;
		}else {
				$size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
				$random_salt = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
				$new_hash_pwd=$random_salt.$new_pwd;
				$new_hash_pwd=hash('sha1',$new_hash_pwd);
				$query_updt = "UPDATE users SET hashed_password = '".$new_hash_pwd."',salt='".$random_salt."' WHERE id='$uesr_id'";
				$query_updt = mysqli_query($this->connfed, $query_updt);
				$message= "New password has been updated successfully";
				$_SESSION['succ_msg'] = $message;
				return 1;
		}
	}
	//getting the admin username
	function getUserName($Id){
		$sql="select username from users where id='".$_SESSION['user_id']."'";
		$q_res = mysqli_query($this->connrps, $sql);
		$data = mysqli_fetch_assoc($q_res);
		return $data;
	}
	//getting the student username
	function getStuUname($Id){
		$sql="select username from users where id='".$_SESSION['user_id']."'";
		$q_res = mysqli_query($this->connfed, $sql);
		$data = mysqli_fetch_assoc($q_res);
		return $data;
	}
}

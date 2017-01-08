<?php
ob_start();
   include 'includes/dbc.php';
   session_start();
   check_usr_status();
   $page_title="Friendsalong";
   include("main_includes.php");

/******************* ACTIVATION BY FORM**************************/
if ($_POST['doReset']=='Reset')
{
$user_email = mysql_real_escape_string($_POST['user_email']);

//check if activ code and user is valid as precaution
$rs_check = mysql_query("select user_id from users where user_email='$user_email'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$msg = urlencode("Sorry no such account exists or registered.");
	header("Location: forgot.php?msg=$msg");
	exit();
	}
//generate 4 digit random number
$new = rand(10000,99999);
$md5_new = md5($new);	
//set update md5 of new password
$rs_activ = mysql_query("update users set pwd='$md5_new' WHERE 
						 user_email='$user_email'") or die(mysql_error());
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);						 
						 
//send email
$message = 
"Here are your new password details ...\n
User Email: $user_email \n
Password: $new \n

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

	// mail($user_email, "Reset Password", $message,
    // "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     // "X-Mailer: PHP/" . phpversion());						 

require("includes/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.friendsalong.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "support@friendsalong.com";  // SMTP username
$mail->Password = "Galaxy@345"; // SMTP password

$mail->From = "support@friendsalong.com";
$mail->FromName = "Friendsalong Team";
$mail->AddAddress($user_email);     
$mail->Subject = "Reset Password";
/***
By Pavanesh white travelling JHS-Bangalore on 20-11-2012.
**/
$date = date("m-d-Y");
$assigned_vars = array('date' => $date, 'useremail' => $user_email, 'newpwd' => $new);
$output = file_get_contents('resetpwd_template.php');
 foreach($assigned_vars as $key => $value) {
	$output = preg_replace('/{'.$key.'}/', $value, $output);
}
// echo $output;
// exit(); 
//$mail->Body    = $message;
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
$mail->MsgHTML($output);

	if(!$mail->Send())
	{
	   echo "Message could not be sent. <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}
					 
	$msg = urlencode("Your account password has been reset and a new password has been sent to your email address.");
	header("Location: forgot.php?msg=$msg");						 
	exit();
}
?>
<!-- script for closing alert box div -->
<script src="assets/js/jquery.validate.min.js"></script>   
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
  <script>
  $(document).ready(function(){
    $("#actForm").validate();
  });
  </script>
</head>
<body>
<img src="img/home-bg.jpg" class="bg" alt="bg-front-img"/>
<?php include('navbar.php');?>
<div class="container">
<div class="box-signup">	
<br/>
<h3>Forgot Password</h3><hr/>
<div style="color:#943367; font-size:13px; font-family: 'Montsearsrat Alternates', sans-serif; text-indent:40px;"><span style="color:red">Note:</span>&nbsp;&nbsp;If you have forgot the account password, you can <strong>reset password</strong> 
and a new password will be sent to your email address.</div>	
<br/>
      <div style="margin-left:240px;">
		  <form action="forgot.php" method="post" name="actForm" id="actForm">
				<p style="font-size:13px; font-family: 'Montsearsrat Alternates', sans-serif; text-align:center;display:inline;color:#B15E1D;">Your Email</p>
				&nbsp;<p style="display:inline;">
					  <input name="user_email" type="text" class="required email" id="user_email" size="25">
				</p>&nbsp;
				<p style="display:inline;">              
					  <input style="margin-top:-10px;" class="btn btn-medium btn-success" name="doReset" type="submit" id="doReset" value="Reset">
				</p>
				
		   </form>	
	  </div>
</div><br/><hr/>
  <footer>
       	<?php include("footer.php"); ?>
      </footer>

</div>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>
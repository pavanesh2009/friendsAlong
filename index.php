<?php 
ob_start();
   include 'includes/dbc.php';
   session_start();
   check_usr_status();
   $page_title="Friendsalong";
   include("main_includes.php");

if($_POST['doRegister'] == 'Sign Up') 
{ 
/******************* Filtering/Sanitizing Input ******************************/
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
//	echo $data[$key]."x";
}
  
/********* SERVER SIDE VALIDATION ****Useful if javascript is disabled in the browswer ***/
if(empty($data['full_name']) || strlen($data['full_name']) < 4)
{
$err = urlencode("Full Name should contain atleast 3 or more characters.");
//header("Location: register.php?msg=$err");
//exit();
}
// Validate Email
elseif(!isEmail($data['usr_email'])) {
$err = urlencode("Email is not valid. Please check and try again.");
}
// Check User Passwords
//elseif (!checkPwd($data['pwd'],$data['pwd2'])) {
//$err = urlencode("Invalid Password or mismatch. Password should contain atleast 3 or more characters.");
//header("Location: register.php?msg=$err");
//exit();
//}
else
{
$usr_email = $data['usr_email'];
$usr_name = $data['full_name'];
$usr_pwd = $data['pwd'];
$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err = "This email id has already been used to register. Please try again with a different email id.";
//header("Location: register.php?msg=$err");
//exit();
}
}
if($err=='')
{
$user_ip = $_SERVER['REMOTE_ADDR'];
// stores md5 of password
$md5pass = md5($data['pwd']);
// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$birthday = date('Y-m-d', strtotime($data['date']));
$is_active = '1';
// Generates activation code simple 4 digit number
//$activ_code = rand(1000,9999);
$sql_insert = "INSERT into `users`
  			(`full_name`, 
			 `sex`,
			 `ccode`,
			 `user_email`,
			 `user_bday`,
			 `pwd`,
			 `date`,
			 `user_ip`,
			 `is_active`)
		    VALUES
		    ('".addslashes($data[full_name])."',
			'".addslashes($data[sex])."',
			'".addslashes($data[country])."',			
			'".addslashes($usr_email)."',
			'$birthday',
			'$md5pass',
			now(),
			'$user_ip',
			'$is_active')
			";

mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where user_id='$user_id'");
//echo "<h3>Thank You</h3> We received your submission.";
$message = 
"Dear $data[full_name],

Thank you for registering with Friendsalong. Here are your login details...

Email: $usr_email (the email id also serves as the username to login) \n
Password: $data[pwd] \n
Should you forget your password, please go to http://friendsalong.com and click on 'forgot password?' in the top right corner. A new password will be sent to your email address.

By registering with Friendsalong, you are joining a social network where you can plan or add a new trip and meet your friends along the way. Imagine a travel where you are reuniting with your old friends, relatives, colleagues and folks. Wow, what an experience this would be!

By joining the Friendsalong you also make new friends. Friendsalong strongly believe that during independent journeys as well as organised expeditions there are always people that touch your heart and become lifelong friends!

So now go get active and enjoy the company of your fellow travellers!

Please do get in touch with us at support@friendsalong.com if you need any help or have suggestions for improvements.

Thank you for your interest and participation!
The Friendsalong Team

http://friendsalong.com |  support@friendsalong.com

_____________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";
/*
	mail($usr_email, "Login Details", $message,
    "From: \"FriendsAlong Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());
*/
/********************* SMTP EMAIL WITH PHPMAILER LIBRARY *********************
i have heard lots of complaints that users not able to receive email using mail() function
so i am using alternate SMTP emailing which is quite fast and reliable. Before you use this you should
create POP/SMTP email in your hosting account 

This script needs class.phpmailer.php and class.smtp.php files from PHPMailer library.
Download here: http://phpmailer.sourceforge.net
********************************************************************************/
require("includes/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.friendsalong.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "support@friendsalong.com";  // SMTP username
$mail->Password = "Galaxy@345"; // SMTP password
$mail->From = "support@friendsalong.com";
$mail->FromName = "Friendsalong Team";
$mail->AddAddress($usr_email);     
$mail->Subject = "Login Details";
/***
By Pavanesh white travelling JHS-Bangalore on 20-11-2012.
**/
$date = date("m-d-Y");
$assigned_vars = array('username' => $usr_name, 'useremail' => $usr_email, 'userpwd' => $usr_pwd, 'date' => $date);
$output = file_get_contents('email_template.php');
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
 //echo "Message has been sent";
 header("Location: thankyou"); 
 exit();
}	 
} 
?>
<body style="background-image:none;">
<img src="img/home-bg.jpg" class="bg" alt="bg-front-img"/>
<?php include('navbar.php');?>
<div class="container">	
<!--Added for Website info -->
<div class="site-desc">
<!-- OR use this 9E1344 -->
<h1 class="welcome-page">Welcome to Friendsalong.</h1>
<br/>
<p style="text-align:center; font-size:15px;"><b>
Now your boring Trips can be memorable & fun !!</b></p><br/>
<ul style="list-style-type:none; font-size:15px;">
<li>
&#9824;&nbsp;&nbsp;Plan & Add your Trip.
</li>
<br/>
<li>
&#9824;&nbsp;&nbsp;Search old friends & make new one.
</li>
</ul>
<p style="text-align:center; font-size:15px;">
<br/><b>So, Let's get started.. &<br/>let your trip to become more fun than ever before.</b>
</p><br/>
</div>
<!-- Website info ends here -->
	<div class="box-signup" style="width:45%; float:right;">		
	<form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST" name="regForm" id="regForm"  class="form-horizontal">
				<fieldset>
				 <legend style="font-family:'sans-serif',trebuchet ms,arial; color:#A20F65; text-indent:12px;">New to Friendsalong? Sign up</legend>	
					<?php	
						  if ($err!='') {
						  $message = mysql_real_escape_string($err);
						  $decode_msg = urldecode($message);
							echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
						  }			
					?> 
					<div class="control-group">
					<label class="control-label" for="full_name" style="color:#5D1916;">Your Full Name<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input name="full_name" type="text" id="full_name" value="<?php echo $_POST['full_name'];?>"/>
						</div>
					</div>						
					<div class="control-group">
					<label class="control-label" class="placeholder" for="usr_email" style="color:#5D1916;">Email Address<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input name="usr_email" type="text" id="usr_email"  value="<?php echo $_POST['usr_email'];?>" autocomplete="off">
						</div>
					</div>	
					
					<div class="control-group">
					<label class="control-label" for="pwd" style="color:#5D1916;">Enter a Password<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input name="pwd" type="password" autocomplete="off" minlength="5" id="pwd"> 
						</div>
					</div>	
				
					<div class="control-group">
					<label class="control-label" for="date" style="color:#5D1916;">Birthday&nbsp;</label>
						<div class="controls">
							<?php $today = date("Y-m-d");?>
							<span class="input-append date" id="dp" data-date="<?php echo $today;?>" data-date-format="yyyy-mm-dd">
							<input name="date" type="text" readonly = "readonly" style="width:178px; margin:0px 0px 7px 0px;"	value="<?php echo $_POST['date'];?>">&nbsp;<span class="add-on" style="margin:0px 0px 7px 0px;"/><i class="icon-th"></i></span></span>
						</div>
					</div>	
						
					<div class="control-group">
					<label class="control-label" for="country" style="color:#5D1916;">Country<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<select id="country" name="country">
							<?php
								$country_list= mysql_query("Select ccode, country FROM countries ORDER BY country");
								echo "<option value='' selected>----- Choose your Country -----</option>";
								while($crows=mysql_fetch_array($country_list))
								{
								echo "<option value=$crows[ccode]>$crows[country]</option>";
								} 
								echo "</select>";
							?>
						</div>
					</div>	
					
					<div class="control-group">
					<label class="control-label" for="sex" style="color:#5D1916;">I am<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<select name="sex" value="<?php echo $_POST['sex'];?>">
								<option value="" selected="selected">Select Sex</option>
								<option value="1">Female</option>
								<option value="2">Male</option>
							</select>
						</div>
					</div>	
<div style="text-indent:30px; font-family:sans-serif,arial;color:#5D1916; font-size:11px;">By clicking Sign Up, you agree to our <a rel="nofollow" target="_blank" href="terms">Terms</a> and that you have read our <a rel="nofollow" target="_blank" href="privacy">Data Privacy Policy</a>.</div>
				<input name="doRegister" type="submit" id="doRegister" value="Sign Up" class="btn btn-info" style="margin-top:10px; margin-left:218px; border:1px solid #2F96B4; width:85px;"/>
		</fieldset>
	</form>
	</div>
	<!-- Login Page starts here -->
<?php 
			if ($_POST['doLogin']=='Login')
			{
			$user_email = mysql_real_escape_string($_POST['usr_email']);
			$md5pass = md5(mysql_real_escape_string($_POST['pwd']));
			if (strpos($user_email,'@') === false) {
				$user_cond = "user_email='$user_email'";
			} else {
				  $user_cond = "user_email='$user_email'";    
			}
			$sql = "SELECT `user_id`,`full_name` FROM users WHERE 
					   $user_cond
						AND `pwd` = '$md5pass' AND `is_active` = '1'
						"; 
			$result = mysql_query($sql) or die (mysql_error()); 
			$num = mysql_num_rows($result);
			  // Match row found with more than 1 results  - the user is authenticated. 
				if ( $num > 0 ) { 	
				list($user_id,$full_name,$user_cond) = mysql_fetch_row($result);
			//set the session	
				session_start(); 
				   // this sets variables in the session 
					$_SESSION['user_id']= $user_id;  
					$_SESSION['user_name'] = $full_name;
					//set a cookie witout expiry until 60 days
					  if(isset($_POST['remember'])){
							  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*60, "/");
							  setcookie("user_name", $_SESSION['user_name'], time()+60*60*24*60, "/");
							   }	
					if ($user_id)
							header("Location: dashboard");
					}
					else
					{
					$msg = urlencode("Oh snap! Change a few things up and try submitting again");
					header("Location: index?msg=$msg");
					}
			}
/*** 
** Check for new Messages and show it in messages link of Navabar 
***/
$unread_msg = mysql_query("SELECT COUNT( flag ) AS total_unread
												FROM messages m
												WHERE flag = 'U'
												AND to_id = '$logged_in'
												AND is_deleted =1
												AND m.message_id NOT
												IN (SELECT m1.message_id
												FROM messages m1
												JOIN friends f1 ON m1.to_id = f1.user_id
												WHERE is_blocked =1
												AND m1.created >= f1.modified_on
												AND f1.frnd_usr_id = m1.from_id
												AND m.message_id = m1.message_id
												AND f1.frnd_usr_id = m.from_id
												)");
					list($total_unread) = mysql_fetch_row($unread_msg);
					if ($total_unread > 0)
						$_SESSION['new_msg'] = $total_unread;						?>
	<div style="clear:both;"></div>
<hr/>
<?php include("footer.php"); ?>
</div>					
<?php mysql_close($link);
ob_flush();
?>
</div> <!-- /container -->
<!-- Script comes here -->
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<script src="assets/js/jquery.validate.min.js"></script> 
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<script>
  $(document).ready(function() {
	  $("#dp").datepicker();
  });
  </script>
<script>
      $(document).ready(function(){
						$('#regForm').validate(
						{
						rules: {
						full_name: {
							minlength: 2,
							required: true
						},
						usr_email: {
							required: true,
							email: true
						},
						pwd: {
							minlength: 5,
							required: true
						},
						country: { required: true },
						sex: { required: true }
						},
							highlight: function(label) {
							$(label).closest('.control-group').addClass('error');
							},
							success: function(label) {
							label
							.text('OK!').addClass('valid')
							//$(label).closest('.control-group').removeClass('error')
							.closest('.control-group').addClass('success');
							}
							});
							}); // end document.ready
			</script>
</body>
</html>
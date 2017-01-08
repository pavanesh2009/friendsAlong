<?php 
ob_start();
include 'includes/dbc.php';
session_start();
check_usr_status();
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
else
{
$usr_email = $data['usr_email'];
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
$mail->Body    = $message;
//$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
//$mail->MsgHTML(file_get_contents('email_template.php'));

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
	
<? 
   session_start();
   $page_title="Friendsalong";
   include("main_includes.php");
?>
<script src="assets/js/jquery.validate.min.js"></script> 
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-timepicker.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/timepicker.css" rel="stylesheet" type="text/css"/>
<script>
  $(document).ready(function() {
	  $("#dp").datepicker();
	  //$("timepicker").timepicker();
  });
  </script>
  <script src="assets/js/bootstrap.js"></script>
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
<body>
<?php include('navbar.php');?>
<div class="container">
	<?	
			  if ($err!='') {
			  $msg = mysql_real_escape_string($err);
			  $decode_msg = urldecode($msg);
			  echo "<div class=\"alert alert-error\">$decode_msg</div>";
			  }
			 /* if(isset($_POST['doRegister']) && $msg==''){
			  echo "<div class=\"alert alert-success\"><h2>Thank you</h2> Your registration is now complete and you can <a href=\"login.php\">login here</a></div>";
			  //exit();
			  }*/
		?> 
<div class="box-signup">
	<form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST" name="regForm" id="regForm"  class="form-horizontal">
				<fieldset>
				<legend style="color:#A20F65; text-indent:12px;">Sign Up and lets get started..</legend>			
					<div class="control-group">
					<label class="control-label" for="full_name" style="color:#5D1916;">Your Full Name<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input name="full_name" type="text" id="full_name" value="<?php echo $_POST['full_name'];?>"/>
						</div>
					</div>	
					
					<div class="control-group">
					<label class="control-label" for="usr_email" style="color:#5D1916;">Email Address<span class="required"><font color="#CC0000">*</font></span></label>
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
					<label class="control-label" for="date" style="color:#5D1916;">Birthday</label>
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
				<input name="doRegister" type="submit" id="doRegister" value="Sign Up" class="btn btn-success" style="margin-top:10px; margin-left:218px; border:1px solid green; width:85px;"/>
		</fieldset>
	</form>
	</div>
<hr/>
  <footer>
       		<?php include("footer.php"); ?>	
      </footer>
</div>					
<?php mysql_close($link);
ob_flush(); ?>
</div>
</body>
</html>
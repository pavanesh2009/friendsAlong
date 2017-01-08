<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Send A Message";
include("main_includes.php");
?>
<script src="assets/js/jquery.js"></script> 
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
<script type="text/javascript">
			var info;
			$(document).ready(function(){
				var options = {
						'maxCharacterSize': 1500,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : 'Maximum Allowed: #max | #left Characters Left | #words words'
				};
				$('#msgtextarea').textareaCount(options, function(data){
					//$('#showData').html(data.input + " characters input. <br />" + data.left + " characters left. <br />" + data.max + " max characters. <br />" + data.words + " words input.");
				});
			});
		</script>
		<style type="text/css">
		.msgtext{padding:3px; text-align:justify; font-family:"Trebuchet MS"; background-color:#f2f2f2;}
		</style>
<?php
$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];
$flag = 'U';
$is_deleted = '1';
$recipient_id = mysql_real_escape_string($_GET['userID']);
//var_dump($recipient_id);

$sql = "select user_email from users where user_id = '$recipient_id'";
$result = mysql_query($sql,$link);
$getemail = mysql_fetch_array($result);
$user_email= $getemail[user_email];

$msg_id = mysql_real_escape_string($_GET['msgID']);
//var_dump($msg_id);
//Check User Block Status
		$get_usr_status = mysql_query("SELECT is_blocked from friends where frnd_usr_id = '$recipient_id' and user_id = '$user_id'");
		while ($status = mysql_fetch_array($get_usr_status))
		{
		$recipient_status = $status['is_blocked'];
		//var_dump($recipient_status);
		}
if ($_POST['messagePost']=='Send')
{
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}
if(empty($data['post_title']) || strlen($data['post_body']) < 4)
{
$err = urlencode("Oops! Looks like you are missing something. Please note that message should contain atleast four character.");
}
elseif($user_id == $recipient_id ){
$err = urlencode("Oops! You can not send message to yourself.");
}
elseif($recipient_status == 1){
$err = urlencode("Oops! Looks like either you have blocked this user or user does not exist.");
}
else
{
	$sql1 = mysql_query("SELECT thread_id from messages where from_id = '$recipient_id' AND to_id = '$user_id'");
	while ($rs_settings = mysql_fetch_array($sql1)) 
	{
	$msg_thread_id = $rs_settings['thread_id'];
	}
//print $msg_thread_id;
	$sql_insert = "INSERT into `messages`
					(`title`, 
					 `body`,
					 `from_id`,
					 `to_id`,
					 `created`,
					 `flag`,
					 `is_deleted`,
					 `thread_id`
					 )
					VALUES
						('$data[post_title]',
						'$data[post_body]',
						'$user_id','$recipient_id', now(),'$flag','$is_deleted','$msg_thread_id')";
			mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
	/** Message notification through Email **/
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
$mail->Subject = "New Message Notification";
/***
By Pavanesh white travelling JHS-Bangalore on 20-11-2012.
**/
$date = date("m-d-Y");
//var_dump($user_name);
$assigned_vars = array('date' => $date, 'username' => $user_name);
$output = file_get_contents('msg_alert_template.php');
 foreach($assigned_vars as $key => $value) {
	$output = preg_replace('/{'.$key.'}/', $value, $output);
}
$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
$mail->MsgHTML($output);

	if(!$mail->Send())
	{
	   echo "Message could not be sent. <p>";
	   echo "Mailer Error: " . $mail->ErrorInfo;
	   exit;
	}	
	header("Location: messages.php"); 
	exit();
}
}
?>
<body>
<?php include("navbar.php")?>
<div class="container">
<br/>
<?	
			  if ($err!='') {
			  $msg = mysql_real_escape_string($err);
			  $decode_msg = urldecode($msg);
			  echo "<div class=\"alert alert-warning\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
			  }
			?> 
	<div class="trip_form" style="width:750px; border:1px dotted #ccc; margin:0 auto;">
		<?php 
			$sqlquery = mysql_query("select u.full_name, m.message_id, m.title, m.body, m.thread_id from messages m join users u 
				on m.from_id = u.user_id and m.to_id = '$user_id' and m.from_id = '$recipient_id' and m.message_id = '$msg_id'");
				while($msgchain = mysql_fetch_array($sqlquery))
					{
					if(count($msgchain) > 0)
					{
						echo "<div style=\"width:600px; border:1px dotted #ccc; padding:5px;\">";
						print "<b>From:</b><p class=\"msgtext\">".$msgchain['full_name']."</p>";
						print "<b>Subject:</b><p class=\"msgtext\">".$msgchain['title']."</p>";
						print "<b>Message:</b><p class=\"msgtext\">".$msgchain['body']."</p>";
						//print "<p>".$msgchain['thread_id']."</p>";
						//print "<p>".$msgchain['message_id']."</p>";
						echo "</div>";
					} else { echo " "; }
					
		?>
	<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="addmessageForm" id="addmessageForm" class="form-vertical appnitro">
	<table class="addmsg">
	<tr>
	<td>Subject:</td>
	<td><input type="text" name="post_title" value="<?php echo "["."Re:".$msgchain['title']."]"; } ?>" readonly=readonly/></td>
	</tr>
	<tr>
	<td>Message:</td>
	<!--<div id="showData"></div>-->
	<td><textarea id="msgtextarea" name="post_body" cols="10" rows="2" name="post_body" style="width:410px; height:120px;"><?php echo isset($_POST['post_body']) ? $_POST['post_body'] : ''; ?></textarea></td>
	</tr>
	</table>
	<div style="margin-left:112px;"><input name="messagePost" type="submit" id="messagePost" value="Send" class="btn btn-success"/></div>
	</form>	
	</div><br/>
	<hr/>
<?php include("footer.php"); ?>
<?php mysql_close($link);
ob_flush(); ?>
</div>
</body>
</html>
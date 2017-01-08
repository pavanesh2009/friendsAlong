<?php
ob_start(); 
include("includes/dbc.php");
session_start();
check_usr_status();
$page_title="Friendsalong";
include("main_includes.php");
// var_dump($_POST['remember']);
// exit();
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
		header("Location: login?msg=$msg");
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
<body>
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script>
$(document).ready(function() {
$('.dropdown-toggle').dropdown();
});
</script>
<?php include('navbar.php');?>
<div class="container">
		<p>
			<?php 
			  // if (isset($_GET['msg'])) {
			  // $msg = mysql_real_escape_string($_GET['msg']);
			  // echo "<div class=\"alert alert-error\">$msg</div>";
			  // }	  
			?>
		</p>
<div class="box-signup" style="margin-top:18px; min-height:350px;">
        <form action="login.php" method="post" name="logForm" class="form-horizontal">
			<fieldset>
				<legend style="color:#A20F65; text-indent:12px;">Login</legend>
					<div class="control-group">
						<label class="control-label" for="usr_email" style="color:#5D1916;">Email</label>
							<div class="controls">
							<input name="usr_email" type="text" id="usr_email" autofocus autocomplete="on"/>
							</div>
					</div>		
					<div class="control-group">
						<label class="control-label" for="pwd" style="color:#5D1916;">Password</label>
							<div class="controls">
							<input name="pwd" type="password" id="pwd">
							</div>
				<div style="margin-top:10px; padding-left:200px; color:#5D1916;"><input name="remember" type="checkbox" id="remember" value="1"/> &nbsp;Remember me</div>
						<div style="margin-top:10px; margin-left:210px;"> 
							<input name="doLogin" type="submit" id="doLogin3" value="Login" class="btn btn-medium btn-success" style="width:85px; color:white; border:1px solid green;"/>
							<div style="margin-top:10px; margin-left:-42px;"><a style = "text-decoration:none;" href="signup">Register Free</a> |</font> <a style = "text-decoration:none;" href="forgot">Forgot Password</a></div>
						</div>
			</fieldset>
		</form>
</div>
<br/>
<hr/>
      <footer>
       		<?php include("footer.php"); ?>
      </footer>
<?php mysql_close($link);
ob_flush(); ?>
</div>
</body>
</html>
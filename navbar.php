<?php
$page_title="My Profile";
?>
<script>
$(document).ready(function() {
$('.dropdown-toggle').dropdown();
});
</script>
<?php $logged_in = $_SESSION['user_id']; $user_name = $_SESSION['user_name']; ?>
<?php 
function echoActive($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
?>
 <div class="navbar navbar-fixed-top">
			  <div class="navbar-inner">
				<div class="container">
				  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </a>
					  <?php if(!$logged_in) { ?>
						<a class="brand" href="index">Friendsalong</a>
					  <?php } else { ?>
						<a class="brand" href="dashboard">Friendsalong</a>
						<?php } ?>
				  <div class="nav-collapse">
				  <?php if(!$logged_in) { ?>
					<div style="font-size:10px;">
						<?php 
								  if (isset($_GET['msg'])) {
								  $msg = mysql_real_escape_string($_GET['msg']);
								  echo "<div class=\"alert alert-error\" style=\"float:left; position:absolute; margin-left:580px; width:320px;\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$msg</div>"; 
								  }	  
						?>
					</div>					
		<div style="float:right;color:#fff;">		
					<table>
					<tr>
					<td> <!-- Login Page starts here -->			
						<ul class="nav secondary-nav session-dropdown" id="session">
							<li class="dropdown js-session">
								<a class="dropdown-toggle dropdown-signin" id="signin-link" href="#" data-nav="login">
								  <small>Have an account?</small> Sign in <span class="caret"></span>
								</a>
										<ul class="dropdown-menu dropdown-form" id="signin-dropdown" >                      
										  <li>
											<form action="login.php" method="post" name="logForm" id="logForm">
												<table style="color:#5D1916; margin:25px;">
													<tr>
													<td>
													Email
													</td>
													<td>
													  <input style="width:175px;" name="usr_email" type="text" id="usr_email" autocomplete="on">
													</td>
													</tr><tr>
													<td>
													Password&nbsp;&nbsp;
													</td>
													<td>
													<input  style="width:175px;" class ="input-medium" name="pwd" type="password" id="pwd">
													</td>
													</tr>
												</table>								
												<div style="font-family:'sans-serif',trebuchet ms,arial; width:auto; padding-left:90px; margin-top:-18px;"><input type="checkbox" value="1" name="remember"><span style="color:#5D1916; width:190px; padding-left:10px;">Remember me</span></div>					
												<div style="width:auto; padding-left:100px;"><input name="doLogin" type="submit" id="doLogin3" value="Login" class="btn btn-medium btn-info" style="width:85px; color:white; border:1px solid #2F96B4;"/></div>
											  <input type="hidden" name="scribe_log">
											  <input type="hidden" name="redirect_after_login" value="/account/complete">
											  <div class="divider"></div>
											 		<a style="font-family:'sans-serif',trebuchet ms,arial; text-decoration:none; color:#CC0000;" href="forgot">Forgot password?</a>
											</form>
										</li>
								   </ul>
						  </li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
<?php } else { ?>
					<ul class="nav">
					  <li <?php echoActive("dashboard")?>><a href="dashboard">My Home</a></li>
					  <li <?php echoActive("trips")?>><a href="trips">Flight Trips</a></li>
					  <li <?php echoActive("trains")?>><a href="trains">Train Trips</a></li>
					  <li <?php echoActive("friends")?>><a href="friends">Friends</a></li>
					  <li <?php echoActive("messages")?>><a href="messages">Messages
		   <?php
				if(isset($_SESSION['new_msg']))
				  unset($_SESSION['new_msg']);
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
						$_SESSION['new_msg'] = $total_unread;
					   if(!isset($_SESSION['new_msg']) || $_SESSION['new_msg'] == null) { print ""; } else { print "<span style = \"font-weight:bold; color:gold;\">"."&nbsp;(".$_SESSION['new_msg'].")&nbsp;<span style=\"font-size:9px;\">New</span>"."</span>"; } ?></a></li>
					 	  <li <?php echoActive("profile")?>><a href="profile">My Profile</a></li>
					</ul>
					<span style="float:right; padding-top:8px; color:#fff;">Welcome <span style="font-size:15px; font-family: 'Montsearsrat Alternates', sans-serif;"><?php 
						$usr_details = mysql_query("select full_name,user_email,user_bday,sex,ccode from users where user_id = '$user_id'");
						$logged_usr = mysql_fetch_array($usr_details);
						echo $logged_usr['full_name']; 
					   ?></span> ! &nbsp;&nbsp;&nbsp;
					<a style="color:#fff; text-decoration:none;" href="logout">Sign out</a></span>
				<?php } ?>					
				  </div><!--/.nav-collapse -->
				</div>
			  </div>
			</div>
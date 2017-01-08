<?php
include("includes/dbc.php");
session_start();
$page_title="My Profile";
include("main_includes.php");
?>
<!-- script for closing alert box div -->
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<script>
  $(document).ready(function() {
	  $("#dp").datepicker();
	});
  </script>
<?php 
$user_id = $_SESSION[user_id];
$rs_settings = mysql_query("SELECT full_name,user_email, ccode, sex, user_bday FROM users where user_id='$user_id'");
if($_POST['doUpdate'] == 'Update')  
{
$rs_pwd = mysql_query("SELECT pwd FROM users where user_id='$user_id'");
list($old) = mysql_fetch_row($rs_pwd);
//check for old password in md5 format
if($old == md5($_POST['pwd_old']))
	{
	if (!checkPwd($_POST['pwd_new'],$_POST['pwd_new2'])) {
		$msg = urlencode("Invalid Password or mismatch.");
		//header("Location: profile.php?msg=$msg");
		//exit();
	}
	else
	{
		$newmd5 = md5($_POST['pwd_new']);
		$sql = mysql_query("UPDATE users SET pwd='" . $newmd5 . "' WHERE user_id='" . $user_id . "'");
		if ($sql) {
				$msg = urlencode("Your new password is updated.");
				//header("Location: profile.php?msg=$msg");
				//exit();
			}
		else {
			$msg = urlencode("You have a problem, Please try again.");
			//header("Location: profile.php?msg=$msg");
			//exit();
		}
	}
	} else
	{
		$msg = urlencode("Your old password is invalid.");
		//header("Location: profile.php?msg=$msg");	 	
	}

}
if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}
mysql_query("UPDATE users SET
			`full_name`='".addslashes($data[full_name])."',
			`user_email`='".addslashes($data[user_email])."',
			`ccode`= '".addslashes($data[country])."',
			`user_bday`= '".addslashes($data[user_bday])."',
			`sex`= '".addslashes($data[sex])."',
			`modified_on` = now()
			 WHERE user_id='$user_id'") or die(mysql_error());			
			$msg = urlencode("Your updates have been saved.");
			//header("Location: profile.php?msg=$msg");	
} 
?>
<body>		
<?php include("navbar.php")?>
<div class="container">
		<p>
			<?php 
			 if ($msg!='') {
			  $err = mysql_real_escape_string($msg);
			  $decode_msg = urldecode($err);
				  if($decode_msg == "Invalid Password or mismatch.")
				  {
					echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
				  }
				   elseif($decode_msg == "Your old password is invalid.") {
					echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
				  }
				  elseif($decode_msg == "Your new password is updated.") {
					echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
				  }
				else {
				  echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>"; 
				  } 
			  }
			?>
			
		</p>
<?php 
if($_POST['deactivate'] == 'Deactivate My Account')  
{
$query = mysql_query("UPDATE users SET is_active = '0' where user_id = '$user_id'");
echo "<div class=\"alert alert-danger\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Your Account has been Deactivated successfully.</div>"; 
}
if($_POST['activate'] == 'Activate My Account')  
{
$query = mysql_query("UPDATE users SET is_active = '1' where user_id = '$user_id'");
echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Your Account has been Activated successfully.</div>"; 
}
?>
<?php 
	if (isset($_GET['msg'])) { 
	$msg = mysql_real_escape_string($_GET['msg']);
	if($msg == "Your updates have been saved.") {
			echo "<div class=\"alert alert-success\">$msg</div>"; }
				elseif($msg == "Your new password is updated.") { echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$msg</div>"; }
				else {  echo "<div class=\"alert alert-error\">$msg</div>"; }
				}
	?>
<div style="float:left; width:46%; min-height:424px;" class="profile">
<?php 
while ($row_settings = mysql_fetch_array($rs_settings)) {  ?>
<form action="profile" method="post" name="myform" id="myform" class="appnitro">
	<h3>My Profile</h3><hr/>
	<table class="profileTbl">
		<tr> 
		<td><label for="user_name">Your Name</label></td>
		<td>
		<input name="full_name" type="text" id="name"  value="<? echo $row_settings['full_name']; ?>"> 
		</td>
		</tr>
		<tr> 
		<td><label for="user_email">User Email</label></td>
		<td>
		<input name="user_email" type="text" id="user_email"   value="<? echo $row_settings['user_email']; ?>" size="30" readonly = "readonly"> 
		</td>
		</tr>
		<tr>
			<td><label for="user_bday">User Birthday</label></td>
			<?php $bday = $row_settings['user_bday']; ?>
			<td class="input-append date" id="dp" data-date="<?php echo $bday;?>" data-date-format="yyyy-mm-dd"><input name="user_bday" type="text" style="width:178px; margin:0px 0px 7px 0px;" value="<?php echo $bday;;?>">&nbsp;<span class="add-on" style="margin:0px 0px 7px 0px;"><i class="icon-th"></i></span></td>
		</tr>
		<tr> 
		<td><label for="country">Country</label></td>
		<td><select name="country" type="text" id="country"> 
			<?php 
			$country_list= mysql_query("Select ccode, country FROM countries ORDER BY country");
			echo "<option value='' selected>------Choose your Country------</option>";
			while($clist = mysql_fetch_array($country_list))
			{
			if($clist['ccode']==$row_settings['ccode'])
			{
			$data1 .= "<option  value='".$clist['ccode']."' selected>".$clist['country']."</option>";
			}
			else 
			{
			$data1 .= "<option  value='".$clist['ccode']."'>".$clist['country']."</option>";
			}
			}
			echo $data1;
			?>		
		</td>
	</tr>
			<tr> 
				<td><label for="sex">Sex</label></td>
				<td><select name="sex" type="text" id="sex"> 
					<?php 
						if($row_settings['sex'] == 1)
							{
							$data2 .= "<option  value='".$row_settings['sex']."' selected>"."Female"."</option>";
							$data2 .= "<option  value='2'>Male</option>";
							}
							elseif($row_settings['sex'] == 2)
							{
							$data2 .= "<option  value='".$row_settings['sex']."' selected>"."Male"."</option>";
							$data2 .= "<option  value='1'>Female</option>";
							} 							
							echo $data2;
					?>
				</td>
			</tr>
</table>
<div style="margin-left:140px;"><input name="doSave" type="submit" id="doSave" value="Save" class="btn btn-success"></div>
</form>
<br/>	
</div>
<!-- Change Password part starts here-->
<div style="float:right; width:46%; min-height:424px;" class="profile"> 
<br/>
<form name="pform" id="pform" method="post" action="profile">
<h3>Change Password</h3><hr/>
<table class="profileTbl">  
      <caption style="text-align:left; margin-bottom:10px;">If you want to change your password, please input your old and new password make changes.</caption>
        <tr> 
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password" minlength="5" ></td>
          </tr>
           <tr> 
            <td>Re-enter New Password</td>
            <td><input name="pwd_new2" type="password" id="pwd_new2" class="required password" minlength="5" equalto="#pwd_new" ></td>
          </tr>
        </table>
		 <div style="margin-left:196px;"> <input name="doUpdate" type="submit" id="doUpdate" value="Update" class="btn btn-success"></div>
		</form>
	
	<!-- Deactivate Account comes here -->
	<hr/><h3>Account Re/De-activation ?</h3><br/>
	<div style="float:right; margin-top:-42px; margin-right:30px;">
		<form name="frm_deactivate" action="profile" method="post">
		<?php 
		$getresult = mysql_query("Select is_active from users where user_id= '$user_id'");
		while($getstatus = mysql_fetch_array($getresult))
		{
		$usr_status = $getstatus['is_active'];
		}		
		if($usr_status == 1) {
		?>
		<input type="submit" name="deactivate" id="deactivate" class="btn btn-small btn-danger" value="Deactivate My Account"/>
		<?php } else { ?>
		<input type="submit" name="activate" id="activate" class="btn btn-small btn-success" value="Activate My Account"/>
		<?php }?>
		</form>
	</div>
		</div> 		
<? } ?> 
<div style="clear:both;"></div>
<br/>
<hr/>
<?php include("footer.php"); ?>
</div>
<?php mysql_close($link);?>
</body>
</html>
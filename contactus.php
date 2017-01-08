<?php
ob_start();
   include 'includes/dbc.php';
   session_start();
   $page_title="Friendsalong Contact";
   include("main_includes.php");
   $user_id = $_SESSION['user_id'];
if(isset($_POST['email'])) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "support@friendsalong.com";
    $email_subject = "Need Help on Friendsalong";
     
     
    function died($error) {
        // your error code can go here
		echo "<div class=\"container\">";
		//echo "<br/>";
		echo "<div style=\"height:415px; text-align:center; font-size:12px; color:#043948; font-family: 'Montsearsrat Alternates', sans-serif;\" class=\"box-signup\">";
		echo "<br/><br/><br/><br/>";
		echo "We are very sorry, but there were error(s) found with the form you submitted. ";
		echo "These errors appear below.<br /><br />";
		echo $error."<br />";
	?>Please <a href="contactus">go back</a> and fix these errors.
		<?php
		echo "</div>";
		echo "</div>";
		$user_id = $_SESSION['user_id'];
		include("navbar.php");
		?>
			<div class="container">
				<hr/>
					 <footer>
						<?php include("footer.php"); ?>
					 </footer>
			</div>
       <?php  exit();
		}
     
    // validation expected data exists
    if(!isset($_POST['full_name']) ||
       !isset($_POST['email']) ||
       !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
    }
     
    $full_name = $_POST['full_name']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['comments']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$full_name)) {
    $error_message .= 'Name you entered does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Contact Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "First Name: ".clean_string($full_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
     
     
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
?>
 
<!-- include your own success html here -->
 <div style="margin:0 auto; width:940px;" class="alert alert-success"><button class="close" data-dismiss="alert" type="button">&times;</button>Thank you for contacting us. We will be in touch with you very soon.</div>							 
<?php
}
?>
<body>
<?php include('navbar.php');?>
<div class="container">
		<div style="font-size:13px; font-family: sans-serif; color:#943367; width:100%; height:415px;"  class="box-signup" >
			<h3 style="color:#812C5A; text-indent:12px;">Contact us</h3><hr/>
			<div style="float:left; width:44%;">
				<form name="contactform" method="post" action="<?php $_SERVER['PHP_SELF'];?>" class="form-vertical appnitro">
				<table class="addmsg">
				<tr>
				 <td valign="top">
				  <label for="full_name">Your Name</label>
				 </td>
				 <td valign="top">
				  <input  type="text" name="full_name" maxlength="50" size="30">
				 </td>
				</tr>
				<tr>
				 <td valign="top">
				  <label for="email" style="width:92px;">Email Address<span style="color:#CC0000; font-size:16px;">*</span></label>
				 </td>
				 <td valign="top">
				  <input  type="text" name="email" maxlength="80" size="30">
				 </td>
				</tr>
				<tr>
				 <td valign="top">
				  <label for="comments">Comments<span style="color:#CC0000; font-size:16px;">*</span></label>
				 </td>
				 <td valign="top">
				  <textarea  name="comments" cols="10" rows="2" style="width:310px; height:120px;"></textarea>
				 </td>
				</tr>
				<tr>
				 <td colspan="2" style="text-align:center; padding-left:94px;">
				  <input type="submit" value="Submit" class="btn btn-success"/>
				 </td>
				</tr>
				</table>
				</form>
			</div>
			<div style="float:right; color:#043948; width:46%; margin-top:40px;"> 
				For further information and inquiries, 
				please fill out the Contact us form. <br/><br/>
				<div style="text-indent:30px;">You might also be intrested giving your valuable suggestions.</div>
				<br/><div style="text-indent:144px;">If so, please do write us.</div>
				<hr/><div style="text-indent:140px;">[ The Friendsalong Team ]</div>
			</div>
	
		</div>
		<div class="clear"></div>
			<hr/>
			 <footer>
       	<?php include("footer.php"); ?>
      </footer>
</div>     
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>
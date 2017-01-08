<?php
include("includes/dbc.php");
session_start();
$page_title="Update Train";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<?php 
$post = (!empty($_POST)) ? true : false;
	if($post)
			{
			foreach($_POST as $key => $value) {
							$_POST[$key] = stripslashes($_POST[$key]);
							$_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
							}		
			$train_id = $_POST["trainID"];
			$train_name = $_POST["train_name"];
			$train_no = $_POST["train_no"];
			$doj = $_POST["date_of_journey"];
			$from_loc = $_POST["from_loc"];
			$to_loc = $_POST["to_loc"];
	
				$error = '';
					// Check name
				if(!$train_name)
					{
						$error .= 'train name';
					}if(!$train_no)
					{
						$error .= ' train no';
					}if(!$doj)
					{
					$error .= ' journey date';
					}if(!$from_loc)
					{
						$error .= ' from locations';
					}if(!$to_loc)
					{
						$error .= ' to locations.<br />';
					}
				
				if($error)
				{
				echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Required: $error</div>";
				}
				else {
					mysql_query("UPDATE trains SET
						`train_name`='$train_name',
						`train_no`='$train_no',
						`date_of_journey`= '$doj',
						`from_loc`= '$from_loc',
						`to_loc`= '$to_loc',
						`modified_on`= now()
						 WHERE user_id = '$user_id' AND train_trip_id = '$train_id'") or die(mysql_error());
			    	//echo '<div class="notification_ok"></div>';
				echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Your trip details has been saved Succesfully.</div>";					
				}
	 }
?>
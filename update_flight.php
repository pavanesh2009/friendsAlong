<?php
include("includes/dbc.php");
session_start();
$page_title="Update Flight";
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
			$flight_id = $_POST["flightID"];
			$airline_name = $_POST["airline_name"];
			$flight_no = $_POST["flight_no"];
			$doj = $_POST["date_of_journey"];
			$from_loc = $_POST["from_loc"];
			$to_loc = $_POST["to_loc"];

			$error = '';
			// Server side Validation
				if(!$airline_name)
					{
						$error .= 'airline name';
					}if(!$flight_no)
					{
						$error .= ' flight no';
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
					mysql_query("UPDATE trip_details SET
									`airline_name`='$airline_name',
									`flight_no`='$flight_no',
									`date_of_journey`= '$doj',
									`from_loc`= '$from_loc',
									`to_loc`= '$to_loc',
									`modified_on`= now()
									 WHERE user_id = '$user_id' AND trip_id = '$flight_id'") or die(mysql_error());
			    	//echo '<div class="notification_ok"></div>';
				echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Your trip details has been saved Succesfully.</div>";					
				}
	 }
?>
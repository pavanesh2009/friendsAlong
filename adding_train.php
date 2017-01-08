<?php
include("includes/dbc.php");
session_start();
$user_id = $_SESSION['user_id'];

	$post = (!empty($_POST)) ? true : false;
	if($post)
		{
					foreach($_POST as $key => $value) {
							$_POST[$key] = stripslashes($_POST[$key]);
							$_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
							}							
							// Assign the input values to variables for easy reference
									$date = $_POST['trip_date'];
									//$user_id = $_SESSION['user_id'];
									$is_deleted = '1';
									$getccode = $_POST['countryID'];
									$train_name = $_POST["train_name"];
									$train_no = $_POST["train_no"];
									$from_loc = $_POST["from_loc"];
									$to_loc = $_POST["to_loc"];
									
									$error = '';
				// Check name
					if(!$train_name)
						{
							$error .= 'I think you forget to enter train name.<br />';
						}
					// Check train_no
					if(!$train_no || strlen($train_no < 2))
						{
							$error .= 'Train number should contain at least 3 characters. <br />';
						}
					if(!$from_loc)
						{
							$error .= 'I think you forget to enter from location.<br />';
						}
					if(!$to_loc)
						{
							$error .= 'I think you forget to enter your to location.<br />';
						}
				if(!$error)
					{
						$sql_insert = "INSERT into `trains`
												(`user_id`,
												 `ccode`,
												 `train_name`, 
												 `train_no`,
												 `date_of_journey`,
												 `from_loc`,
												 `to_loc`,							 
												 `created_on`,
												 `modified_on`,
												 `is_deleted`
												 )
											VALUES
												('$user_id',
												 '$getccode',
												'$train_name',
												'$train_no',
												'$date',
												'$from_loc',
												'$to_loc',									
												now(),
												now(),
												'$is_deleted')";
												//var_dump($sql_insert);									
									mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());		
		//var_dump($result);
if($sql_insert)
	{
	    $ok = "You have added your train trip successfully.";
		echo '<div class="notification_ok">'.$ok.'</div>';
	}
//mysql_close($con);
}
else
	{
		echo '<div class="notification_error">'.$error.'</div>';
	}
}
?>
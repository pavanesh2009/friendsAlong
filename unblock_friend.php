<?php
include("includes/dbc.php");
session_start();
$logged_user = $_SESSION['user_id'];
$uid = $_POST['id'];
$sql_unblock = mysql_query("UPDATE friends SET `is_blocked` = 0 WHERE user_id = '$logged_user' AND frnd_usr_id = '$uid'");
echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>User has been Unblocked successfully.</div>"; 
?>

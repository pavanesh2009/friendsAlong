<?php
include("includes/dbc.php");
session_start();
$logged_user = $_SESSION['user_id'];
$uid = $_POST['id'];
$sql_block = mysql_query("UPDATE friends SET `is_blocked` = 1 WHERE user_id = '$logged_user' AND frnd_usr_id = '$uid'");
echo "<div class=\"alert alert-warning\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>User has been blocked.</div>"; 
?>


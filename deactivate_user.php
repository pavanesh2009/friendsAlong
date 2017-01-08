ss<?php
include("includes/dbc.php");
session_start();
$user_id = $_SESSION[user_id];
$rs_settings = mysql_query("UPDATE users SET status = '0' where user_id = '$user_id'");
mysql_close($link);
?>


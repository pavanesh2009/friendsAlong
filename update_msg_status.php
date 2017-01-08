<?php
include("includes/dbc.php");
session_start();
$logged_user = $_SESSION['user_id'];
$msgID = $_POST['id'];
var_dump($msgID);
$sql_block = mysql_query("UPDATE messages SET `flag` = 'R' WHERE message_id = $msgID AND to_id = '$logged_user'");
echo "<div class=\"alert alert-warning\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>User has been blocked.</div>"; 
if(isset($_SESSION['new_msg']))
  unset($_SESSION['new_msg']);
  $unread_msg = mysql_query("SELECT COUNT(flag) as total_unread FROM messages where flag = 'U' and to_id = '$user_id' and is_deleted = 1");
					list($total_unread) = mysql_fetch_row($unread_msg);
					if ($total_unread > 0)
						$_SESSION['new_msg'] = $total_unread;
?>


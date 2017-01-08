<?php
include("includes/dbc.php");
session_start();
$page_title="Airlines";
include("main_includes.php");

$query = $_POST['query'];
$sql = mysql_query("select AirlineName from airlines where AirlineName like '%{$query}%_'");
while($row = mysql_fetch_assoc($sql))
{
	$array[] = $row['AirlineName'];
}
echo  json_encode($array);
?>

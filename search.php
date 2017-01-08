<?php
include('includes/dbc.php');

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = mysql_query("select ALId, AirlineName from airlines where AirlineName LIKE '%$q%'");
while($rows = mysql_fetch_array($sql))
{
//$array[] = $rows['AirlineName'];
$aname  = $rows['AirlineName'];
$aid = $rows['ALId'];
echo "$aname"."|$aid\n";
}
//echo json_encode($array);
?>

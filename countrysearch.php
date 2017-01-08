<?php
include('includes/dbc.php');

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = mysql_query("select ccode, country from countries where country LIKE '%$q%'");
while($rows = mysql_fetch_array($sql))
{
//$array[] = $rows['AirlineName'];
$cname  = $rows['country'];
$cid = $rows['ccode'];
echo "$cname"."|$cid\n";
}
//echo json_encode($array);
?>

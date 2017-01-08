<?php
include("includes/dbc.php");
session_start();
$page_title="Edit Trips";
include("main_includes.php");
?>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<body>		
<div>
<?php 
$user_id = $_SESSION[user_id];
$trip_id = $_GET['trip_id'];

$rs_settings = mysql_query("SELECT airline_name, flight_no, date_of_journey, from_loc, to_loc FROM trip_details
where user_id='$user_id' AND trip_id = '$trip_id' AND is_deleted = '1'");

if($_POST['doUpdate'] == 'Update')  
{
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}
$choosen_trip_ID = $data[hdntripID];
mysql_query("UPDATE trip_details SET
			`airline_name`='".addslashes($data[airline_name])."',
			`flight_no`='".addslashes($data[flight_no])."',
			`date_of_journey`= '".addslashes($data[date_of_journey])."',
			`from_loc`= '".addslashes($data[from_loc])."',
			`to_loc`= '".addslashes($data[to_loc])."',
			`modified_on`= now()
			 WHERE user_id = '$user_id' AND trip_id = '$choosen_trip_ID'") or die(mysql_error());
//header("Location: trips.php?msg=Your updates have been saved");
 } 
?>

<?php 
while ($row_settings = mysql_fetch_array($rs_settings)) { ?>
<form action="edit_tripdetail.php" method="post" name="myform" id="myform" class="appnitro">
<input type="hidden" name="hdntripID" value="<?=$trip_id;?>"/>
	<h3>Edit Trip Details</h3><hr/>
	<table class="profileTbl">
		<tr> 
		<td><label for="airline_name">Airline Name</label></td>
		<td>
		<input name="airline_name" type="text" id="airline_name" readonly="readonly" value="<? echo $row_settings['airline_name']; ?>"> 
		<span class="example"></span>
		</td>
		</tr>
		<tr> 
		<td><label for="flight_no">Flight No.</label></td>
		<td>
		<input name="flight_no" type="text" id="flight_no"   value="<? echo $row_settings['flight_no']; ?>" size="30"> 
		</td>
		</tr>
		<tr> 
		<td><label for="date_of_journey">Journey Date</label></td>
		<?php $getdate = $row_settings['date_of_journey'];?>
		<td class="input-append date" id="dp" data-date=<?php echo $getdate; ?> data-date-format="yyyy-mm-dd">
			<input name="date_of_journey" type="text" style="width:180px;" value="<?php echo $getdate;?>">
			<span class="add-on"><i class="icon-th"></i></span>
		</td>	
		</tr>
		<tr>
		<td><label for="from_loc">From Location</label></td>
		<td>
		<input type="text"  value="<? echo $row_settings['from_loc']; ?>" name="from_loc"/>
		</td>
		</tr>
		<tr>
		<td><label for="from_loc">To Location</label></td>
		<td>
		<input type="text"  value="<? echo $row_settings['to_loc']; ?>" name="to_loc"/>
		</td>
		</tr>
</table>
<div style="margin-left:145px;"><input name="doUpdate" type="submit" id="doUpdate" value="Update" class="btn btn-success"></div>
</form>
</div>
<? } ?>  
</div>  
</div>
<script src="assets/js/jquery.js"></script> 
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script>
  $(document).ready(function() {
	  $("#dp").datepicker();
  });
  </script>
  <?php //mysql_close($link);?>
</body>
</html>

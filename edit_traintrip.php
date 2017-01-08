<?php
include("includes/dbc.php");
session_start();
$page_title="Edit Trips";
include("main_includes.php");
?>

<script src="assets/js/jquery.js"></script> 
<script src="assets/js/bootstrap-datepicker.js"></script>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script>
  $(document).ready(function() {
	  $("#dp").datepicker();
  });
  </script>
<body>		
<div>
<?php 
$user_id = $_SESSION[user_id];
$train_trip_id = $_GET['train_trip_id'];
//var_dump($train_trip_id);
$rs_settings = mysql_query("SELECT train_name, train_no, date_of_journey, from_loc, to_loc FROM trains
where user_id='$user_id' AND train_trip_id = '$train_trip_id' AND is_deleted = '1'");
?>
<?php 
while ($row_settings = mysql_fetch_array($rs_settings)) { ?>
 <script type="text/javascript">
        $(function() {		
           $("#edittrain-form").submit(function(){
			var str = $(this).serialize();
			var result = null;
			   var scriptUrl = "update_train.php";
					   $.ajax({
						 url: scriptUrl,
						 type: 'post',
						 data: str,
						 dataType: 'html',
						 async: false,
						 success: function(msg) {
							 	 $("#note").ajaxComplete(function(event, request, settings){
									result = msg;
									$(this).hide();
									$(this).html(result).slideDown("slow");
									$(this).html(result);
							 });							 
						 }
					   });
						return false;					   
					});
				});  		
</script>
<form action="" method="post" name="edittrain-form" id="edittrain-form" class="appnitro">
<input type="hidden" name="trainID" id="trainID" value="<? echo $train_trip_id; ?>"/>
<div id="note"></div>
	<h3>Edit Train Details</h3><hr/>
	<table class="profileTbl">
		<tr> 
		<td><label for="train_name">Train Name</label></td>
		<td>
		<input name="train_name" type="text" id="train_name" value="<? echo $row_settings['train_name']; ?>"> 
		<span class="example"></span>
		</td>
		</tr>
		<tr> 
		<td><label for="train_no">Train No.</label></td>
		<td>
		<input name="train_no" type="text" id="train_no" value="<? echo $row_settings['train_no']; ?>" size="30"> 
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
			<div style="margin-left:145px;">
			<input name="doUpdate" type="submit" id="doUpdate" value="Update" class="btn btn-success">
			</div>
</form>
</div>
<? } ?>  
</div>  
</div>
<?php mysql_close($link);?>
</body>
</html>

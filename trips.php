<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Flight Trip";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/thickbox/thickbox.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"/>
<link href="assets/js/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
$().ready(function() {
	$("#query").autocomplete("search.php", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});

	 $("#query").result(function(event, data, formatted) {
     $("#airlineID").val(data[1]);
      });
   	});
</script>
<body>	
<?php include("navbar.php")?>
<div class="container">
          <ul id="TripTabList" class="nav nav-tabs" style="margin:0px auto 12px;">
            <li class="active"><a href="#mytrip" data-toggle="tab">My Flight Trips</a></li>
			<li><a href="#addtrip" data-toggle="tab">Add New Trip</a></li>
            <li><a href="#editdelete" data-toggle="tab">Edit / Delete Flight Trip</a></li>
          </ul>
<div id="myTabContent" class="tab-content trip_form">
	<div class="tab-pane fade in active trip_box" id="mytrip">
	<!-- Mytrip starts here -->
		<!--<div id="msg_delete_nav">
				<ul>
					<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-success" onClick="window.location.href=window.location.href"><i class="icon-refresh icon-white"></i> Refresh</button></li>
				</ul>
			</div>-->
			<table class="table table-striped table-bordered" id="mytripTable">
					<thead>
					<tr class="btn-mini btn-voilet">
						<th>S No.</th>
						<th>Airline Name</th>
						<th>Flight No.</th>
						<th>Journey Date</th>
						<th>From Location</th>
						<th>To Location</th>
						<th style="text-align:center;">Search</th>
					</tr>
					</thead>
					<tbody class="trip_form">
	<?php
	$count=0;
	$trip_info = mysql_query("SELECT trip_details.airline_name,
	trip_details.flight_no, trip_details.date_of_journey, trip_details.from_loc,
	trip_details.to_loc FROM trip_details where user_id = '$user_id' AND is_deleted = '1' ORDER BY trip_id DESC");
	while ($row_settings = mysql_fetch_array($trip_info)) 
					{
						print "<tr>";
						$count++;  
						print "<td>".$count."</td>";
						print "<td>".$row_settings['airline_name']. "</td>";
						print "<td>".$row_settings['flight_no']. "</td>";
						print "<td>".$row_settings['date_of_journey']. "</td>";
						print "<td>".$row_settings['from_loc']. "</td>";
						print "<td>".$row_settings['to_loc']. "</td>";
						?>
					<td style="border:none; padding:8px 0px 0px 0px; text-align:center;">
							<form name="find_mates" action="find_mates" method="POST">
							<input type="hidden" name ="aname" value="<?php echo $row_settings['airline_name'];?>"/>
							<input type="hidden" name ="fnumber" value="<?php echo $row_settings['flight_no'];?>"/>
							<input type="hidden" name ="doj" value="<?php echo $row_settings['date_of_journey'];?>"/>
							<input type="submit" name="search_friends" id="ffinder" class="btn btn-mini btn-success" value="Find Mates"/>
							</form>
					</td>
					<?php
					print "</tr>";
					}
				print "</tbody></table>";
						?>						
				</div><!-- Mytrip ends here -->
				<div class="tab-pane fade in trip_box" id="addtrip">
					<!-- File 2  starts here -->
					<?php
					$date = $_POST['trip_date'];
					$user_id = $_SESSION['user_id'];
					$is_deleted = '1';
					if ($_POST['trip_form']=='Add Trip')
					{
					foreach($_POST as $key => $value) {
						$data[$key] = filter($value);
					}
					if(empty($data['airline_name']) || strlen($data['flight_no']) < 4 || empty($data['from_loc']) ||empty($data['to_loc']))
					{
					$err = urlencode("Oh Snap! Looks like you are missing something. Please note that flight number should contain at least 4 characters.");
					}
					else
					{
					$sql_insert = "INSERT into `trip_details`
								(`airline_name`, 
								 `flight_no`,
								 `date_of_journey`,
								 `from_loc`,
								 `to_loc`,
								 `user_id`,
								 `is_deleted`,
								 `created_on`,
								 `modified_on`
								 )
								VALUES
									('".addslashes($data[airline_name])."',
									'".addslashes($data[flight_no])."',
									'$date',
									'".addslashes($data[from_loc])."',
									'".addslashes($data[to_loc])."',				
									'$user_id',
									'$is_deleted',
									now(),
									now())";
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
					header("Location: trips"); 
					exit();
					}
					}
					?>
		<?php	
		    if ($err!='') {
			  $msg = mysql_real_escape_string($err);
			  $decode_msg = urldecode($msg);
			  ?>
			  <script>
			  $(document).ready(function() {
					$('a[href=#addtrip]').tab('show');
			  });			  
			  </script>
			  <?php
			  echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>$decode_msg</div>";
			  } 
		?> 
<script type="text/javascript">
		function search_validate() {
					if (document.travelForm.airlineID.value=="") {
						alert("Please select an airline name.");
						return false;
					}
					else if (document.travelForm.flight_no.value=="") {
						alert("Please provide your flight number. It should contain at least 4 character.");
						return false;
					}
					else if (document.travelForm.from_loc.value=="") {
						alert("Please provide your from location.");
						return false;
					}
					else if (document.travelForm.to_loc.value=="") {
						alert("Please provide your to location.");
						return false;
					}
					else {
					return true;
					}
				}
</script>
<br/>		
<form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST" name="travelForm" id="travelForm"  class="form-horizontal" onSubmit="return search_validate();">
<input type="hidden" name="airlineID" id="airlineID" value=""/>
	<fieldset>
				<table>
		<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="airline_name">Airline Name <span class="required"><font color="#CC0000">*</font></span></label>
					<div class="controls">
						<input type="text" class="emptyonclick" class="ac_input" name="airline_name" id="query" value="type an airline name" autocomplete="off" delay="1500">
					</div>
			</div>					
		</td>
		<td>				
			<div class="control-group">
					<label class="control-label" for="flight_no">Flight No. <span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input type="text" class="emptyonclick"  name="flight_no" id="flight_no" value="type your flight number"/>
						</div>
				</div>			
		</td></tr>
		<tr><td>		
					<div class="control-group">
						<label class="control-label" for="from_loc">From Location<span class="required"><font color="#CC0000">*</font></span></label>
							<div class="controls">
							<input type="text" class="emptyonclick" name="from_loc" id="from_loc" value="enter a city or airport"/>
							</div>
					</div>
			</td><td>	
					<div class="control-group">
						<label class="control-label" for="to_loc">To Location<span class="required"><font color="#CC0000">*</font></span></label>
							<div class="controls">
							<input type="text" class="emptyonclick" name="to_loc" id="to_loc" value="enter a city or airport"/>
							</div>
					</div>
			</td></tr>
			<tr>
			<td>					
				<div class="control-group">
					<label class="control-label" for="date">Trip Date<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
							<?php $today = date("Y-m-d");?>
							<span class="input-append date" id="dp" data-date="<?php echo $today;?>" data-date-format="yyyy-mm-dd"><input name="trip_date" type="text" readonly = "readonly" style="width:178px; margin:0px 0px 7px 0px;" value="<?php echo $today; ?>"/>&nbsp;<span class="add-on" style="margin:0px 0px 7px 0px;"/><i class="icon-th"></i></span></span>
						</div>
					</div>	
			</td>
			<td style="float:right;"><input type="submit" name="trip_form" value="Add Trip" class="btn btn-info"/></td>
			</tr>
	</table>		
    </fieldset>
</form>
<div style="color:#943367; font-size:13px; font-family: 'Montsearsrat Alternates', sans-serif; text-indent:58px;"><span style="color:red">Note:</span>&nbsp;&nbsp;Please note <span style="color:#CC0000; font-size:16px;">*</span> marked fields are required &amp; flight no. should contain at least four characters.</div>	
</div><!-- File 2 ends here -->	

<div class="tab-pane fade trip_box" id="editdelete">
<!-- File 3 starts here -->	
	<?php
	$display_once = 0;
	for($i=0;$i<count($_POST["chkDel"]);$i++)
		{
		if($_POST["chkDel"][$i] != "")
			{
				$rs_settings = mysql_query("UPDATE trip_details SET is_deleted = '0' WHERE trip_id = '".$_POST["chkDel"][$i]."' 
				AND user_id = '$user_id'");	
				?>
				  <script>
					  $(document).ready(function() {
							$('a[href=#editdelete]').tab('show');
					  });			  
			  </script>
			  <?php
			  if($display_once == 0){			
				echo "<div class=\"alert alert-danger\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Deletion has been performed successfully.</div>"; 
					$display_once++;
				}
			}
		}		
	?>			
	<form name="frmMain"  id="frmMain" action="trips" method="post">
	<div id="trip_delete_nav">  
		<ul>
			<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-danger" onClick="return onDelete();"><i class="icon-trash icon-white"></i> Delete</button></li>
			<li><button id="refresh" name="btnRefreh" class="btn btn-mini btn-success" onClick="window.location.reload();"><i class="icon-refresh icon-white"></i> Refresh</button></li>
        </ul>
	</div>
	<table class="table table-striped table-bordered" id="editTable">
		<thead>
		<tr class="btn-mini btn-voilet">
			<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"></th>
			<th>Airline Name</th>
			<th>Flight No.</th>
			<th>Journey Date</th>
			<th>From Location</th>
			<th>To Location</th>
			<th style="text-align:center;">Edit</th>
		</tr>
		</thead>
		<tbody>
<?php
$count=0;
$trip_info = mysql_query("SELECT trip_details.trip_id, trip_details.airline_name,
trip_details.flight_no, trip_details.date_of_journey, trip_details.from_loc,
trip_details.to_loc FROM trip_details where user_id = '$user_id' AND is_deleted = '1' ORDER BY trip_id DESC");
while ($row_settings = mysql_fetch_array($trip_info)) 
				{
					print "<tr>";
					$count++;  
					//print "<td>".$count."</td>";?>
					<td><input type="checkbox" name="chkDel[]" id="chkDel<?=$count;?>" value="<?=$row_settings["trip_id"];?>"></td>
					<?php
					print "<td style=\"width:120px;\">".$row_settings['airline_name']. "</td>";
					print "<td style=\"width:90px;\">".$row_settings['flight_no']. "</td>";
					print "<td>".$row_settings['date_of_journey']. "</td>";
					print "<td>".$row_settings['from_loc']. "</td>";
					print "<td>".$row_settings['to_loc']. "</td>";
					$edittrip = "<a class=thickbox href=\"edit_flighttrip.php?flight_trip_id=".$row_settings['trip_id']."&TB_iframe=true&height=440&width=700\">Edit</a>";
					print "<td style=\"border:none; padding:13px; text-align:center;\">$edittrip</td>";
					print "</tr>";
				}
				print "</tbody></table>";
?>
<input type="hidden" name="hdnCount" value="<?=$count;?>">
</form>
</div><!-- File 3 ends here -->		
</div>
<hr/>
<?php include("footer.php"); ?>
</div>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-tab.js"></script>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script src="assets/js/thickbox/thickbox.js"></script>
<script type = "text/javascript">
	$(document).ready(function() {
		$("#dp").datepicker();
		$('#editTable').dataTable(
			{
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [0,3,4,5,6] } ],
					"sPaginationType": "bootstrap",
					"oLanguage": {
							"sLengthMenu": "_MENU_ Trips per page"
							},
							 "iDisplayLength": 5,
					"aLengthMenu": [[7, 10, 15], [7, 10, 15]]
			}
		);
			$('#mytripTable').dataTable(
			{
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [2,4,5,6] } ],
					"sPaginationType": "bootstrap",
					"oLanguage": {
							"sLengthMenu": "_MENU_ Trips per page"
							},
							 "iDisplayLength": 5,
					"aLengthMenu": [[7, 10, 15], [7, 10, 15]]
			}
			);
	});
</script>
<script language="JavaScript">
	function ClickCheckAll(vol) {	
	//alert('coming');
	var i=1;
		for(i=1;i<=document.frmMain.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmMain.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmMain.chkDel"+i+".checked=false");
			}
		}
	}
	function onDelete()
	{
	if(confirm('Do you want to delete ?')==true) { 
								return true;
								}
						else {
							return false;
	}
}
</script>
<!--for emptyonclick-->
	<script type="text/javascript" src="assets/js/jquery.emptyonclick.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.emptyonclick').emptyonclick();
	});
	</script>
<script src="assets/js/autocomplete/jquery.autocomplete.js"></script>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>
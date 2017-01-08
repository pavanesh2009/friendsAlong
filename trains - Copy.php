<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Trip Page";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="assets/js/thickbox/thickbox.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"/>
<link href="assets/js/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
$().ready(function() {
	$("#query").autocomplete("countrysearch.php", {
		width: 260,
		matchContains: true,
		selectFirst: false
	});

	 $("#query").result(function(event, data, formatted) {
     $("#countryID").val(data[1]);
      });
   	});
</script>
<body>	
<?php include("navbar.php")?>
<div class="container">
          <ul id="TripTabList" class="nav nav-tabs" style="margin:0px auto 12px;">
            <li class="active"><a href="#mytraintrip" data-toggle="tab">My Train Trips</a></li>
			<li><a href="#addtrip" data-toggle="tab">Add New Trip</a></li>
            <li><a href="#editdelete" data-toggle="tab">Edit / Delete Train Trip</a></li>
          </ul>
<div id="myTabContent" class="tab-content trip_form">
	<div class="tab-pane fade in active trip_box" id="mytraintrip">
	<!-- MyTrain trip starts here -->
		<!--<div id="msg_delete_nav">
				<ul>
					<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-success" onClick="window.location.href=window.location.href"><i class="icon-refresh icon-white"></i> Refresh</button></li>
				</ul>
			</div>-->
			<table class="table table-striped table-bordered" id="mytraintripTable">
					<thead>
					<tr class="btn-mini btn-voilet">
						<th>S No.</th>
						<th>Train Name</th>
						<th>Train No.</th>
						<th>Journey Date</th>
						<th>From Location</th>
						<th>To Location</th>
						<th style="text-align:center;">Search</th>
					</tr>
					</thead>
					<tbody class="trip_form">
	<?php
	$count=0;
	$trip_info = mysql_query("SELECT trains.train_name,
	trains.train_no, trains.date_of_journey, trains.from_loc,
	trains.to_loc FROM trains where user_id = '$user_id' AND is_deleted = '1' ORDER BY train_trip_id DESC");
	while ($row_settings = mysql_fetch_array($trip_info)) 
					{
						print "<tr>";
						$count++;  
						print "<td>".$count."</td>";
						print "<td>".$row_settings['train_name']. "</td>";
						print "<td>".$row_settings['train_no']. "</td>";
						print "<td>".$row_settings['date_of_journey']. "</td>";
						print "<td>".$row_settings['from_loc']. "</td>";
						print "<td>".$row_settings['to_loc']. "</td>";
						?>
					<td style="border:none; padding:8px 0px 0px 0px; text-align:center;">
							<form name="find_train_mates" action="find_train_mates" method="POST">
							<input type="hidden" name ="tname" value="<?php echo $row_settings['train_name'];?>"/>
							<input type="hidden" name ="tnumber" value="<?php echo $row_settings['train_no'];?>"/>
							<input type="hidden" name ="doj" value="<?php echo $row_settings['date_of_journey'];?>"/>
							<input type="submit" name="search_friends" id="ffinder" class="btn btn-mini btn-success" value="Find Train Mates"/>
							</form>
					</td>
					<?php
					print "</tr>";
					}
				print "</tbody></table>";
						?>				
				
				</div><!-- MyTraintrip ends here -->
			<div class="tab-pane fade in trip_box" id="addtrip">
					<!-- File 2  starts here -->
					<?php
					$date = $_POST['trip_date'];
					$user_id = $_SESSION['user_id'];
					$is_deleted = '1';
					$getccode = $_POST['countryID'];
					
					if ($_POST['traintrip_form']=='Add Your Trip')
					{
					foreach($_POST as $key => $value) {
						$data[$key] = filter($value);
					}
					if(empty($data['train_name']) || strlen($data['train_no']) < 4 || empty($data['from_loc']) ||empty($data['to_loc']))
					{
					$err = urlencode("Oh Snap! Looks like you are missing something. Please note that train number should contain at least 4 characters.");
					}
					else
					{
					$sql_insert = "INSERT into `trains`
								(`user_id`,
								 `ccode`,
								 `train_name`, 
								 `train_no`,
								 `date_of_journey`,
								 `from_loc`,
								 `to_loc`,							 
								 `created_on`,
								 `modified_on`,
								 `is_deleted`
								 )
								VALUES
									('$user_id',
									 '$getccode',
									'".addslashes($data[train_name])."',
									'".addslashes($data[train_no])."',
									'$date',
									'".addslashes($data[from_loc])."',
									'".addslashes($data[to_loc])."',									
									now(),
									now(),
									'$is_deleted')";
									//var_dump($sql_insert);									
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());					
					header("Location: trains"); 
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
					if (document.traintravelForm.countryID.value=="") {
						alert("Please provide a country name.");
						return false;
					}
					else if (document.traintravelForm.train_name.value=="") {
						alert("Please provide your train name.");
						return false;
					}
					else if (document.traintravelForm.train_no.value=="") {
						alert("Please provide your train number. It should contain at least 3 character.");
						return false;
					}
					else if (document.traintravelForm.from_loc.value=="") {
						alert("Please provide your from location.");
						return false;
					}
					else if (document.traintravelForm.to_loc.value=="") {
						alert("Please provide your to location.");
						return false;
					}
					else {
					return true;
					}
				}
</script>
<br/>		
<form action="<?php $_SERVER['PHP_SELF']; ?>"  method="POST" name="traintravelForm" id="traintravelForm"  class="form-horizontal" onSubmit="return search_validate();">
<input type="hidden" name="countryID" id="countryID" value=""/>
	<fieldset>
				<table>
				<tr>
					<td>					
						<div class="control-group">
						<label class="control-label" for="country_name">Country Name <span class="required"><font color="#CC0000">*</font></span></label>
							<div class="controls">
								<input type="text" class="emptyonclick" class="ac_input" name="country_name" id="query" value="type a country name" autocomplete="off" delay="1500">
							</div>
					</div>
					</td>
					<td>					
				<div class="control-group">
					<label class="control-label" for="date">Trip Date<span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
							<?php $today = date("Y-m-d");?>
							<span class="input-append date" id="dp" data-date="<?php echo $today;?>" data-date-format="yyyy-mm-dd"><input name="trip_date" type="text" readonly = "readonly" style="width:178px; margin:0px 0px 7px 0px;" value="<?php echo $today; ?>"/>&nbsp;<span class="add-on" style="margin:0px 0px 7px 0px;"/><i class="icon-th"></i></span></span>
						</div>
					</div>	
			</td>			
				</tr>
		<tr>
		<td>
			<div class="control-group">
				<label class="control-label" for="train_name">Train Name <span class="required"><font color="#CC0000">*</font></span></label>
					<div class="controls">
						<input type="text" class="emptyonclick" class="ac_input" name="train_name" id="query" value="type your train name" autocomplete="off" delay="1500">
					</div>
			</div>					
		</td>
		<td>				
			<div class="control-group">
					<label class="control-label" for="train_no">Train No. <span class="required"><font color="#CC0000">*</font></span></label>
						<div class="controls">
						<input type="text" class="emptyonclick"  name="train_no" id="train_no" value="type your train number"/>
						</div>
				</div>			
		</td></tr>
		<tr><td>		
					<div class="control-group">
						<label class="control-label" for="from_loc">From Location<span class="required"><font color="#CC0000">*</font></span></label>
							<div class="controls">
							<input type="text" class="emptyonclick" name="from_loc" id="from_loc" value="enter from location"/>
							</div>
					</div>
			</td><td>	
					<div class="control-group">
						<label class="control-label" for="to_loc">To Location<span class="required"><font color="#CC0000">*</font></span></label>
							<div class="controls">
							<input type="text" class="emptyonclick" name="to_loc" id="to_loc" value="enter to location"/>
							</div>
					</div>
			</td></tr>
		</table>
<div style="text-align:center; padding-right:125px;"><input type="submit" name="traintrip_form" value="Add Your Trip" class="btn btn-medium btn-info"/></div>
    </fieldset>
</form>
<div style="color:#943367; font-size:13px; font-family: 'Montsearsrat Alternates', sans-serif; text-indent:58px;"><span style="color:red">Note:</span>&nbsp;&nbsp;Please note <span style="color:#CC0000; font-size:16px;">*</span> marked fields are required &amp; train no. should contain at least four characters.</div>	
</div><!-- File 2 ends here -->	

<div class="tab-pane fade trip_box" id="editdelete">
<!-- File 3 starts here 
<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;File 3 comes here</h1>
-->	
<?php
	$display_once = 0;
	for($i=0;$i<count($_POST["chkDel"]);$i++)
		{
		if($_POST["chkDel"][$i] != "")
			{
				$rs_settings = mysql_query("UPDATE trains SET is_deleted = '0' WHERE train_trip_id = '".$_POST["chkDel"][$i]."' 
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
	<form action="<?php $_SERVER['PHP_SELF']; ?>" name="edittrainfrm"  id="edittrainfrm" method="post">
	<div id="trip_delete_nav">  
		<ul>
			<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-danger" onClick="return onDelete();"><i class="icon-trash icon-white"></i> Delete</button></li>
			<li><button id="refresh" name="btnRefreh" class="btn btn-mini btn-success" onClick="window.location.reload();"><i class="icon-refresh icon-white"></i> Refresh</button></li>
        </ul>
	</div>
	<table class="table table-striped table-bordered" id="edittrainTable">
		<thead>
		<tr class="btn-mini btn-voilet">
			<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"></th>
			<th>Country</th>
			<th>Train Name</th>
			<th>Train No.</th>
			<th>Journey Date</th>
			<th>From Location</th>
			<th>To Location</th>
			<th style="text-align:center;">Edit</th>
		</tr>
		</thead>
		<tbody>
<?php
$count=0;
$trip_info = mysql_query("SELECT trains.train_trip_id, trains.train_name,trains.ccode,
trains.train_no, trains.date_of_journey, trains.from_loc,
trains.to_loc FROM trains where user_id = '$user_id' AND is_deleted = '1' ORDER BY train_trip_id DESC");
while ($row_settings = mysql_fetch_array($trip_info)) 
				{
					print "<tr>";
					$count++;  
					//print "<td>".$count."</td>";?>
					<td><input type="checkbox" name="chkDel[]" id="chkDel<?=$count;?>" value="<?=$row_settings["train_trip_id"];?>"></td>
					<?php
					print "<td >".$row_settings['ccode']. "</td>";
					print "<td style=\"width:120px;\">".$row_settings['train_name']. "</td>";
					print "<td style=\"width:90px;\">".$row_settings['train_no']. "</td>";
					print "<td>".$row_settings['date_of_journey']. "</td>";
					print "<td>".$row_settings['from_loc']. "</td>";
					print "<td>".$row_settings['to_loc']. "</td>";
					$edittrip = "<a class=thickbox href=\"edit_traintrip.php?train_trip_id=".$row_settings['train_trip_id']."&TB_iframe=true&height=440&width=700\">Edit</a>";
					print "<td style=\"border:none; padding:13px; text-align:center;\">$edittrip</td>";
					print "</tr>";
				}
				print "</tbody></table>";
?>
<input type="hidden" name="hdnCount" value="<?=$count;?>">
</form>
</div>
</div><!-- File 3 ends here -->		
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
		$('#edittrainTable').dataTable(
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
		$('#mytraintripTable').dataTable(
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
<?php
include("includes/dbc.php");
session_start();
$page_title="Find Mates";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
?>
<script src="assets/js/bootstrap-alert.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"/>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script>
$(document).ready(function() {
		$('#findmate').dataTable(
	{
	"aoColumnDefs": [ { "bSortable": false, "aTargets": [1,2,3,4,5,6,7] } ],
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ mates per page"
		},
		"iDisplayLength": 5,
		"aLengthMenu": [[7, 10, 15], [7, 10, 15]]
	});
});
</script>      
	 <script type="text/javascript">
        $(function() {
           var tr = $('#findmate').find('tr');
			//alert(tr);			
			$('tr').bind('click', function() {
                    name = $(this).children('td').eq(0).text();
					var selectedValue = $(this).children('td').eq(7).text();
					 	    }
						);
			$('#addfriend').live('click', function() {
						   var result = null;
						   var scriptUrl = "add_friends.php";
								   $.ajax({
									 url: scriptUrl,
									 type: 'post',
									 data: ({frndname : name}),
									 dataType: 'html',
									 async: false,
									 success: function(data) {
										 result = data;
										 document.getElementById('msg').innerHTML = result;
									 }
								   });
								    }
						);
					});  		
</script>
<body>
<?php include("navbar.php")?>
<div class="container">
<div style="margin-top:10px; min-height:370px;">
<div id="msg"></div><br/>
<?php
$airliner = $_POST['aname'];
$flight_number = $_POST['fnumber'];
$doj = $_POST['doj'];
$usr_info = mysql_query("SELECT u.user_id, u.is_active, u.full_name, u.sex, u.ccode,
t.airline_name, t.date_of_journey, t.flight_no, t.from_loc, t.to_loc
FROM users u
JOIN trip_details t ON u.user_id = t.user_id
WHERE flight_no = '$flight_number'
AND airline_name = '$airliner'
AND is_active = '1'
AND date_of_journey = '$doj'
AND u.user_id <>'$user_id'");
if(mysql_num_rows($usr_info))
{
?>
		<table class="table table-striped table-bordered" id="findmate">
		<thead>			
			<tr class="btn-mini btn-info">
				<th>Name</th>
				<th>Airline Name</th>
				<th>Flight No.</th>
				<th>Journey Date</th>
				<th>From Location</th>
				<th>To Location</th>			
				<th style="text-align:center; width:220px;">Conversation</th>			
				<th style="text-align:center; width:220px;">Action</th>
		</tr>
		</thead>
		<tbody>
<?php
while ($row_settings = mysql_fetch_array($usr_info)) 
				{
					print "<tr>";
					print "<td>".$row_settings['full_name']. "</td>";
					print "<td>".$row_settings['airline_name']. "</td>";
					print "<td>".$row_settings['flight_no']. "</td>";
					print "<td>".$row_settings['date_of_journey']. "</td>";
					print "<td>".$row_settings['from_loc']. "</td>";
					print "<td>".$row_settings['to_loc']. "</td>";
					$userID = $row_settings['user_id'];
				?>				
				<td style="text-align:center;"><a style="text-decoration:none;"  class="btn btn-small btn-success" href="addmessage.php?userID=<?php echo $userID; ?>">Send Message</a></td>
				<td style="text-align:center;"><a id="addfriend" class="btn btn-small btn-success" style="margin-right:110px; float:right;">Add as Friend</a></td>
				<?php
				print "</tr>";
				}
				print "</tbody></table>";
				} else { ?>
				<div style=" color:red; width:950px; border:1px dotted #3c3c3c; margin:0 auto; text-align:center; padding:10px 0px;">
					No Matching Found !
				</div>
				<?php
				}
?><br/>
<input type="button" name="back" value="Go Back To Trip Page" class="btn btn-small btn-info" style="margin-right:30px; float:right;" OnClick="history.go(-1)"/>
</div>
<br/><br/><hr/>
<?php 
include("footer.php"); 
mysql_close($link);
?>
</div>
</body>
</html>
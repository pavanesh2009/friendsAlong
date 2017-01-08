<?php
include("includes/dbc.php");
session_start();
$page_title="Friends";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"/>
<?php $usrID = $_POST['userID']; ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#friendTable').dataTable(
	{
	"aoColumnDefs": [ { "bSortable": false, "aTargets": [0,3] } ],
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ Friends per page"
			},
			"iDisplayLength": 5,
		    //"aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
			"aLengthMenu": [[7, 10, 15], [7, 10, 15]]
		}
	);
	// For Blocking a friend	
	$('table#friendTable td span.delete').click(function()
		{
			if (confirm("Are you sure you want to block this user?"))
			{
				var id = $(this).parent().parent().attr('id');
				var data = 'id=' + id ;
				//alert(data);
				var parent = $(this).parent().parent();
				$.ajax(
					{
					   type: "POST",
					   url: "block_friend.php",
					   data: data,
					   cache: false,					
					   success: function(data)
					   {
							document.getElementById('msg').innerHTML = data;
							//parent.fadeOut('slow', function() {$(this).remove();});
					   }
					});	
				}
			});	
			
			//For Unblocking a friend
	$('table#friendTable td span.update').click(function()
		{
			if (confirm("Are you sure you want to block this user?"))
			{
				var id = $(this).parent().parent().attr('id');
				var data = 'id=' + id ;
				//alert(data);
				var parent = $(this).parent().parent();
				$.ajax(
					{
					   type: "POST",
					   url: "unblock_friend.php",
					   data: data,
					   cache: false,					
					   success: function(data)
					   {
						 document.getElementById('msg').innerHTML = data;					
					   }
					});	
				}
			});	
			
			
			
	});
</script>
<body>
<?php include("navbar.php")?>
<div class="container">
   <ul id="FriendsTabList" class="nav nav-tabs">
            <li class="active"><a href="#Friends" data-toggle="tab">My Friends</a></li>
   </ul>
  <div id="myTabContent" class="tab-content profile">
  <div class="tab-pane fade in active trip_box" id="mytrip" style="min-height:377px; margin-top:-6px;">
	<div id="msg"></div>
		<div id="msg_delete_nav">
				<ul>
					<li><button id="refresh" name="btnrefresh" type="submit" class="btn btn-mini btn-success" onClick="window.location.href=window.location.href"><i class="icon-refresh icon-white"></i> Refresh</button></li>
				</ul>
			</div>
			<table class="table table-striped table-bordered" id="friendTable">
					<thead>
					<tr class="btn-mini btn-voilet">
						<!--<th>S No.</th>-->
						<th style="text-align:center;">Friend's Pic</th>						
						<th style="text-align:center;">Send a Message</th>
						<th style="text-align:center;">Was added</th>						
						<th style="text-align:center;">Action</th>
					</tr>
					</thead>
					<tbody>
	<?php
	//$count=0;
	$frnd_info = mysql_query("SELECT users.user_id, users.full_name, users.sex, users.img_name, friends.created_on, friends.is_blocked FROM friends 
							  JOIN users ON users.user_id = friends.frnd_usr_id AND friends.user_id = '$user_id' 
							  ORDER BY friends_id DESC");
	while ($frnd_list = mysql_fetch_array($frnd_info)) 
					{
						?>
			<tr id="<?php echo $frnd_list['user_id'];?>">
				<td style="text-align:center;">
					<?php 
						$sex = $frnd_list['sex'];
						$img_name = $frnd_list['img_name'];
							if(isset($img_name)) { ?>
								<img src="picture/<?php echo $img_name; ?>" alt="male" height="50" width="50">
								<?php } elseif($sex == 2 && $img_name == null) { echo "<img src=\"picture/default_male.jpg\" width=50 height=50>"; ?>
								<?php } else { echo "<img src=\"picture/default_female.jpg\" width=50 height=50>";?>
								<?php } ?>		
					<?php
						print "<td style=\"text-align:center; padding-top:20px;\"><a href=\"addmessage.php?userID=".$frnd_list['user_id']."\">".$frnd_list['full_name']." "."<i class=\"icon-pencil icon-black\"></i>"."</a></td>";
						print "<td style=\"text-align:center; padding-top:20px;\">".$frnd_list['created_on']. "</td>";
					?>
				<td style="text-align:center;padding-top:20px;">
						<?php
						if($frnd_list['is_blocked'] == 0) { ?>
							<span class="delete"><button class="btn btn-mini btn-danger"><i class="icon-lock icon-white"></i> Block</button></span>					
						<?php } else { ?>
							<span class="update"><button class="btn btn-mini btn-success"><i class="icon-user icon-white"></i> Unblock</button></span>					
						<?php } ?>
				</td>
				<?php
	print "</tr>";
	}
	print "</tbody></table>";
?>						
</div>
</div>
<hr/>
<?php 
include("footer.php"); 
mysql_close($link);
?>
				</div>
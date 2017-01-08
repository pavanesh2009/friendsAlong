<?php
include("includes/dbc.php");
session_start();
$page_title="Messages";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-tab.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.timeago.js"></script>
<script type="text/javascript">
   jQuery(document).ready(function() {
     $("td.gettime").timeago();
   });
</script>
<link rel="stylesheet" type="text/css" href="assets/css/DT_bootstrap.css"/>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script>
$(document).ready(function() {
	$('#inboxTable').dataTable(
	{
	"aoColumnDefs": [ { "bSortable": false, "aTargets": [0,1,3] } ],
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ messages per page"
		},
				"iDisplayLength": 7,
				//"aLengthMenu": [[7, 10, 20, -1], [7, 10, 20, "All"]]
				"aLengthMenu": [[7, 10, 15], [7, 10, 15]]
	}
	);
		$('#sentTable').dataTable(
	{
	"aoColumnDefs": [ { "bSortable": false, "aTargets": [0,2] } ],
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ messages per page"
		},
				 "iDisplayLength": 7,
				 "aLengthMenu": [[7, 10, 15], [7, 10, 15]]
	}
	);
} );
</script>
<script language="JavaScript">
	function ClickCheckAll(vol) {	
	var i=1;
		for(i=1;i<=document.frmInbox.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmInbox.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmInbox.chkDel"+i+".checked=false");
			}
		}
		for(i=1;i<=document.frmSent.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.frmSent.chkDel"+i+".checked=true");
			}
			else
			{
				eval("document.frmSent.chkDel"+i+".checked=false");
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
<style>
.highlight {font-weight:bold;}
.normal {font-weight:normal;}
</style>
<script>
$(document).ready(function() {
var tr = $('#inboxTable').find('tr');
			//alert(tr);
		$('tr').bind('click', function() {
		var MSGID = $(this).children('td').eq(1).text();
		//alert(name);		
		$(this).removeClass("highlight");
		$(this).addClass("normal");
		$.ajax({
		   type: "POST",
		   url: "update_msg_status.php",
		   data: ({id : MSGID}),
		   dataType: 'html',
		   async: false
			});
			});
});
</script>
<body>		
<?php include("navbar.php")?>
<div class="container">
          <ul id="myTab" class="nav nav-tabs" style="margin:0px auto 12px;">
				<li class="active"><a href="#inbox" data-toggle="tab">Inbox</a></li>
				<li><a href="#sent_messages" data-toggle="tab">Sent Items</a></li>
          </ul>
<div id="myTabContent" class="tab-content trip_form">				
<div class="tab-pane fade in active msg_box" id="inbox">
		<?php
				if(isset($_POST["chkDel"])){
				for($i=0;$i<count($_POST["chkDel"]);$i++)
							{
								if($_POST["chkDel"][$i] != "")
								{
								$del_message_id = $_POST["chkDel"][$i];
								//var_dump($del_message_id);
									$sql_insert = "INSERT INTO `msg_status`
									(`message_id`,
									 `user_id`
									)
									VALUES('$del_message_id', '$user_id ')";
									mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());									
								}																
							}
					echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Message has been deleted Successfully.</div>"; 							
					}
					else{
					echo "";
					}
			?>
<!-- <h3>file 1</h3> Inbox File starts here. -->
<form name="frmInbox" action="messages" method="post">
			<div id="msg_delete_nav">  
				<ul>
					<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-danger" onClick="return onDelete();"><i class="icon-trash icon-white"></i> Delete</button></li>
				</ul>
			</div>
		<table class="table table-striped table-bordered" id="inboxTable">
			<thead>
			<tr class="btn-mini btn-voilet">
			<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"></th>
				<th style="display:none;">meg_id</th>
				<th>Sender</th>
				<th>Subject</th>
				<th>Sent on</th>
			</tr>
			</thead>
		<tbody>
			<?php
				$count=0;
				$inbox_list = mysql_query("SELECT u.user_id, u.full_name, m.message_id, m.title, m.body, m.created, m.flag
												FROM messages m
												JOIN users u ON m.from_id = u.user_id
												WHERE m.to_id ='$user_id'
												AND m.message_id NOT
												IN (
												SELECT ms.message_id
												FROM msg_status ms
												WHERE ms.user_id ='$user_id'
												)
												AND m.message_id NOT
												IN (
												SELECT m1.message_id
												FROM messages m1
												JOIN friends f1 ON m1.to_id = f1.user_id
												WHERE is_blocked =1
												AND m1.created >= f1.modified_on
												AND f1.frnd_usr_id = m1.from_id
												AND m.message_id = m1.message_id 
												AND f1.frnd_usr_id = m.from_id
												)
												ORDER BY m.created DESC");
				while ($inbox_rows = mysql_fetch_array($inbox_list)) 
				{
				print "<tr>";
				$count++; ?>
					<td style="width:20px;">
						<input type="checkbox" name="chkDel[]" id="chkDel<?=$count;?>" value="<?=$inbox_rows["message_id"];?>">
					</td>
					<?php
					$unread_msg = mysql_query("SELECT COUNT( flag ) AS total_unread
												FROM messages m
												WHERE flag = 'U'
												AND to_id = '$user_id'
												AND is_deleted =1
												AND m.message_id NOT
												IN (SELECT m1.message_id
												FROM messages m1
												JOIN friends f1 ON m1.to_id = f1.user_id
												WHERE is_blocked =1
												AND m1.created >= f1.modified_on
												AND f1.frnd_usr_id = m1.from_id
												AND m.message_id = m1.message_id
												AND f1.frnd_usr_id = m.from_id
												)");
					list($total_unread) = mysql_fetch_row($unread_msg);
					if ($total_unread > 0)
						$_SESSION['new_msg'] = $total_unread;
					//var_dump($_SESSION['new_msg']);
						print "<td style=\"display:none;\">".$inbox_rows['message_id']."</td>";
						print "<td style=\"width:102px;\">".$inbox_rows['full_name']."</td>";
						//print "<td><a href=\"replyMessage.php?userID=".$inbox_rows['user_id']."\">".$inbox_rows['full_name']."</a></td>";
						if($inbox_rows['flag'] == 'U')
						{
						print "<td id = \"msgTD\" class =\"highlight\" style=\"width:310px;\">".$inbox_rows['title']."<span style=\"float:right\">"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."["."<a style=\"text-decoration:none;\"href=\"replyMessage.php?userID=".$inbox_rows['user_id']."&msgID=".$inbox_rows['message_id']."\"><i class=\"icon-envelope\"></i> Read <i class=\"icon-retweet\"></i> Reply</a>"."]"."</span>"."</td>";
						} else {
						print "<td id = \"msgTD\" class =\"normal\" style=\"width:310px;\">".$inbox_rows['title']."<span style=\"float:right\">"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."["."<a style=\"text-decoration:none;\"href=\"replyMessage.php?userID=".$inbox_rows['user_id']."&msgID=".$inbox_rows['message_id']."\"><i class=\"icon-envelope\"></i> Read <i class=\"icon-retweet\"></i> Reply</a>"."]"."</span>"."</td>";
						}								
						?>
					<td style="width:130px;" class="gettime" title="<?php echo $inbox_rows['created']; ?>"></td>
					<?php
						print "</tr>";
				}
				print "</tbody></table>";				
			?>
<input type="hidden" name="hdnCount" value="<?=$count;?>"/>
</form>
<!-- Inbox file ends here. -->
</div>				
<div class="tab-pane fade msg_box" id="sent_messages">
			<!-- <h3>file 2</h3> Sent Message file starts here. -->
<form name="frmSent" action="messages" method="post">
			<div id="msg_delete_nav">
				<ul>
					<li><button id="delete" name="btnDelete" type="submit" class="btn btn-mini btn-danger" onClick="return onDelete();"><i class="icon-trash icon-white"></i> Delete</button></li>
				</ul>
			</div>
    <table class="table table-striped table-bordered" id="sentTable">
		<thead>
			<tr class="btn-mini btn-voilet">
			<th><input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);"></th>
				<th>Recepient</th>
				<th>Subject</th>
				<th>Sent on</th>
			</tr>
		</thead>
		<tbody>
<?php
$count=0;
$sent_list = mysql_query("SELECT u.user_id, u.full_name, m.message_id, m.title, m.body, m.created, m.flag
										FROM messages m	JOIN users u ON m.to_id = u.user_id
										WHERE m.from_id = '$user_id' AND m.message_id NOT IN(Select ms.message_id from 
										msg_status ms where ms.user_id = '$user_id') ORDER BY m.created DESC");
				while ($sent_rows = mysql_fetch_array($sent_list)) 
				{
					print "<tr>";
					$count++;  ?>
					<td style="width:20px;">
						<input type="checkbox" name="chkDel[]" id="chkDel<?=$count;?>" value="<?=$sent_rows["message_id"];?>">
					</td>
					<?php
						print "<td style=\"width:102px;\">".$sent_rows['full_name']."</td>";
						//print "<td><a href=\"addmessage.php?userID=".$sent_rows['user_id']."\">".$sent_rows['full_name']."</a></td>";
						print "<td style=\"width:310px;\">".$sent_rows['title']."<span style=\"float:right\">"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."["."<a style=\"text-decoration:none;\"href=\"addmessage.php?userID=".$sent_rows['user_id']."&msgID=".$sent_rows['message_id']."\"><i class=\"icon-envelope\"></i> Read <i class=\"icon-retweet\"></i> Resend</a>"."]"."</span>"."</td>";
					?>
					<td style="width:130px;" class="gettime" title="<?php echo $sent_rows['created']; ?>"></td>
					<?php
					print "</tr>";
				}
				print "</tbody></table>";				
				?>
	<input type="hidden" name="hdnCount" value="<?=$count;?>">
</form>	
<!-- Sent Message File starts here. -->
</div>
</div>
<br/><hr/>
<?php 
include("footer.php"); 
mysql_close($link);
?>
</div>
</body>
</html>
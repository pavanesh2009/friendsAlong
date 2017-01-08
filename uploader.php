<?php
include("includes/dbc.php");
session_start();
$page_title="Image Uploader";
include("main_includes.php");
$user_id = $_SESSION[user_id];
?>
<script src="assets/js/bootstrap-datepicker.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<body>		
<div class="container" style="font-family: 'Montsearsrat Alternates', sans-serif;">
<br/><h3>Upload Image</h3><hr/>
<!--Image Upload starts here-->
<?php
if ($_POST['doupload_form']=='Upload') {
$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["uploaded_pic"]["name"]));
if ((($_FILES["uploaded_pic"]["type"] == "image/gif")
|| ($_FILES["uploaded_pic"]["type"] == "image/jpeg")
|| ($_FILES["uploaded_pic"]["type"] == "image/jpg")
|| ($_FILES["uploaded_pic"]["type"] == "image/png")
|| ($_FILES["uploaded_pic"]["type"] == "image/pjpeg"))
&& ($_FILES["uploaded_pic"]["size"] < 1048576)
&& in_array($extension, $allowedExts))
  {
  //var_dump($_FILES["uploaded_pic"]["name"]);
  if ($_FILES["uploaded_pic"]["error"] > 0)
    {
	    echo "Return Code: " . $_FILES["uploaded_pic"]["error"] . "<br />";
    }
  else
    {
	echo "<div class=\"alert alert-success\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Your image has been uploaded successfully.</div>"; 
		$_FILES["uploaded_pic"]["name"] = $user_id.".".$extension;    
		move_uploaded_file($_FILES["uploaded_pic"]["tmp_name"],
		"picture/" . $_FILES["uploaded_pic"]["name"]);
		//echo "Stored in: " . "picture/" . $_FILES["uploaded_pic"]["name"];
		// Image assignment to teh User
		$uploaded_img = $_FILES["uploaded_pic"]["name"];
		$sql_update = ("update `users` set img_name = '$uploaded_img' where user_id = '$user_id'");
		//var_dump($sql_update);
		//exit;
		mysql_query($sql_update,$link) or die("Insertion Failed:" . mysql_error());		
    }
  }
else
  {  
 //echo "<br/>";
  echo "<div class=\"alert alert-error\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>Hey! Looks like Either you have not chosen a valid Image OR particular Image type is not being supported. Please try again.</div>"; 
  }
  } else {
	echo "";		
	}
?>
	<form action="uploader.php"  method="post"  enctype="multipart/form-data" class="appnitro">		
			<table class="profileTbl">
				<tr> 
					<td><label for="uploaded_pic">Choose and upload Image</label></td>
					<td><input name="uploaded_pic" type="file" id="uploaded_pic"></td>
				</tr>
			</table>
<div style="margin-left:220px;"><input name="doupload_form" type="submit" id="doUpload" value="Upload" class="btn btn-success"></div>
	</form>
<div>Note<span class="required"><font color="#CC0000">*</font></span> : Hey there! As of now we are supporting following image formats 
<ul>
<br/>
<li>jpg</li>
<li>png</li>
<li>gif</li>
</ul>
<br/>
Also, please make sure that image size should not exceed size of 1 MB.  
</div>	
</div>
</body>
</html>

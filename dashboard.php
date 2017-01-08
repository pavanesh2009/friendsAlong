<?php
include("includes/dbc.php");
session_start();
$page_title="DashBoard";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<style type = "text/css">
    #badges {
    color: white;
    font-size: 14px;
    font-style: italic;
    font-weight: bold;
    line-height: 22px;
    padding-top:42px;
}
 
.badge-label {
    margin-top: 32px;
}
 
#badges ul {
    list-style-type: none;
}
#badges li {
    background: none repeat scroll 0 0 #EEEEEE;
    border-radius: 999px 999px 999px 999px;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
    color: #444444;
    float: left;
    height: 85px;
    margin-left: 10px;
    text-align: center;
    text-shadow: 0 2px 1px white;
    width: 85px;
}
.borderbox {
    border-radius: 18px 18px 18px 18px;
	border: 1px solid #E4E4E4;
    padding: 7px 10px 7px 3px;
	text-align:center;
}
.effectbox {
    border-radius: 18px 18px 18px 18px;
	border: 1px solid #E4E4E4;
    padding: 14px 10px 14px 40px;
	text-align:center;
}
  </style>
<body>		
<?php include("navbar.php");
if(isset($_SESSION['new_msg']))
  unset($_SESSION['new_msg']);
 $unread_msg = mysql_query("SELECT COUNT(flag) as total_unread FROM messages m where flag = 'U' and to_id = '$user_id' and is_deleted = 1 
					AND m.message_id NOT IN (SELECT m1.message_id
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
?>
<style type = "text/css">
.ib-container{
	width:980px;
	position: relative;
	margin: 30px auto;
	display: block;	
	/*background:#DBEAF9;*/
}
.ib-container:before,
.ib-container:after {
    content:"";
    display:table;
}
.ib-container:after {
    clear:both;
}
.ib-container article{
	display: block;
	width: 210px;
	height: 190px;
	background: #fff;
	cursor: pointer;
	float: left;
	/*border: 10px solid #fff;*/
	text-align: left;
	text-transform: none;
	margin: 15px;
	z-index: 1;
	
	-webkit-backface-visibility: hidden;
	box-shadow: 
		/*commented to stop shadow
		0px 0px 0px 10px rgba(255,255,255,1), 
		1px 1px 3px 10px rgba(0,0,0,0.2);
		*/
	-webkit-transition: 
		opacity 0.4s linear, 
		-webkit-transform 0.4s ease-in-out, 
		box-shadow 0.4s ease-in-out;
	-moz-transition: 
		opacity 0.4s linear, 
		-moz-transform 0.4s ease-in-out, 
		box-shadow 0.4s ease-in-out;
	-o-transition: 
		opacity 0.4s linear, 
		-o-transform 0.4s ease-in-out, 
		box-shadow 0.4s ease-in-out;
	-ms-transition: 
		opacity 0.4s linear, 
		-ms-transform 0.4s ease-in-out, 
		box-shadow 0.4s ease-in-out;
	transition: 
		opacity 0.4s linear, 
		transform 0.4s ease-in-out, 
		box-shadow 0.4s ease-in-out;
	

}
.ib-container h3 a{
	font-size: 16px;
	font-weight: 400;
	color: #000;
	color: rgba(0, 0, 0, 1);
	text-shadow: 0px 0px 0px rgba(0, 0, 0, 1);
	opacity: 0.8;
}
.ib-container article header span{
	font-size: 11px;
	padding: 7px 0;
	display: block;
	color: #FFD252;
	color: rgba(255, 210, 82, 1);
	text-shadow: 0px 0px 0px rgba(255, 210, 82, 1);
	text-transform: uppercase;
	opacity: 0.8;
}
.ib-container article p{
	font-size: 10px;
	line-height: 13px;
	color: #333;
	color: rgba(51, 51, 51, 1);
	text-shadow: 0px 0px 0px rgba(51, 51, 51, 1);
	opacity: 0.8;
}
.ib-container h3 a,
.ib-container article header span,
.ib-container article p{
	-webkit-transition: 
		opacity 0.2s linear, 
		text-shadow 0.5s ease-in-out, 
		color 0.5s ease-in-out;
	-moz-transition: 
		opacity 0.2s linear, 
		text-shadow 0.5s ease-in-out, 
		color 0.5s ease-in-out;
	-o-transition: 
		opacity 0.2s linear, 
		text-shadow 0.5s ease-in-out, 
		color 0.5s ease-in-out;
	-ms-transition: 
		opacity 0.2s linear, 
		text-shadow 0.5s ease-in-out, 
		color 0.5s ease-in-out;
	transition: 
		opacity 0.2s linear, 
		text-shadow 0.5s ease-in-out, 
		color 0.5s ease-in-out;		
}
/* Hover Style for all the items: blur, scale down*/
.ib-container article.blur{
	box-shadow: 0px 0px 20px 10px rgba(255,255,255,1);
	-webkit-transform: scale(0.9);
	-moz-transform: scale(0.9);
	-o-transform: scale(0.9);
	-ms-transform: scale(0.9);
	transform: scale(0.9);
	opacity: 0.7;
}
.ib-container article.blur h3 a{
	text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.9);
	color: rgba(0, 0, 0, 0);
	opacity: 0.5;
}
.ib-container article.blur header span{
	text-shadow: 0px 0px 10px rgba(255, 210, 82, 0.9);
	color: rgba(255, 210, 82, 0);
	opacity: 0.5;
}
.ib-container article.blur  p{
	text-shadow: 0px 0px 10px rgba(51, 51, 51, 0.9);
	color: rgba(51, 51, 51, 0);
	opacity: 0.5;
}

/* Hover Style for single item: scale up */
.ib-container article.active{
	-webkit-transform: scale(1.05);
	-moz-transform: scale(1.05);
	-o-transform: scale(1.05);
	-ms-transform: scale(1.05);
	transform: scale(1.05);
	box-shadow: 
		0px 0px 0px 10px rgba(255,255,255,1), 
		1px 11px 15px 10px rgba(0,0,0,0.4);
	z-index: 100;	
	opacity: 1;
}
.ib-container article.active h3 a,
.ib-container article.active header span,
.ib-container article.active p{
	opacity; 1;
}
</style>
		<script type="text/javascript">
			$(function() {				
				var $container	= $('#ib-container'),
					$articles	= $container.children('article'),
					timeout;				
				$articles.on( 'mouseenter', function( event ) {						
					var $article	= $(this);
					clearTimeout( timeout );
					timeout = setTimeout( function() {						
						if( $article.hasClass('active') ) return false;	

									$articles.not( $article.removeClass('blur').addClass('active') )
								 .removeClass('active')
								 .addClass('blur');						
					}, 65 );					
				});				
				$container.on( 'mouseleave', function( event ) {					
					clearTimeout( timeout );
					$articles.removeClass('active blur');					
				});			
			});
		</script>
<script src="assets/js/thickbox/thickbox.js"></script>
<link href="assets/js/thickbox/thickbox.css" rel="stylesheet" type="text/css"/>
<div class="container">
<div style="margin:0 auto; text-align:center;"><h3>My Details</h3></div><br/>
<!--<p style="background-image:url('img/db3_white.jpg'); width:300px; height:225px;"></p>-->
<table style="width:940px; margin:0 auto;">
	<tr>
		<td>
			<div style="color:#A69086; width:198px; height:198px;">
					<?php 
						$user_detail = mysql_query("select img_name, sex from users where user_id='$user_id'") or die(mysql_error());
						$getdetails = mysql_fetch_array($user_detail);
						$sex = $getdetails['sex'];
						$img_name = $getdetails['img_name'];
						//var_dump($img_name);
							if(isset($img_name)){ ?>
									<img src="picture/<?php echo $img_name; ?>" alt="male" height="197" width="197">
									<?php } elseif($sex == 2 && $img_name == null) { echo "<img src=\"picture/default_male.jpg\" width=198 height=198>"; ?>
									<?php } else { echo "<img src=\"picture/default_female.jpg\" width=198 height=198>";?>
									<?php } ?>					
			<span>
			<?php
			$uploader_window = "<a style=\"text-align:center; text-decoration:none;text-indent:7px;\" class=thickbox href=\"uploader.phpTB_iframe=true&height=440&width=700\"><h4>Upload Your Image</h4></a>";
			print $uploader_window;
			?>
			<!--<a href="uploader.php" style="text-align:center; text-decoration:none; text-indent:7px;"><h4>Upload Your Image</h4></a>-->
			</div>
		</td>
	<td>
<div class="welcome-intro-box">
	<table style="font-size:14px; line-height:22px;">
			<tr><td><span style="font-size:17px;"/>I</span> am</td><td> <span style="padding-left:10px; font-size:17px;"><?php 
						$usr_details = mysql_query("select full_name,user_email,user_bday,sex,ccode from users where user_id = '$user_id'");
						$logged_usr = mysql_fetch_array($usr_details);
						echo $logged_usr['full_name']; 
					   ?> !</span></td></tr>
			<tr><td>Email</td><td> <span style="padding-left:10px; font-size:17px;"><?php 
						echo $logged_usr['user_email'];
					   ?></span></td></tr>
			<tr><td>Born on</td><td> <span style="padding-left:10px; font-size:17px;"><?php 
						echo $logged_usr['user_bday'];
					   ?></span></td></tr>
			<tr><td>Gender</td><td> <span style="padding-left:10px; font-size:17px;">
			<?php 
						if($logged_usr['sex'] == 2)
							{
							echo "Male";
							}
							elseif($logged_usr['sex'] == 1)
							{
							echo "Female";
							} 							
							echo $data2;
					?></span></td></tr>
			<tr><td style="width:120px; float:left; display:inline;">Living Country</td><td><span style="padding-left:10px; font-size:17px;"><?php 
						$ccode = $logged_usr['ccode']; 
						$user_country = mysql_query("select country from countries where ccode = '$ccode'");
						list($country) =  mysql_fetch_row($user_country);
						echo $country;
					   ?></span></td>					  
				   </tr>
<br/>				   
		</table>
</div>
</td>
 <td>
<div class="update_box">
<h4 style="text-align:center;">Latest Updates</h4>
<br/><div style="border:1px solid black;"></div>
					   <ul style="padding-top:4px; list-style-type:none; padding-left:7px; min-height:130px;">
						   <li style="font-family: 'Montsearsrat Alternates', sans-serif;"><b>Friendsalong</b> just got launched.</li>
						   
					   </ul>
					   </div>
</td>
</tr>
</table> 
	<!-- Box section comes here -->
	<section class="ib-container" id="ib-container"> 		
				<article style="background-image:url('img/voiletb_mini.jpg'); margin-left:144px;">
					<header style="text-align:center; padding:10px 0px;">
						<a href="trips.php" style="text-decoration:none;"><h3 style="color:#DFDEE4;">My Trips</h3></a><br/><br/>
						<!--<span>AS ON&nbsp;<?php echo date('Y-m-d');?></span><br/>-->
					</header>
					<p style="text-align:center;font-family: 'Finger Paint', cursive;">
					<a href="trips.php" style="text-decoration:none;">
					<?php
						$site_trips = mysql_query("select count(*) as site_trips_count from trip_details where user_id = '$user_id' and is_deleted = 1");
						list($site_trips_count) = mysql_fetch_row($site_trips);
						echo"<br/><span style=\"color:#fff; padding-left:7px; font-size:100px;\">$site_trips_count</span>";
					?>
					</p></a>
				</article>
				<article style="background-image:url('img/greenb_mini.jpg');">
					<header style="text-align:center; padding:10px 0px;">
						<a href="friends.php" style="text-decoration:none;"><h3 style="color:#DFDEE4;">My Friends</h3></a><br/><br/>
						<!--<span>AS ON&nbsp;<?php echo date('Y-m-d');?></span><br/>-->
					</header>
					<p style="text-align:center; font-family: 'Finger Paint', cursive;">
						<a href="friends.php" style="text-decoration:none;">
						<?php
							$site_users = mysql_query("select count(*) as site_usr_count from friends where user_id = '$user_id' and is_blocked = 0");
							list($site_usr_count) = mysql_fetch_row($site_users);
							echo"<br/><span style=\"color:#fff; padding-left:30px; font-size:100px;\">$site_usr_count</span>";
						?></a>
					</p>
				</article>
				<article style="background-image:url('img/blueb_mini.jpg');">
					<header style="text-align:center; padding:10px 0px;">
						<a href="messages.php" style="text-decoration:none;"><h3 style="color:#DFDEE4;">My Messages</h3></a><br/><br/>
						<!--<span>AS ON&nbsp;<?php //echo date('Y-m-d');?></span><br/>-->
					</header>
					<p style="text-align:center; font-family: 'Finger Paint', cursive;">
						<a href="messages.php" style="text-decoration:none;">
						<?php
							$site_msgs = mysql_query("select count(*) as site_msgs_count from messages where to_id = '$user_id' and is_deleted = 1");
							list($site_msgs_count) = mysql_fetch_row($site_msgs);
							echo"<br/><span style=\"color:#fff; padding-left:7px; font-size:100px;\">$site_msgs_count</span>";
						?></a>
					</p>
				</article>
	</section>
<div style="clear: both;"><hr/><?php include("footer.php"); ?></div>
</div>
</body>
</html>
<?php
include("includes/dbc.php");
session_start();
$page_title="DashBoard";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<body>		
<?php include("navbar.php"); ?>
<div class="container">
<div style="width:950px; margin:0 auto;text-align:center;">
				<div><h2 style="color:#A20F65;">Add your Trip</h2></div><br/>	
						<div class="welcome-intro-box" style="height:310px; font-family:'sans-serif',arial;">
								<br/><br/><br/><br/><hr/>
								<div style="float:left;padding-left:110px;"><h2><a class="btn btn-large btn-primary" style="font-size:24px; text-decoration:none;" href="trips" name="flight_trips">Flight Trip [+]</a></h2></div>
								<div style="float:right;padding-right:110px;"><h2><a class="btn btn-large btn-primary" style="font-size:24px; text-decoration:none;" href="trains" name="train_trips">Train Trip [+]</a></h2></div>
						<div class="clear"></div><hr/>
						</div>
	</div>
	<div style="clear: both;"><br/><br/><hr/><?php include("footer.php"); ?></div>
</div>
</body>
</html>
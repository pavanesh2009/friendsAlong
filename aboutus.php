<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Why Friendsalong";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<body>	
<?php include("navbar.php")?>
<div class="container" style="height:450px;">
		<div style="font-size:13px; font-family: sans-serif; height:415px;  color:#043948;"  class="box-signup" >
				<h3 style="color:#812C5A; text-indent:12px;">Why Friendsalong ?</h3><hr/>
				<p class="span11">Sometimes it isn't the destination that makes a trip it is the friends you make and meet along the way.</p>
				
				<p class="span11">Travelling provides you with so much the chance to learn and grow, the opportunity to understand and explore different cultures as well as the chance to stretch your limits, challenge yourself, view & discover different lands as well as the joy of tasting the wonderful world of exotic cuisine. But wait there is more!</p>
				<p class="span9 pull-left">
					For me the one thing that I remember the most about my travels are the friends I have made and met along the way. During independent journeys as well as organised expeditions there are always people that touch your heart and become lifelong friends. 
					Sometimes once your adventures are over, you lose contact with the special people you 
					have bonded with but that doesn't mean the friendship is lost or forgotten. 
					These are the kind of friends that no matter how long you haven't been in contact
					they still have a special place in your heart. These are the friends you know you can
					always count on five, ten, fifteen and it my case twenty years down the road to catch-up
					for that long awaited beer (or in some cases that game of 7, 11 doubles), ask for advice, 
					share travel stories, exchange the good and bad times and most of all you know they 
					are there to count on when you really need them.
				</p>
				<img src="img/voiletbtext.jpg" height="120" width="180" class="pull-right" style="margin-right:44px;"/>
				<div class="clear"></div>
				<p class="span11">By registering with Friendsalong, you are joining a social network where you can plan or add a new trip and meet your friends along the way.</p>
				<p class="span11">By joining the Friendsalong you also make new friends. Friendsalong strongly believe that during independent journeys as well as organised expeditions there are always people that touch your heart and become lifelong friends! So now go get active and enjoy the company of your fellow travellers!</p>
		</div><hr/>
<?php include("footer.php"); ?>		
</div>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>
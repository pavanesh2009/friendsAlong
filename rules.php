<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Friendsalong Rules";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
 <title id="page_title">Friendsalong / Friendsalong Terms of Service</title>
	<style>
	p{text-align:justify; font-family:"Trebuchet MS", arial, sans-serif; font-size:13px;}
	</style>
		<link href="assets/scroll/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<!-- mousewheel plugin -->
	<script src="assets/scroll/jquery.mousewheel.min.js"></script>
	<!-- custom scrollbars plugin -->
	<script src="assets/scroll/jquery.mCustomScrollbar.js"></script>
	<script>
		(function($){
			$(window).load(function(){
				$("#content").mCustomScrollbar({
					/*scrollInertia:0,*/
					scrollButtons:{
						enable:true
					}
				});
			
			});
		})(jQuery);
	</script>
</head>
<body> 
<?php include("navbar.php")?> 
<div class="container">
<div class="box-signup" id="content" style="height:415px;">
<div style="text-align:center;"><h3 style="font-family:trebuchet ms, arial, sans-serif; color:#A20F65;">Friendsalong Rules</h3></div>
<hr/>
<p>
Our goal is to provide a service that allows you to discover and receive content from sources that interest you as well as to share your content with others. We respect the ownership of the content that users share and each user is responsible for the content he or she provides. Because of these principles, we do not actively monitor user's content and will not censor user content, except in limited circumstances described below.
</p>
<h4 style="font-family:trebuchet ms, arial, sans-serif; color:#A20F65;">Content Boundaries and Use of Friendsalong</h4>
<p>In order to provide the Friendsalong service and the ability to communicate and stay connected with others, there are some limitations on the type of content that can be published with Friendsalong. These limitations comply with legal requirements and make Friendsalong a better experience for all. We may need to change these rules from time to time and reserve the right to do so. Please check back here to see the latest.</p>
	<p><strong style="color:#A20F65;">Impersonation:</strong> You may not impersonate others through the Friendsalong service in a manner that does or is intended to mislead, confuse, or deceive others. </p>
	<p><strong style="color:#A20F65;">Trademark:</strong>	We reserve the right to reclaim user names on behalf of businesses or individuals that hold legal claim or trademark on those user names. Accounts using business names and/or logos to mislead others will be permanently suspended.</p>
    <p><strong style="color:#A20F65;">Privacy:</strong> You may not publish or post other people's private and confidential information, such as credit card numbers, street address or Social Security/National Identity numbers, without their express authorization and permission.</p>
    <p><strong style="color:#A20F65;">Violence and Threats:</strong> You may not publish or post direct, specific threats of violence against others.</p>
    <p><strong style="color:#A20F65;">Copyright:</strong> We will respond to clear and complete notices of alleged copyright infringement. Our copyright procedures are set forth in the Terms of Service.</p>
    <p><strong style="color:#A20F65;">Unlawful Use:</strong> You may not use our service for any unlawful purposes or in furtherance of illegal activities. International users agree to comply with all local laws regarding online conduct and acceptable content.</p>
    <p><strong style="color:#A20F65;">Misuse of Friendsalong Badges:</strong> You may not use a Verified Account badge or Promoted Products badge unless it is provided by Friendsalong. Accounts using these badges as part of profile photos, header photos, background images, or in a way that falsely implies affiliation with Friendsalong will be suspended.</p>
    <p><strong style="color:#A20F65;">Pornography:</strong> You may not use obscene or pornographic images in your profile photo, header photo, or user background.</p>

	<p>Your account may be suspended for Terms of Service violations if any of the above is true.for a more detailed discussion of how the Rules apply to those particular account behaviors. Accounts created to replace suspended accounts will be permanently suspended.
Accounts engaging in any of these behaviours may be investigated for abuse. Accounts under investigation may be removed from Search for quality. Friendsalong reserves the right to immediately terminate your account without further notice in the event that, in its judgment, you violate these Rules or the Terms of Service.</p>
		<p><em>Effective: Dec 1, 2012</em></p>
		</div><hr/>
<?php include("footer.php"); ?>		
</div>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>


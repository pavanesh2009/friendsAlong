<?php
ob_start();
include("includes/dbc.php");
session_start();
$page_title="Friendsalong Privacy";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
 <title id="page_title">Friendsalong / Friendsalong Terms of Service</title>
	<style>
	p{text-align:justify; font-family:"Trebuchet MS", arial, sans-serif; font-size:13px;}
	#facts{font-family:"trebuchet ms", arial, sans-serif; color:#A20F65;}
	</style>
</head>
<body> 
<?php include("navbar.php")?> 
<div class="container">
<div class="box-signup">
	<div style="text-align:center; padding:10px;">
	<h3 style="font-family:trebuchet ms, arial, sans-serif; color:#A20F65;">Friendsalong Privacy Policies</h3>
	</div>
<hr/>
<ol class="#facts" style="font-family:trebuchet ms, arial, sans-serif; color:#043948;">
<li> Trips what you add in friendsalong may be viewed by all who travel with the same airline or train.</li>
<li> We do not disclose your private personal information except in the limited circumstances described here.</li>
<li> If you are a registered user of our Services, we provide you with tools and account settings to access or modify the personal information you provided to us and associated with your account.</li>
<li> You can also permanently delete your Friendsalong account. Your account will be deactivated and then deleted. When your account is deactivated, it is not viewable on friendsalong.com.</li>
<li> Changes to this Policy - We may revise this Privacy Policy from time to time. The most current version of the policy will govern our use of your information and will always be at http://friendsalong.com/privacy. If we make a change to this policy that, in our sole discretion, is material, we will notify you via an @Twitter update or email to the email address associated with your account. 
</li>
<li>
By continuing to access or use the Services after those changes become effective, you agree to be bound by the revised Privacy Policy.
</li>
<br/>
<p><em>Effective: Dec 1, 2012</em></p>


Thoughts or questions about this Privacy Policy? 
<a href="mailto:support@friendsalong.com?Subject=Privacy%20enquiry">Please, let us know.</a>
</p>
	<p>Your account may be suspended for Terms of Service violations if any of the above is true.for a more detailed discussion of how the Rules apply to those particular account behaviors. Accounts created to replace suspended accounts will be permanently suspended.
Accounts engaging in any of these behaviours may be investigated for abuse. Accounts under investigation may be removed from Search for quality. Friendsalong reserves the right to immediately terminate your account without further notice in the event that, in its judgment, you violate these Rules or the Terms of Service.</p>
	</div><hr/>
</ol>	
<?php include("footer.php"); ?>		
</div>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>


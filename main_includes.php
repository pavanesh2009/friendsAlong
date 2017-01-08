<?php 
$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$pfile = $break[count($break) - 1];
if($_SESSION['user_id'] == '' && ($pfile == "thankyous.php" || $pfile == "messages.php" || $pfile == "profile.php" || $pfile == "addmessage.php" || $pfile == "edit_tripdetail.php" || $pfile == "dashboard.php" || $pfile == "replyMessage.php" || $pfile == "trips.php"  || $pfile == "search.php" || $pfile == "airlines.php" || $pfile == "add_friends.php" || $pfile == "trains.php" || $pfile == "friends.php" || $pfile == "logout.php") ) {
			header("Location: login");
	} 		
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="friendsalong,friends along,trip,travel,flight,train,Reunion,Old Friends,find mates,awesome trip,memorable trip,best trip idea,make new Friends">
    <meta name="description" content="Now your boring Trips can be memorable & fun, with Friendsalong you can plan & add your trips, search old friends & make new ones, So, Let's get started..">
    <meta name="author" content="friendsalong">
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta name="robots" content="index, follow" />
	<!-- Le fav and touch icons -->
	<link rel="Shortcut Icon" href="assets/ico/favicon.ico" type="image/x-icon" />
	<title><? echo $page_title; ?></title>
	<!-- Le styles -->
    <style type="text/css">
		  body {
			padding-top: 60px;
			padding-bottom: 40px;
		  }
    </style>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->	
	<!-- Important Stylesheets-->
	<link type="text/css" href="assets/css/bootstrap.css" rel="stylesheet"></link>
	<link type="text/css" href="assets/css/bootstrap-responsive.css" rel="stylesheet"></link>
    <link href="assets/css/style.css" rel="stylesheet">
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.js"></script>	
</head>
<!--<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35869911-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>-->
<?php
ob_start();
   include 'includes/dbc.php';
   session_start();
   check_usr_status();
   $page_title="Friendsalong";
   include("main_includes.php");
   ?>
<body>
<img src="img/home-bg.jpg" class="bg" alt="bg-front-img"/>
<?php include('navbar.php');?>
<div class="container">
<div class="box-signup">	
<br/>
<h2>Error</h2><hr/>
<a href="/">Go back to Home..</a>
</div><br/><hr/>
  <footer>
       	<?php include("footer.php"); ?>
      </footer>

</div>
<?php mysql_close($link);
ob_flush();
?>
</body>
</html>
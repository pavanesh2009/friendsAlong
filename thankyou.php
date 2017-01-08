<?php 
include 'includes/dbc.php';
session_start();
check_usr_status();
$page_title = "Thank you !!";
include('main_includes.php');
?>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<body>
<?php include("navbar.php"); ?>
<div class="container">
  <br/>
		<div class="box-signup" style="color:#A20F65; text-indent:12px; padding:68px 68px 0px 68px; font-size:16px; line-height:28px; text-align:justify;  min-height:312px;">
			   <table>
				   <tr>
				   <td><img src="img/smileythumbsup_new.jpg" alt="smiley" style="width:190px; height:165px; border:none;"/></td> 
				   <td>&nbsp;&nbsp;<strong><span style="font-size:84px;">W</span><span style="font-size:40px; margin-left:-5px;">oohoo !</strong></span> Your registration is now complete.
						An email has been sent to your <span style="margin-left:227px;">email-id. You can <a href="login"><strong>login here</strong></a></span></td>
				   </tr>
			   </table>
		</div>
		<br/>
<hr/>
      <footer>
       		<?php include("footer.php"); ?>
      </footer>     
</div> <!-- /container -->
</body>
</html>
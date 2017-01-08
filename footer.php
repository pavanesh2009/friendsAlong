<footer>
       		 <p style="color:#E9E9E9; font-size:12px; font-family: 'Montsearsrat Alternates', sans-serif;">Friendsalong&nbsp;&copy;&nbsp;2012			
									<ul id="jsddm">									
									<?php if(isset($_SESSION['user_id'])) {	?>
										   <li><a href="dashboard">Dashboard</a></li>
									<?php } else { ?>		
											<li><a href="index">Home</a></li>
									<?php } ?>
											<li class="seprater">|</li>
											<li><a href="aboutus">Why Friendsalong ?</a></li>
											<li class="seprater">|</li>
											<li><a href="contactus">Need Help ?</a></li>
									 </ul>
			 </p>	
<div style="float:left;">
<div class="fb-like" data-href="http://friendsalong.com/" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend"></div>
</div>
<div style="float:right;">
<a href="https://twitter.com/friendsalong" class="twitter-follow-button" data-show-count="false">Follow @friendsalong</a>
</div>

		<div id="fb-root"></div>
				<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
				<script>
					! function (d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");
				</script>
</footer>
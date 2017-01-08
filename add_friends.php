<?php
include("includes/dbc.php");
session_start();
$page_title="Find Mates";
include("main_includes.php");
$user_id = $_SESSION['user_id'];
?>
<?php
$friend_name = $_POST['frndname'];
//var_dump($friend_name);
$is_blocked = '0';
$frnd_info = mysql_query("SELECT user_id, full_name, user_email from users where full_name = '$friend_name'");
while ($frndrows = mysql_fetch_array($frnd_info)) 
{
$frndID = $frndrows['user_id'];
$frndemail = $frndrows['user_email'];
}

$usr_info = mysql_query("SELECT full_name from users where user_id = '$user_id'");
while ($usrrows = mysql_fetch_array($usr_info)) 
{
$user_name = $usrrows['full_name'];
}

$rs_duplicate = mysql_query("select count(*) as total from friends where frnd_usr_id='$frndID' and user_id = '$user_id'");
list($total) = mysql_fetch_row($rs_duplicate);
//var_dump($total);
if ($total > 0)
{ ?>
<div class="alert alert-notice" style="width:840px; margin:5px auto;"><button class="close" data-dismiss="alert" type="button">&times;</button> <strong>Hey!</strong> you have already added this friend.</div>
<?php } else {
$sql_insert = "INSERT into `friends`
                                    (`user_id`, 
                                        `frnd_usr_id`,
                                        `created_on`,
                                        `modified_on`,
                                        `is_blocked`							 
                                        )
                                    VALUES
                                            ('$user_id',
                                                '$frndID',
                                                now(),
                                                now(),				
                                                '$is_blocked'
                                            )";
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
							//var_dump($sql_insert);
	/** Message notification through Email **/
				require("includes/class.phpmailer.php");

				$mail = new PHPMailer();

				$mail->IsSMTP();                                      // set mailer to use SMTP
				$mail->Host = "mail.friendsalong.com";  // specify main and backup server
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->Username = "support@friendsalong.com";  // SMTP username
				$mail->Password = "Galaxy@345"; // SMTP password

				$mail->From = "support@friendsalong.com";
				$mail->FromName = "Friendsalong Team";
				$mail->AddAddress($frndemail );     
				$mail->Subject = "New Friend Notification";
				/***
				By Pavanesh white travelling JHS-Bangalore on 20-11-2012.
				**/
				$date = date("m-d-Y");
				//var_dump($user_name);
				$assigned_vars = array('date' => $date, 'username' => $user_name);
				$output = file_get_contents('friend_alert_template.php');
				 foreach($assigned_vars as $key => $value) {
					$output = preg_replace('/{'.$key.'}/', $value, $output);
				}
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				$mail->MsgHTML($output);

					if(!$mail->Send())
					{
					   echo "Message could not be sent. <p>";
					   echo "Mailer Error: " . $mail->ErrorInfo;
					   exit;
					}	
?>	
<div class="alert alert-success" style="width:840px; margin:5px auto;"><button class="close" data-dismiss="alert" type="button">&times;</button> <strong>Hey!</strong> you have added a new friend.</div>
<?php } ?>
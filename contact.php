<?php

include "scripts/checkbro.php";

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$msg = $_POST['msg'];
	
	if (!strlen($name) || !strlen($email) || !strlen($msg)){
		if (!strlen($name)) {
			$error_name = "<span id='error'>Please enter a valid name!</span>";
			$highlight_name = "highlighted";
		}
		if (!strlen($email)) {
			$error_email .= "<span id='error'>Please enter a valid email!</span>";
			$highlight_email = "highlighted";
		}
		if (!strlen($msg)){
			$error_msg .= "<br /><span id='error'>Please enter a message!</span>";
			$highlight_msg = "highlighted";
		}
		
		$value_name = $name;
		$value_email = $email;
		$value_msg = $msg;
	} else {
	
		// Passwords should never be longer than 72 characters to prevent DoS attacks
		if (strlen($name) > 72) {
			die("Password must be 72 characters or less");
		} else {
		
			require "scripts/connect_to_mysql.php";
			
		
			/*============== Sanitizing Inputs for SQL Attack/Interception ===============*/
			function clean($elem) { 
			    if(!is_array($elem)){
					$elem = htmlentities($elem,ENT_QUOTES,"UTF-8"); 
				} else {
					foreach ($elem as $key => $value) {
						$elem[$key] = mysql_real_escape_string($value);
					}
				return $elem;
				}
			}
			
			$_CLEANED = clean($_POST);

			$name = $_CLEANED['name'];
			$email = $_CLEANED['email'];
			$msg = $_CLEANED['msg'];
			
			
			/*============== Sanitizing Email Input for Spam Attack/Interception ===============*/
			function spamcheck($email) {
				//filter_var() sanitizes the e-mail
				//address using FILTER_SANITIZE_EMAIL
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);

				//filter_var() validates the e-mail
				//address using FILTER_VALIDATE_EMAIL
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){
					return TRUE;
				} else {
					return FALSE;
				}
			}
			
			//check if the email address is invalid
			$mailcheck = spamcheck($_REQUEST['email']);
			if ($mailcheck==FALSE){
				$error_email .= "<span id='error'>Please enter a valid email!</span>";
				$highlight_email = "highlighted";
			} else {
				
				// ALL GOOD! now send email
				
				// Get User's IP Address
				$user_ip = $_SERVER['REMOTE_ADDR'];	
				$now = date("l, F j, Y g:i:s A");
					
				// Send Email Verification
				$to = "aab@hcs.harvard.edu";
				$subject = "New Email from the Website!";
				$from = "$email";
				$headers = "From: $email \r\n";
				$headers .= "Reply-To: $email \r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$body = "<html>
	<head>
		<style>
			p {font-family:Helvetica Neue, Arial, sans-serif;}
			div.msg {padding: 20px; background: #eee; color: #333; box-radius:2px; }
		</style>
	</head>
	<body>
	<p>Administrator of AAB,</p>
	<p>You've received the following email from $name (IP: $user_ip) on $now:</p>
	<div class='msg'><p>$msg</p></div>
	<p>You can respond to him or her <a href='mailto:$email'>here</a>.</p>
	</body>
</html>";
				mail($to,$subject,$body,$headers);
				$highlight_name = $highlight_email = $highlight_msg = "success";
				$error_name = "<span id='success'>Email Sent! Thank you.</span>";
			}
		}
	}
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Contact - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<link rel="stylesheet" type="text/css" href="css/tabs.css"/>
</head>

<body id="contact">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content ui-tabs lift-shadow">
		<ul class='ui-tabs-nav'><li class='ui-tabs-active'><a>Contact</a></li></ul>

			<p>For inquiries regarding programming or collaboration, please contact the most relevant <a href="leadership">director(s)</a>.</p>
			<p>For official inquiries or inquiries regarding membership or alumni relations, please contact us below:</p>
			<table cellpadding='0' cellspacing='0'>
			<form method='post' action='contact' id='contact'>
			<tr><td><input type='text' name='name' id='input' class='<?php echo $highlight_name ?>' placeholder='Name' value='<?php echo $value_name ?>' /><?php echo $error_name ?></td></tr>
			<tr><td><input type='email' name='email' id='input' class='<?php echo $highlight_email ?>' placeholder='Email' value='<?php echo $value_email ?>' /><?php echo $error_email ?></td></tr>
			<tr><td><textarea name='msg' id='textarea' class='<?php echo $highlight_msg ?>' placeholder='Message'><?php echo $value_msg ?></textarea><?php echo $error_msg ?></td></tr>
			<tr><td><input type='submit' name='submit' value='SUBMIT' id='button' /></td></tr>
			</form>
			</table>
		
		</div>
	</div>
</div>

</body>
</html>
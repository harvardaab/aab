<?php

include "scripts/checkbro.php";

if (isset($_SESSION["bro"])) {
	
	$newsletter_sql = mysql_query("SELECT * FROM newsletter ORDER BY date DESC");
	$newsletter_count = mysql_num_rows($newsletter_sql);
	if ($newsletter_count > 0) {
		while($r = mysql_fetch_array($newsletter_sql)) {
			$id = $r['id'];
			$title = $r['title'];
			$date = $r['date'];
			$author = $r['author'];
			$html = $r['html'];
			
			$date = date("F j, Y", strtotime($date));
			
			$bro_sql = mysql_query("SELECT firstname, lastname FROM brothers WHERE bro='$author' LIMIT 1");
			$bro_count = mysql_num_rows($bro_sql);
			if ($bro_count > 0) {
				while ($b = mysql_fetch_row($bro_sql)) {
					$firstname = $b[0];
					$lastname = $b[1];
					$authorname = "$firstname $lastname";
				}
			}
			
			$newsletter .= "<table cellspacing='0' cellpadding='0' style='padding-bottom:40'><tr><td>
<p><b>$title</b>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;$date&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href='brofile?bro=$author'>$authorname</a></p></td></tr>
			<tr><td>$html</td></tr>
			</table>";
		}
	} else {
		$newsletter = "<p>There are no newsletters published right now. Check back soon for updates!</p>";
	}

} else {
	$newsletter = "<p>You must be <a href='login'>signed in</a> to view the alumni newsletters.</p>";
}

mysql_close($mysql_connection);

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">


<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->


<head>
<title>Alumni - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
	<script>
$(function(){
	$('#tabs').tabs();
});
	</script>
</head>

<body id="alumni">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<div class='tabs ui-tabs lift-shadow' id='tabs'>
			<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active'><a href='#connected'>Stay Connected</a></li>
			<li><a href='#newsletter'>Newsletter</a></li>
			<li><a href='#giveback'>Give Back</a></li>
			</ul>

			<div id='newsletter'>
				<?php echo $newsletter ?>
			</div>
			<div id='connected'>
				<p>There are plenty of ways to reconnect or stay connected with your brothers and the brotherhood.</p>
				<p>Enter the <a href='login'>members portal</a> to contact brothers directly and access many more features.<br>
					Join the <a href='mailto:aab_alumni@yahoogroups.com'>alumni email list</a><br>
					Forward an email to the <a href='mailto:harvard-aab@googlegroups.com'>current brothers' list</a><br>
					Meet the current brothers at our weekly meeting, held every Wednesday in Quincy Spindell Room at 10 PM<br>
					Meet up at The Game<br>
					Organize a reunion
				</p>
				<p>For inquiries regarding membership or alumni relations, please contact us at <a href="mailto:aa.brotherhood@gmail.com?cc=aab@hcs.harvard.edu&Subject=Hi%20AAB!">aa.brotherhood@gmail.com</a>.</p>
			</div>
			<div id='giveback'>
				<p>With the alumni's generous financial support, we have completed the overhaul of the website and have organized more meaningful events,
but we need your support to tackle new projects and to maintain the progress we've made! Giving back is easy and you can do it right here!</p>
				<p>While we welcome any amount of generosity, we would sincerely appreciate a slight additional contribution to defray financial processing costs.</p>

<p>For a one time contribution:</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="D245RZSC2CAUE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<p>For a recurring gift:</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="N9KY5269GJ3G2">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<p>If you would rather make a tax deductible contribution, please send a check payable to Harvard University,
specifying "Asian American Brotherhood" on the memo line, to the <a href='leadership'>Director of Finance.</a></p>
			</div>
		</div>
	</div>
</div>

</body>
</html>
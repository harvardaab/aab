<?php

include "scripts/checkbro.php";

// Set photo directory
$path = "vault/photos/events/";

// Set the cutoff date as today
$year = date("Y");
$month = date("m"); //date("m");   <-- use if current mo needed
$day = date("d"); //date("d");   <-- use if current day needed

$today = "$year$month$day";

// Archive old events after today's date (Archive = 1 means upcoming event)
$events_sql = mysql_query("SELECT * FROM events ORDER BY Date DESC, TimeStart ASC");
while($row = mysql_fetch_array($events_sql)){
		$id = $row['id'];
		$name = $row['Name'];
		$date = $row['Date'];
		$timeStart = $row['TimeStart'];
		$timeEnd = $row['TimeEnd'];
		$location = $row['Location'];
		$description = $row['Description'];
		$author = $row['Author'];
		$archive = $row['Archive'];
		$description = nl2br($description);
		
		$eventCheck = date("Ymd", strtotime($date));
		if ($eventCheck >= $today){     // if later than today, then upcoming event
			mysql_query("UPDATE events SET Archive = '1' WHERE id='$id'");
		} else {
			mysql_query("UPDATE events SET Archive = '0' WHERE id='$id'");
		}
		
		$dateNominal = date("F j, Y", strtotime($date));
		
		if ($timeEnd != ""){     // display when no end time specified
			$datetime = "$dateNominal&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$timeStart - $timeEnd";
		} else {
			$datetime = "$dateNominal&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$timeStart";
		}
		
		if ($author != ""){    // if there's an author, find his name
			$author_sql = mysql_query("SELECT FirstName, LastName, Class FROM brothers WHERE bro='$author' LIMIT 1");
				while($r = mysql_fetch_row($author_sql)){
					$fname = $r[0];
					$lname = $r[1];
					$class = $r[2];
					$poster = "Contact: <a href='/brofile?bro=$author'>$fname $lname</a>";
				}
		} else {
			$poster = "";      // if no author, no display
		}
		
		$checkpic = "$path$id.png";      // if pic exists on file, then display
		$defaultpic = "".$path."default.png";
		if (file_exists($checkpic)){
			$eventPic = "<img src='$checkpic' style='width:350'/>";
		} else {
			$eventPic = "<img src='$defaultpic' style='width:350'/>";
		}

		if ($archive == "1"){
			$upcoming .= "<table cellpadding='0' cellspacing='0' class='lift-shadow event'>
				<tr><td valign='top' style='width:320;padding-right:20'>
					<h3>$name</h3>
					<p>$datetime<br>$location</p><p>$description</p><h6>$poster</h6>
				</td>
				<td valign='top' style='width:350'>$eventPic</td></tr>
				</table>";
		} elseif ($archive == "0") {
			$past .= "<table cellpadding='0' cellspacing='0' class='lift-shadow event'>
				<tr><td valign='top' style='width:320;padding-right:20'>
					<h3>$name</h3>
					<p>$datetime<br>$location</p><p>$description</p><h6>$poster</h6>
				</td>
				<td valign='top' style='width:350'>$eventPic</td></tr>
				</table>";
		} 
		
		if (!$upcoming){
			$upcoming = "<div class='lift-shadow'><p>There are no upcoming events scheduled at this time.
			Check back soon for updates!</p></div>";
		}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->

<head>
<title>Events - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script>
$(function(){
	$('#tabs').tabs();
});
</script>
</head>

<body id="events">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<div class='tabs ui-tabs' id='tabs'>
			<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active'><a href="#upcoming">Upcoming</a></li>
			<li><a href="#past">Past</a></li>
			</ul>

			<div id='upcoming' style='margin-bottom:500px'><?php echo $upcoming ?></div>
			<div id='past'><?php echo $past ?></div>
		</div>
	</div>
</div>

</body>
</html>
<?php

include "scripts/checkbro.php";

/*==================== EVENTS =======================*/

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
		
		if (strlen($timeEnd)){     // display when no end time specified
			$datetime = "$dateNominal&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$timeStart - $timeEnd";
		} else {
			$datetime = "$dateNominal&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;$timeStart";
		}
		
		if (strlen($author)){    // if there's an author, find his name
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
			$upcoming .= "<table cellpadding='0' cellspacing='0' class='each-medium event'>
				<tr><td valign='top' style='width:320;padding-right:20'>
					<h3>$name</h3>
					<p>$datetime<br>$location</p><p>$description</p><h6>$poster</h6>
				</td>
				<td valign='top' style='width:350'>$eventPic</td></tr>
				</table>";
		} elseif ($archive == "0") {
			$pastevents .= "<table cellpadding='0' cellspacing='0' class='each-medium event'>
				<tr><td valign='top' style='width:320;padding-right:20'>
					<h3>$name</h3>
					<p>$datetime<br>$location</p><p>$description</p><h6>$poster</h6>
				</td>
				<td valign='top' style='width:350'>$eventPic</td></tr>
				</table>";
		} 
		
		if (!$upcoming){
			$upcoming = "<div class='each-medium'><p>There are no upcoming events scheduled at this time.
			Check back soon for updates!</p></div>";
		}
}
?>
<?php

/*==================== NEWS =======================*/

/*============ NEWS UPDATES by DATE ==============*/

// Set cutoff date (June 1st of the current year)
$year = date("Y");
$lastyear = $year - 1;
$month = "06";
$day = "01";
$cutoffThis = "$year$month$day";      // June 1st of this year
$cutoffLast = "$lastyear$month$day";      // June 1st of last year

if ($month < 6) {
	$cutoff = $cutoffLast;
} else {
	$cutoff = $cutoffThis;
}

$mo = date("m");
$da = date("d");
$cur_date = "$year$mo$da";

// First query all news items (Archive = 0 means archived)
$news_sql = mysql_query("SELECT * FROM news ORDER BY datestamp DESC");
while($row = mysql_fetch_array($news_sql)){
		$id = $row['id'];
		$title = $row['title'];
		$content = $row['content'];
		$author = $row['author'];
		$datestamp = $row['datestamp'];
		$archive = $row['archive'];
		$content = nl2br($content);

		$newsDate = date("Ymd", strtotime($datestamp));
		if ($cur_date < $cutoff && $newsDate < $cutoff  && $newsDate > $cutoffLast){
			// if still in academic year, then any post since last June is news
			mysql_query("UPDATE news SET archive='1' WHERE id='$id'");
		} else if($cur_date > $cutoff && $newsDate > $cutoff){
			mysql_query("UPDATE news SET archive='1' WHERE id='$id'");
		} else {
			mysql_query("UPDATE news SET archive='0' WHERE id='$id'");
		}
		
		if (strlen($author)){    // if there's an author, find his name
			$author_sql = mysql_query("SELECT FirstName, LastName, Class FROM brothers WHERE bro='$author' LIMIT 1");
				while($r = mysql_fetch_row($author_sql)){
					$fname = $r[0];
					$lname = $r[1];
					$class = $r[2];
					$poster = " by <a href='/brofile?bro=$author'>$fname $lname</a>";
				}
		} else {
			$poster = "";      // if no author, no display
		}
		
		$dateNominal = date("F j, Y", strtotime($datestamp));    // date for display
		
		if ($archive == "1"){      // Display news items after cutoff date
			$updates .= "<div class='each-medium'>
				<h2>$title</h2>
				<p>$content</p>
				<h4>$dateNominal$poster</h4>
				</div>";
		} else {
			$pastupdates .="<div class='each-medium'>
				<h2>$title</h2>
				<p>$content</p>
				<h4>$dateNominal$poster</h4>
				</div>";
		}
		
		if (!$updates){
			$updates = "<div class='each-medium'><p>There have been no recent happenings.
			Take a look at past posts or check back soon for updates!</p></div>";
		}
}
?>
<?php
/*==================== GALLERY =======================*/
$gallery_sql = mysql_query("SELECT * FROM albums WHERE Private='0' ORDER BY Date DESC");  // Search only for publicly accessible albums
	$gallery_count = mysql_num_rows($gallery_sql);
	if ($gallery_count > 0) {
		while ($g = mysql_fetch_array($gallery_sql)) {
			$a_id = $g['id'];
			$a_name = $g['Name'];
			$a_desc = $g['Description'];
			$a_date = $g['Date'];
			$a_author = $g['Author'];
			$a_html = $g['Album'];
			$a_priv = $g['Private'];
			
			if ($a_priv == 0) {
							$a_dateN = date("F j, Y",strtotime($a_date));
			
			if ($a_author != "") {
				$author_sql = mysql_query("SELECT FirstName, LastName FROM brothers WHERE bro = '$a_author' LIMIT 1");
				$author_count = mysql_num_rows($author_sql);
				if ($author_count > 0 ) {
					while ($a = mysql_fetch_array($author_sql)) {
						$a_fname = $a['FirstName'];
						$a_lname = $a['LastName'];
						$a_author = "<a href='brofile?bro=$a_author'>$a_fname $a_lname</a>";
						}
					}
				} else {
					$a_author = "";
				}
			
					$album_list .= "<div class='each-medium'>
						<div class='each-album'>
						<span class='album-title'><b>$a_name</b> &#8226; $a_desc</span><br>
						<span class='album-date'>$a_dateN</span><br><br>
						$a_html
						</div>
						</div>";
					
			}
		}
	} else {
	
	$album_list = "<h3 id='open_edit'>There are no albums available. Check back soon for updates!</h3>";
	
	}
	
	mysql_close($mysql_connection);
	
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->

<head>
<title>Media - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script>
$(function(){
	$('#tabs').tabs();
});
</script>
</head>

<body id="media">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<div class='tabs ui-tabs lift-shadow' id='tabs'>
			<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active' style='margin-right:0px'><a href='#updates'>News</a></li><span class='prettybig'>:</span>
			<li><a href="#pastupdates">Past</a></li>
			<li style='margin-right:0px'><a href="#upcoming">Events</a></li><span class='prettybig'>:</span>
			<li><a href="#pastevents">Past</a></li>
			<li><a href='#gallery'>Gallery</a></li>
			</ul>
			
			<div id='updates'><?php echo $updates ?></div>
			<div id='pastupdates' class='hidden'><?php echo $pastupdates ?></div>

			<div id='upcoming' style='margin-bottom:500px' class='hidden'><?php echo $upcoming ?></div>
			<div id='pastevents' class='hidden'><?php echo $pastevents ?></div>
			
			<div id='gallery' class='hidden'><?php echo $album_list ?></div>
		</div>
	</div>
</div>

</body>
</html>
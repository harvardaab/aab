<?php

include "scripts/checkbro.php";


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
		
		if ($author != ""){    // if there's an author, find his name
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
			$updates .= "<div class='lift-shadow'>
				<h2>$title</h2>
				<p>$content</p>
				<h4>$dateNominal$poster</h4>
				</div>";
		} else {
			$past .="<div class='lift-shadow'>
				<h2>$title</h2>
				<p>$content</p>
				<h4>$dateNominal$poster</h4>
				</div>";
		}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->

<head>
<title>News - Asian American Brotherhood - Harvard College</title>
<?php include_once "head.php" ?>
<script>
$(function(){
	$('#tabs').tabs();
});
</script>
</head>

<body id="news">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<div class='tabs ui-tabs' id='tabs'>
			<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active'><a href="#updates">News</a></li>
			<li><a href="#past">Past Updates</a></li>
			<ul>
		
			<div id='updates'><?php echo $updates ?></div>
			<div id='past'><?php echo $past ?></div>
		</div>
	</div>
</div>

</body>
</html>
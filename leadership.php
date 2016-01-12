<?php

include "scripts/checkbro.php";

if (isset($_SESSION["FirstName"])) {
	$bfirstname = $_SESSION['FirstName'];
	$blastname = $_SESSION['LastName'];
}
/*============ LOOK UP BROS W/ DIRECTORSHIPS =============*/

// Current Board
$year = date("Y");

$positions = array("archives","finance","brotherhood","edpol","service","alumni","recruitment");
$positions_name = array("Archives","Finance","Brotherhood","Educational/Political Awareness","Service","Alumni Relations","Recruitment");

// Find any enrolled bros with leadership
for ($i = 0; $i <= 6; $i++){
	$position = $positions[$i];
	$position_name = $positions_name[$i];
	$leaders = mysql_query("SELECT * FROM brothers WHERE Leadership LIKE '%$position$year%' ORDER BY LastName ASC");
	$count = mysql_num_rows($leaders);
	if ($count > 0) {
		while ($row = mysql_fetch_array($leaders)) {
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$leadership = $row['Leadership'];
			$email = $row['Email'];
			
			$classY = substr($class, 2);
			$name = "<a href='brofile?bro=$bro'>$firstname $lastname '$classY</a>";
			$options = "<span class='right'><a href='brofile?bro=$bro' class='options'>Profile</a> <a href='mailto:$email?Subject=AAB&body=Hi%20$firstname,'  class='options'>Contact</a></span>";
			
			$img_path = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($img_path)) {
				$photo = "<a href='brofile?bro=$bro'><img src='$img_path' class='thumb small' /></a>";
			} else {
				$photo = "<a href='brofile?bro=$bro'><img src='$default' class='thumb small' /></a>";
			}
			
			$directors .= "<div class='each-director'>$photo$name, $position_name$options</div>";
		}
		$board = "<div class='all-directors lift-shadow'><span id='board'>Board of Directors $year</span><br>$directors</div>";
	}
}

// Next Board
$next = $year + 1;

// Find any enrolled bros with leadership
for ($i = 0; $i <= 5; $i++){
	$position = $positions[$i];
	$position_name = $positions_name[$i];
	$leader_sql = mysql_query("SELECT * FROM brothers WHERE Leadership LIKE '%$position$next%' ORDER BY LastName ASC");
	$count_lead = mysql_num_rows($leader_sql);
	if ($count_lead > 0) {
		while ($row = mysql_fetch_array($leader_sql)) {
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$leadership = $row['Leadership'];
			$email = $row['Email'];
			
			$classY = substr($class, 2);
			$name = "<a href='brofile?bro=$bro'>$firstname $lastname '$classY</a>";
			$options = "<span class='right'><a href='brofile?bro=$bro' class='options'>Profile</a> <a href='mailto:$email?Subject=AAB&body=Hi%20$firstname,'  class='options'>Contact</a></span>";
			
			$img_path = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($img_path)) {
				$photo = "<a href='brofile?bro=$bro'><img src='$img_path' class='thumb' /></a>";
			} else {
				$photo = "<a href='brofile?bro=$bro'><img src='$default' class='thumb' /></a>";
			}
			
			$new_directors .= "<div class='each-director'>$photo$name, $position_name$options</div>";
		}
		$new_board = "<div class='padded lift-shadow'><span id='board'>Congratulations to the Incoming Board of Directors $next!</span>$new_directors</div>";
	}
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US"
      xmlns:fb="https://www.facebook.com/2008/fbml">

<!-- ////////          A Kevin Kong Production          \\\\\\\\-->
<!-- ////////       Philadelphia, Brother King '13      \\\\\\\\-->
<!-- ////////                Summer 2012                \\\\\\\\-->

<head>
	<title>Leadership - Asian American Brotherhood - Harvard College</title>
	<?php include_once "head.php" ?>
<style>
a.options {opacity:.25}
div.padded {margin-bottom: 30}
</style>
<script>
$(function(){
	$('div.each-director').hover(function(){
		$(this).find('a.options').fadeTo('fast', 1.0);
		}, function(){
		$(this).find('a.options').fadeTo('fast', 0.25)
	});
});
</script>
</head>

<body class="about leadership">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content ui-tabs">
		<ul class='ui-tabs-nav'>
		<li><a href="about">About</a></li>
		<li><a href="constitution" id="constitution">Constitution</a></li>
		<li><a href="leadership" id="leadership">Leadership</a></li>
		<li><a href="recruit" id="recruit">Recruitment</a></li>
		</ul>
	
		<div id='leadership'>
			<?php echo $new_board ?>
			<?php echo $board ?>
		</div>
	</div>
</div>

</body>
</html>
<?php

include "scripts/checkbro.php";

if (isset($_SESSION["FirstName"])) {
	$bfirstname = $_SESSION['FirstName'];
	$blastname = $_SESSION['LastName'];
}
/*============ LOOK UP BROS W/ DIRECTORSHIPS =============*/

// Current Board
//$year = date("Y");
$year = 2013;

$positions = array("archives","finance","brotherhood","edpol","service","alumni");
$positions_name = array("Archives","Finance","Brotherhood","EdPol","Service","Alumni Relations");

// Find any enrolled bros with leadership
for ($i = 0; $i <= 5; $i++){
	$position = $positions[$i];
	$position_name = $positions_name[$i];
	$positionyear = "$position$year";
	$leaders = mysql_query("SELECT * FROM brothers WHERE Leadership LIKE '%$positionyear%' ORDER BY LastName ASC");
	$count = mysql_num_rows($leaders);
	if ($count = 1) {
		while ($row = mysql_fetch_array($leaders)) {
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
			$class = $row['Class'];
			$leadership = $row['Leadership'];
			$email = $row['Email'];
			$name = "<a href='brofile?bro=$bro'>$firstname $lastname '$classY</a>";
			$classY = substr($class, 2);
			$options = "<span class='right'><a href='brofile?bro=$bro' class='options'>Profile</a> <a href='mailto:$email?Subject=AAB&body=Hi%20$firstname,'  class='options'>Contact</a></span>";
			
			$img_path = "vault/photos/profpic/$bro.jpg";
			$default = "vault/photos/profpic/default.jpg";
			if (file_exists($img_path)) {
				$photo = "<a href='brofile?bro=$bro'><img src='$img_path' class='thumb' /></a>";
			} else {
				$photo = "<a href='brofile?bro=$bro'><img src='$default' class='thumb' /></a>";
			}
			
			$board .= "<div class='each-director'>$photo$name, $position_name$options</div>";
		}
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
a.options{opacity:.25}
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

	<div class="body-content">
		<ul id='about-nav'>
		<li><a href="about">About</a></li>
		<li><a href="constitution" id="constitution">Constitution</a></li>
		<li><a href="leadership" id="leadership">Leadership</a></li>
		<li><a href="recruit" id="recruit">Recruitment</a></li>
		</ul>
	
		<div id='leadership'>
			<?php echo $board ?>
		</div>
	</div>
</div>

</body>
</html>
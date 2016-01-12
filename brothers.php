<?php

include "scripts/checkbro.php";

if (isset($_SESSION["FirstName"])) {
	$bfirstname = $_SESSION['FirstName'];
	$blastname = $_SESSION['LastName'];
}
/*============ GENERATE ROSTER OF ALL BROS by CLASS ==============*/

// Get today's date to see which class is OLDEST and STILL ENROLLED
$month = date("m");
$year = date("Y");

if ($month < 6){
	$classYear = $year;
	} else{
		$classYear = $year + 1;
	}

// Count down from the latest graduated class and render roster
for ($i = $classYear; $i <= ($classYear + 3); $i++){
	$class_sql = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY LastName ASC");
	$classCount = mysql_num_rows($class_sql);
	if ($classCount > 0) {
		while($row = mysql_fetch_array($class_sql)){
			$bro = $row['bro'];
			$firstname = $row['FirstName'];
			$lastname = $row['LastName'];
		
			${'class'.$i} = $i;
			${'bros'.$i} .= "<li><a href='brofile?bro=" . $bro . "'>" . $firstname . " " . $lastname . "</a></li>";
		}

		$broster .= "<td>
		<dt>Class of ".${'class'.$i}."</dt>
		".${'bros'.$i}."<br>
		</td>";
	}
}

// Count down from the latest graduated class and render roster
for ($i = ($classYear - 1); $i >= 2001; $i--){
	$class = mysql_query("SELECT * FROM brothers WHERE Class = '$i' ORDER BY LastName ASC");
	$classCount = mysql_num_rows($class);
	if ($classCount > 0){
		while($row = mysql_fetch_array($class)){
			$privacy = $row['Privacy'];
			
			if ($privacy == "1") {
			} else {
				$bro = $row['bro'];
				$firstname = $row['FirstName'];
				$lastname = $row['LastName'];
				
				${'class'.$i} = $i;
				${'bros'.$i} .= "<li><a href='brofile?bro=" . $bro . "'>" . $firstname . " " . $lastname . "</a></li>";
			}
		}
		
		$a_broster .= "<td style='min-width:160px'>
		<dt>Class of ".${'class'.$i}."</dt>
		".${'bros'.$i}."<br>
		</td>";
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
	<title>Brothers - Asian American Brotherhood - Harvard College</title>
	<?php include_once "head.php" ?>
	<script>
$(function(){
	$('#tabs').tabs();
});
	</script>
</head>

<body id="brothers">
<div class="wrap">

	<?php include_once "$header.php" ?>

	<div class="body-content">
		<div id='tabs' class='ui-tabs lift-shadow'>
			<ul class='ui-tabs-nav'>
			<li class='ui-tabs-active'><a href="#broster">Brothers</a></li>
			<li><a href="#a_broster">Alumni</a></li>
			</ul>
		
			<div id='broster'>
			<div class='overflow'>
				<table width="100%" cellspacing="0" cellpadding="0" class='broster'>
				<tr valign="top">
				<?php echo $broster ?>
				</tr>
				</table>
			</div>
			</div>
			
			<div id='a_broster'>
			<div class='overflow'>
				<table width="100%" cellspacing="0" cellpadding="0" class='broster'>
				<tr valign="top">
				<?php echo $a_broster ?>
				</tr>
				</table>
			</div>
			</div>
		</div>
	</div>

</div>

</body>
</html>
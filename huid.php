<?php
include_once "scripts/checkbro.php";

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
			$huid = $row['HUID16'];
		
			${'class'.$i} = $i;
			${'bros'.$i} .= "<tr><td>$firstname $lastname</td><td>$huid</td></tr>";
		}

		$broster .= "${'bros'.$i}";
	}
}

mysql_close($mysql_connection);
?>
<table><?php echo $broster ?></table>
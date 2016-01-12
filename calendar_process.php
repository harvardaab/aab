<?php

include "scripts/checkbro.php";

if (isset($_GET['request'])) {
$request = $_GET['request'];

if ($request == "calendar"){

	$calendar = "<div class='lookupContent'><p class='bold'>You must be logged into a <a href='http://www.gmail.com'>Gmail account</a> authorized to view the official calendar.</p>
	<iframe src='https://www.google.com/calendar/embed?src=aa.brotherhood%40gmail.com&ctz=America/New_York' style='border: 0' width='700' height='500' frameborder='0' scrolling='no'></iframe></div>";
	echo $calendar;
	
}

if ($request == "bdays") {

$bday_sql = mysql_query("SELECT * FROM brothers WHERE birthday != ''") or die (mysql_error());
$bday_count = mysql_num_rows($bday_sql);
if ($bday_count > 0) {
	while ($b = mysql_fetch_array($bday_sql)) {
		$bro = $b['bro'];
		$firstname = $b['FirstName'];
		$lastname = $b['LastName'];
		$birthday = $b['Birthday'];
		$class = $b['Class'];
		$classY = substr($class, 2);
		
		$requested_month = $_GET['month'];
		
		// If current date is requested
		if ($requested_month == "current") {
			$thismonth = date('m');
		} else { $thismonth = $requested_month; } // any other month
		$time = mktime(0, 0, 0, $thismonth);
		$month_name = strftime("%B", $time);
		
		// breakdown bdays of every member
		list($bday_y, $bday_m, $bday_d) = explode("-", $birthday);
		
		// if their month is same as the requested month
		if ($bday_m == $thismonth) {
			$allbdaysthismo[$bday_d] = "<tr><td width='40'>$bday_d</td><td><a href='directory?bro=$bro'>$firstname $lastname '$classY</a></td></tr>";
		}
	}
		
		ksort($allbdaysthismo);
		foreach ($allbdaysthismo as $bday_boy) {
			$list .= "$bday_boy";
		}
		
				$month_name = array(1 => "January",
									2 => "February",
									3 => "March",
									4 => "April",
									5 => "May", 
									6 => "June", 
									7 => "July", 
									8 => "August", 
									9 => "September", 
									10 => "October",
									11 => "November",
									12 => "December");
				
				foreach (range(01, 12) as $month) {
					$selected = "";
					if($month == $thismonth) { $selected = " selected"; }
						$birthday_month .= "<option value='$month'$selected>$month_name[$month]</option>";
				}
		
		$bdays_thismo = "<div class='lookupContent'>
			<span class='title'>Birthdays in </span><select id='bdaymonth'>$birthday_month</select>
			<table cellpadding='0' cellspacing='0' id='bdaylist'>$list</table></div>
			<script>
$(function(){
	$('select#bdaymonth').change(function(){
		var text = $(this).val();
		var link = 'calendar_process?request=bdays&month=';
		var newmonth = link + text;
		$('div.lookupDiv').load(newmonth);
	});
});
			</script>";
		echo $bdays_thismo;

}

}
}
?>
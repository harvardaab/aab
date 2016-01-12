<?php
session_start();

if ((isset($_SESSION['bro'])) || (isset($_COOKIE['broCookie']))) {
	$header = "headerInside";
} elseif ((!isset($_SESSION['bro'])) && (!isset($_COOKIE['broCookie']))) {
	$header = "headerOutside";
}
	
    require "connect_to_mysql.php";

    /*=========== If session ID is set for logged in user
		The regular session expires by default every time the user closes their browser down
		If that is the case this section will not run and the section below for recognizing set cookies will run =========*/
    if (isset($_SESSION['bro'])) { 
		$bro = $_SESSION['bro'];
		$FirstName = $_SESSION['FirstName'];
		$LastName = $_SESSION['LastName'];
		
		
		// PROFILE PICTURE
		$profpic = "vault/photos/profpic/$bro.jpg";
		$default = "vault/photos/profpic/default.jpg";
		if (file_exists($profpic)) {
			$thumbnail = "<img src='$profpic' class='thumb medium' id='profthumb' style='cursor:pointer;'/>";
		} else {
			$thumbnail = "<img src='$default' class='thumb medium' />";
		}
		
    }
	
    /*=========== If cookies are set, but no session ID is set yet, we set it below and update the LastActivity =========*/
    if (isset($_COOKIE['broCookie'])) {
		$bro = $_COOKIE['broCookie'];
		$FirstName = $_COOKIE['firstnameCookie'];
		$LastName = $_COOKIE['lastnameCookie'];

    	// Register the session vars just like in the login form
    	$_SESSION['bro'] = $bro;
    	$_SESSION['FirstName'] = $FirstName;
		$_SESSION['LastName'] = $LastName;

    	/* ========= Update Last Activity Date Field (Check last visit date does not equal today) =========*/
    	$activity_sql = mysql_query("SELECT LastActivity FROM brothers WHERE bro='$bro'"); 
    	while($row = mysql_fetch_row($activity_sql)){ 
    		$LastActivity = $row["LastActivity"];
    	}
    
    	$now = date("Y-m-d G:i:s"); // This sets today's date in a matching format
		$LastActivity = strftime("%Y-%m-%d %G-%i-$s", strtotime($LastActivity));

		if ($LastActivity != $now) {
			mysql_query("UPDATE brothers SET LastActivity=now() WHERE bro='$bro'"); 
		}
    }


	$outside_pages = array("index","about","constitution","leadership","recruit","brothers","brofile","news","media","events","gallery","contact","alumni","login");
	$inside_pages = array("directory","calendar","content","library","archives","prefs","profile","pftw","recruiting_directory","recruiting_lb","recruiting_add");
	$path = $_SERVER['SCRIPT_NAME'];
	$path = substr($path, 1);
	$path = substr($path, 0, -4);
	
	if (in_array($path, $outside_pages)) {
		$style = "styleOutside";
	} elseif (in_array($path, $inside_pages)) {
		if ((!isset($_SESSION['bro'])) && (!isset($_COOKIE['broCookie']))) {
			header('location: .');
		}
		$style = "styleInside";
		
		
		// ONLY SHOW RECRUITING APP DURING SEASON (before March 7th)
		$thismonth = date("n");
		$thisday = date("d");
		$monthday = "$thismonth$thisday";
		
		if ($monthday < 307) {
			$recruitingapp = "<a href='recruiting_directory'><img src='pix/user.png' class='nav-icons' style='height:35px; width:30px'/></a>";
		}
	}

?>
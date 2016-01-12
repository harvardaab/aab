<?php include "scripts/checkbro.php";

if (isset($_SESSION["bro"])) {
	header("location: .");
}

if (isset($_GET['bro']) && isset($_GET['password'])) {

	if ($_GET['bro'] == "") {
		echo "<font id='error'>Choose your name.</font>";
	} elseif ($_GET['password'] == "") {
		echo "<font id='error'>Enter a valid password.</font>";
	} elseif ($_GET['bro'] != "") {

	include_once "scripts/connect_to_mysql.php";

	$bro = $_GET['bro'];
	$password = $_GET['password'];
	$remember = $_GET['remember']; // Added for the remember me feature

	$bro = mysql_real_escape_string($bro);
	$password = mysql_real_escape_string($password);

	$sql = mysql_query("SELECT * FROM brothers WHERE bro='$bro' AND Password='$password'"); 
	$login_check = mysql_num_rows($sql);

		if($login_check > 0){ 

			while($row = mysql_fetch_array($sql)){ 
	        $bro = $row["bro"];   
    	    $_SESSION['bro'] = $bro;
       
			$FirstName = $row["FirstName"];
			$_SESSION['FirstName'] = $FirstName;

			$LastName = $row["LastName"];
			$_SESSION['LastName'] = $LastName;
         
			mysql_query("UPDATE brothers SET LastActivity=now() WHERE bro='$bro'");
			}
	
    		if ($remember == "yes") {
			setcookie("broCookie", $bro, time()+90*24*60*60, "/"); // 90 days; 24 hours; 60 mins; 60secs
			setcookie("firstnameCookie", $FirstName, time()+90*24*60*60, "/");
			setcookie("lastnameCookie", $LastName, time()+90*24*60*60, "/");
			}
    		
    		echo "<font id='success'>Welcome.</font>";
    		
	
		} else {
			echo "<font id='error'>Wrong password! Try again.</font>";
			exit();
		}
	}
}
?>
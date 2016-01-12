<?php
session_start();
// Destroy sessions and cookies
	
    // Unset all of the session variables.
    $_SESSION = array();
    // Note: This will destroy the sessions, and not just the session variable data that the sessions hold
    session_unset();
    session_destroy();
    session_write_close();
    
    // Added for the Remember Me feature, to set the cookies to a time in the past
    setcookie("broCookie", '', time()-42000, '/');
	setcookie("firstnameCookie", '', time()-42000, '/');
	setcookie("lastnameCookie", '', time()-42000, '/');
	setcookie("emailCookie", '', time()-42000, '/');
	setcookie("passwordCookie", '', time()-42000, '/');


if(!isset($_SESSION['bro'])) { 
	header('location: .');
	exit();
} else {
    echo "There was an error in logging out.";
    exit();
}


?>
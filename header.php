<?php //header.php

session_start();
echo "<!DOCTYPE html>\n<html><head><script src='js/osc.js'></script><script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>
<script src='http://code.jquery.com/jquery-migrate-1.2.1.min.js'></script>";
include 'functions.php';

$userstr = ' (Guest)';

if (isset($_SESSION['user'])) {
	$user 	  = $_SESSION['user'];
	$loggedin = TRUE;
	$userstr  = " ($user)";
}
else {
	$loggedin = FALSE;
}

echo "<title>$appname$userstr</title><link href='css/main.css' rel='stylesheet' type='text/css' />" .
	 "</head><body><div class='$appname'>$appname$userstr</div>";

if ($loggedin) {
	echo "<br /><ul class='menu'>" . 
		 "<li><a href='members.php?view=$user'>Home</a></li>" . 
		 "<li><a href='members.php'>Members</a></li>" . 
		 "<li><a href='friends.php'>Friends</a></li>" . 
		 "<li><a href='messages.php'>Messages</a></li>" . 
		 "<li><a href='profile.php'>Edit Profile</a></li>" . 
		 "<li><a href='logout.php'>Log Out</a></li></ul><br />";
}
else {
	echo ("<br /><ul class='menu'>" . 
		"<li><a href='index.php'>Home</a></li>" . 
		"<li><a href='signup.php'>Sign Up</a></li>" . 
		"<li><a href='login.php'>Log In</a></li></ul><br />" . 
		"<span class='info'>&#8654; You must be logged in to view this page.</span><br /><br />"
		);
}

?>
<?php //logout.php

include_once 'header.php';

if (isset($_SESSION['user'])) {
	destroySession();
	echo "<script> location.replace('index.php');</script>";
	exit();
}
else {
	echo "<div class='main'><br />You cannot log out because you are logged in.";
}

?>

<br /><br /></div></body></html>
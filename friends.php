<?php //friends.php

include_once 'header.php';

if (!$loggedin) {
	die();
}

if (isset($_GET['view'])) {
	$view = sanitizeString($_GET['view']);
}
else {
	$view = $user;
}



?>
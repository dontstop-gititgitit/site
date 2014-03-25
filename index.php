<?php //index.php

include_once 'header.php';

echo "<br /><span class='main'>Welcome to ATConnect,";

if ($loggedin) {
	echo " '$user', you are logged in.";
}
else {
	echo " please sign up and/or log in";
}

?>
</span><br /><br /></body></html>
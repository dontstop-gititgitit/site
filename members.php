<?php //members.php

include_once 'header.php';

if (!$loggedin) {
	die();
}

echo "<div class='main'>";

if (isset($_GET['view'])) {
	$view = sanitizeString($_GET['view']);

	if ($view == $user) {
		$name = "Your";
	}
	else {
		$name = "$view's";
	}

	echo "<h3>$name Profile</h3>";
	showProfile($view);
	echo "<a class='button' href='messages.php?view=$view'>View $name's messages</a><br /><br />";
	die("</div></body></html>");
}

if (isset($_GET('add'))) {
	$add = sanitizeString($_GET['add']);

	if (!mysql_fetch_rows(queryMyqsl("SELECT * FROM friends WHERE user='$add' AND friend='$user'"))) {
		queryMyqsl("INSERT INTO friends VALUES ('add', '$user')");
	}
	elseif (isset($_GET['remove'])) {
		$remove = sanitizeString($_GET['remove']);
		queryMyqsl("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
	}

	$result = queryMyqsl("SELECT user FROM members ORDER BY user");
	$num = mysql_num_rows($result);

	echo "<h3>Other Members</h3><ul>";

	for ($i = 0; i < $num; ++$i) {
		$row = mysql_fetch_row($result);
		if ($row[0] == $user) {
			continue;
		}
		echo "<li><a href='members.php?view=$row[0]'>$row[0]</a>";
		$follow = "follow";

		$t1 = mysql_num_rows(queryMyqsl("SELECT * FROM friends WHERE user='$row[0]' AND friend='$user'"));
		$t2 = mysql_num_rows(queryMyqsl("SELECT * FROM friends WHERE user='$user' AND friend='$row[0]"));

		if (($t1 + $t2) > 1) {
			echo " $harr; is a mutual friend";
		}
		elseif ($t1) {
			echo " $larr you are following";
		}
		elseif ($t2) {
			echo " $rarr is following you";
			$follow = "recip";
		}

		if (!$t1) {
			echo " [<a href='members.php?add=" . $row[0] . "'>$follow</a>]";
		}
		else {
			echo " [<a href='members.php?remove=" . $row[0] . "'>$drop</a>]"; 
		}
	}
}

?>

<br /></div></body></html>
<?php //profile.php

include_once 'header.php';

if (!$loggedin) {
	die();
}

echo "<div class='main'><h3>Your Profile</h3>";

if (isset($_POST['department'])) {
	$department = sanitizeString($_POST['department']);
	$department = preg_replace('/\s\s+/', ' ', $department);

	if (mysql_num_rows(queryMysql("SELECT * FROM profiles WHERE user='$user'"))) {
		queryMysql("UPDATE profiles SET department='$department' WHERE user='$user'");
	}
	else {
		queryMysql("INSERT INTO profiles VALUES('$user', '$department')");
	}
}
else {
	$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

	if (mysql_num_rows($result)) {
		$row = mysql_fetch_row($result);
		$department = stripslashes($row[1]);
	}
	else {
		$department = "";
	}
}
$department = stripslashes(preg_replace('/\s\s+/', ' ', $department));

if (isset($_POST['position'])) {
	$position = sanitizeString($_POST['position']);
	$position = preg_replace('/\s\s+/', ' ', $position);

	if (mysql_num_rows(queryMysql("SELECT * FROM profiles WHERE user='$user'"))) {
		queryMysql("UPDATE profiles SET position='$position' WHERE user='$user'");
	}
	else {
		queryMysql("INSERT INTO profiles VALUES('$user', '$position')");
	}
}
else {
	$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

	if (mysql_num_rows($result)) {
		$row = mysql_fetch_row($result);
		$position = stripslashes($row[1]);
	}
	else {
		$position = "";
	}
}
$position = stripslashes(preg_replace('/\s\s+/', ' ', $position));

if (isset($_FILES['image']['name'])) {
	$saveto = "img/$user.jpg";
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	$typeok = TRUE;

	switch ($_FILES['image']['type']) {
		case 'image/gif':
			$src = imagecreatefromgif($saveto);
			break;
		case 'image/jpeg':
		case 'image/pjpeg':
			$src = imagecreatefromjpeg($saveto);
			break;
		case 'image/png':
			$src = imagecreatefrompng($saveto);
			break;
		default:
			$typeok = FALSE;
			break;
	}

	if ($typeok) {
		list($w, $h) = getimagesize($saveto);

		$max = 200;
		$tw = $w;
		$th = $h;

		if ($w > $h && $max < $w) {
			$th = $max / $w * $h;
			$tw = $max;
		}
		elseif ($h > $w && $max < $h) {
			$tw = $max / $h * $w;
			$th = $max;
		}
		elseif ($max < $w) {
			$tw = $th = $max;
		}

		$tmp = imagecreatetruecolor($tw, $th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
		imagejpeg($tmp, $saveto);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}

showProfile($user);
?>

<form method='post' action='profile.php' enctype='multipart/form-data'>
<span>Department: <?php echo "$department" ?></span><textarea name='department' cols='50' rows='3' placeholder="Department"><?php $department ?></textarea><br />
<span>Position: <?php echo "$position" ?></span><textarea name='position' cols='50' rows='3' placeholder="Position"><?php $position ?></textarea><br />
Image: <input type='file' name='image' size='14' maxLength='32' />
<input type='submit' value='Save Profile' />
</form></div><br /></body></html>



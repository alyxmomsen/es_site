<?php
$width = '100%';
$height = '100%';
require "db_connect.php";
$pdo = $GLOBALS['pdo'];
//echo $_POST['url'];
echo '<video width="100%" controls="controls" poster="'.$_POST['url'].'"><source src="'.$_POST['url'].'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'></video>';
// echo "<iframe src=\"https://oum.video/embed/291/\" allowfullscreen style=\"border:none;position:absolute;top:0;left:0;width:100%;height:100%;\"></iframe>";
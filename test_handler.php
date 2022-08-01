<?php

require "db_connect.php";
$pdo = $GLOBALS['pdo'];
$path = $_POST['url'];
$q_str = 'select name from video_files where name=\''.$path.'\'';
$result = $pdo->query($q_str);
$row = $result->fetchall(PDO::FETCH_ASSOC);
//echo $q_str;
echo '<video controls="controls" poster="video/duel.jpg">
            <source src="'.$row[0]['name'].'">
        </video>';

<?php 

$param_a = null;
$param_b = null;

if($_GET['a']) $param_a = $_GET['a'];

if($_GET['b']) $param_b = $_GET['b'];;

require 'db_connect.php';

function linkerMediaToThemes($param_a , $param_b)
{
    global $pdo;

    $qs = "INSERT ignore INTO rel_media_themes (media_id , theme_id) VALUES (? , ?)";

    $statement = $pdo->prepare($qs);

    $statement->execute([$param_a , $param_b]);
    
}


function linkerNewsToThemes($param_a , $param_b)
{
    global $pdo;

    $qs = "INSERT ignore INTO rel_news_themes (media_id , theme_id) VALUES (? , ?)";

    $statement = $pdo->prepare($qs);

    $statement->execute([$param_a , $param_b]);
}

linkerNewsToThemes($param_a , $param_b);


?>
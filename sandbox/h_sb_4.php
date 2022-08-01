<?php

require_once '../db_connect.php';
global $pdo ;
function f1 ($pdo) {

    $statement = $pdo->prepare('SELECT news.* FROM news WHERE news.cdt > \'2021-10-20\'');
    $statement->execute();
    $res = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $res ;


//    echo 'norma';
//    return 'ok ;
}

$result = f1($pdo);

echo json_encode($result);




?>
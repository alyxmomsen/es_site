<?php 

function getDiary(){
    echo 'hello kitty';
}

// getDiary();


// $pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
require_once '../../db_connect.php';
global $pdo;

$statement = $pdo->prepare("SELECT * FROM my_diary");

$statement->execute();

$result = $statement->fetchAll();




// echo count($result);
// echo JSON.parse($result);
echo json_encode($result);

// echo 'hello there';


function diaryButtonHandler(){
    echo 'hello world';
}




?>



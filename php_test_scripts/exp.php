<?php 

$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

function updatePathesForVideo() {

    // require 'db_connect.php';
$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

// global $pdo;


$query_string = "SELECT `video_files`.* FROM video_files WHERE `path` LIKE '<iframe%'";

$statement = $pdo->prepare($query_string);

$statement->execute();

$res = $statement->fetchAll(PDO::FETCH_ASSOC);

$thePattern = '~height="269"~';

$theArray = array();

$count = 0;

$second_querry_string = "UPDATE video_files SET path = ? WHERE id = ?";

$another_statement = "";

foreach($res as $theRow) {
    // echo $theRow['id'] . '<br>';
    // preg_match($thePattern , $theRow['path'] , $theArray);
    
    // foreach($theArray as $tr) {
        // echo $tr ;
    // }
    // var_dump($theArray);
    // if($theArray['m']) echo $theArray['m'];

    $another_statement = $pdo->prepare($second_querry_string);

    $another_statement->execute([preg_replace($thePattern , 'height="100%"' , $theRow['path']) , $theRow['id']]);

    // $res_2 = $another_statement->fetchAll(2);

    


    // echo '<div style="width:255px;">' . preg_replace($thePattern , 'height="109%"' , $theRow['path']) . '</div>';
    // echo '<br>';

    // $count++;
    // if($count > 6) break;


}



}

// echo '__FILE__ : ' . __FILE__ . '<br>';
// echo '__LINE__ : ' .  __LINE__ . '<br>';
// echo '__DIR__' . __DIR__ . '<br>';
// echo '__CLASS__' . __CLASS__ . '<br>';
// echo '__METHOD__' . __METHOD__ . '<br>';
// echo '__FUNCTION__' . __FUNCTION__ . '<br>';
// echo '__NAMESPACE__' . __NAMESPACE__ . '<br>';
// echo __ . '<br>';
// echo . '<br>';
// echo . '<br>';

$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

$themesQS = "SELECT themes.* FROM themes WHERE themes.id = ?";
$newsThemesQS = "SELECT news_theme.* FROM news_theme";


$themesQrSt = $pdo->prepare($themesQS);


$newsThemesSt = $pdo->prepare($newsThemesQS);
$newsThemesSt->execute();
$rslt = $newsThemesSt->fetchAll(PDO::FETCH_ASSOC);
foreach($rslt as $row){
    $themesQrSt->execute([$row['theme_id']]);
    $rslt2 = $themesQrSt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rslt2 as $row2) {
        echo $row2['theme_name'] . '/';
        if($row2['reserve']) {
            echo "warning!!!";
        }
    }
    echo '<br>';
}


?>
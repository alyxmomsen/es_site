<?php

require '../db_connect.php';

// print_r($GLOBALS);

function diaryButtonHandler($pdoObject){

    
    
    // global $pdo;
    $query = "select * from my_diary order by cdt";
    $statement = $pdoObject->prepare($query);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);


    echo "<div id='diary-main-container'>";

    $lastDate = 0;

    foreach($result as $row){
        // echo strtotime($row['create_date']);
        if(strtotime($row['create_date']) > $lastDate):
            echo "<div class='diary-the-day'>$row[create_date]</div>";
            $lastDate = strtotime($row['create_date']);
        endif;
        echo "<div class='diary-note-box'>";
        echo "<span class='diary-note-time'>$row[create_time]</span>";
        echo "<p class='diary-note-body'>$row[body]</p>";
        echo "</div>";
        


    }
    // echo 'data';
    echo "</div>";
}

diaryButtonHandler($GLOBALS['pdo']);






?>


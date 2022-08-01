<?php

require 'db_connect.php';


if($_POST['rqst']):
    if($_POST['rqst']==='full_organiztions')
    {
        global $pdo;
        $query = "select * from organization";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
        // echo json_encode('hey');
        echo json_encode($result);
    }
    else{
        echo json_encode('hi');
    }
else:
    echo json_encode('oops');
endif;



?>
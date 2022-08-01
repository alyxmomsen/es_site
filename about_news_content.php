<?php

require 'db_connect.php' ;
// $_POST[start_year]
function get_about() {
    global $pdo;
    $query = "select * from news WHERE cdt like '%-$_POST[start_month]-%' and cdt like '%$_POST[start_year]-%'";
    // $query = "select * from news WHERE cdt like '%-?-%' and cdt like '%2021-%'";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

$arrTo  = array();
$temp_arr = array();
$pat = "~$_POST[start_year]-$_POST[start_month]-(?<days>\d*)~i";
foreach(get_about() as $val) {
    preg_match_all($pat , $val['cdt'] , $temp_arr);
    $arrTo[] = (int)$temp_arr['days'][0];
}

array_unique($arrTo);

echo json_encode(array_unique($arrTo));


?>
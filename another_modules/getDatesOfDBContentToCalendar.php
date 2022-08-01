<?php

require_once '../db_connect.php' ;
global $pdo;


class GetAboutDBContent {


    protected $pdo;

    function __construct ($pdo) {
        $this->pdo = $pdo;
    }

    function setNullIfItNeed($val) {
        if($val < 10) return '0' . $val;
        else return $val;
    }

    public function get ($details = '') {

        $month = $this->setNullIfItNeed($_POST['month']);
        $year = $this->setNullIfItNeed($_POST['year']);

        $qs = "SELECT news.* FROM news WHERE news.cdt LIKE '%$year-$month%'";
        $statement = $this->pdo->prepare($qs);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

//        return json_encode($_POST);
        return json_encode($result);
//        return json_encode(['hello']);
    }
}

$gadbc = new GetAboutDBContent($pdo);
echo $gadbc->get();



?>




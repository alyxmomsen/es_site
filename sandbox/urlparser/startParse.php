<?php 

/* $pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y'); */


class DB_manager_v2 {
    public $counter = 0 ;
    public $rows = NULL ;
    public $query_string = '' ; /* SELECT equipment.* FROM equipment ORDER BY equipment.timestamp */


    function __construct()
    {

        $this->pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
    }

    function getRows($qs = '') {

        $statement = $this->pdo->prepare($qs) ;
        $statement->execute() ;
        $result = $statement->fetchAll(PDO::FETCH_ASSOC) ;
        $this->rows = $result ;
        return $this->rows ;

    }
}

$dbm = new DB_manager_v2() ;
$dbm->getRows('SELECT news.* FROM news ;') ;

echo '<pre>' ;
foreach ($dbm->rows as $row) {
    echo '<br>' ;
    echo parse_url($row['source_from'])['host'] ;
    echo " " . $row['id'] ;
}
echo '</pre>' ;
// var_dump(parse_url($row['source_from'])['host']) ;



?>
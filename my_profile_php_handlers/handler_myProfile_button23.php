<?php 

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
$dbm->getRows('SELECT children_video_content.* FROM `children_video_content` ORDER BY children_video_content.timestamp ASC') ;


?>
<div id='forKids-main-div'>
<?php 

echo '<ul>';
    foreach(/* $data_array */ $dbm->rows as $row){
        echo "<li><a target='_blank' href='$row[url]'>$row[title]</a>";
    }
echo '</ul>';

?>
</div>

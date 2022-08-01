<?php 

class DB_manager_v2 {
    public $counter = 0 ;
    public $rows = NULL ;
    public $query_string = '' ;


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

$dbm = new DB_manager_v2();
$dbm->getRows('SELECT subsection_the_locations.* FROM subsection_the_locations ORDER BY subsection_the_locations.id ASC');



?>
<div id='locations-main-div'>
    <ul>
        <?php 
        foreach($dbm->rows as $row) {
            echo '<li><a href="' . $row['url'] . '" target="_blank">' . $row['title'] . '</a></li>' ;
        }
        
        
        
        ?>
    </ul>
</div>
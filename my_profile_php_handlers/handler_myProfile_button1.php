<?php 
class DB_manager {
    public $rows = NULL ;


    function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
    }

    function getRows() {

        $statement = $this->pdo->prepare('SELECT equipment.* FROM equipment ORDER BY equipment.timestamp;') ;
        $statement->execute() ;
        $result = $statement->fetchAll(PDO::FETCH_ASSOC) ;
        $this->rows = $result ;
        return $this->rows ;

    }
}

$dbm = new DB_manager() ;
$dbm->getRows() ;


?>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
</style>
<div id='gadgets-main-container'>
    <?php 
    
    foreach($dbm->rows as $row) {
        echo "<div class='gadgets-item'>" ;
        echo "<span class='gadgets-item-date'>" . $row['timestamp'] ."</span>" ;
        echo "<p class='gadgets-body'>" . $row['body'] . "</p>"  ;
        echo "</div>" ; /* class='gadgets-item' */
    }
    
    
    
    ?>
    
</div>


<?php 

// require_once '../db_connect.php';

function get_these_quotes(){

    // $pdo = $GLOBALS['pdo'];
    global $pdo;
    $query = 'select * from quotes';
    $res = $pdo->query($query);
    $data = $res->fetchall(PDO::FETCH_ASSOC);
    return $data;
}

$quotes = get_these_quotes();
// echo count($quotes);

?>

<div id='quotesSlider' class='carousel slide' data-ride='carousel'>
<div class='carousel-inner'>

<?php
    $isntUsed = TRUE;
    foreach($quotes as $row){
        echo "<div class='carousel-item " ;
        if($isntUsed){
            echo " active";
            $isntUsed = FALSE;
        }
        echo "' data-bs-interval='1000'>";
        echo "<p class='quote ru'>$row[content]</p>";
        echo "</div>";
    }
?>
    
</div>
</div>
<!-- <ol class='carousel-indicators'>
    <li data-target='#quotesSlider' data-slide-to='0' class='active'></li>
    <li data-target='#quotesSlider' data-slide-to='1'></li>
    <li data-target='#quotesSlider' data-slide-to='2'></li>
</ol> -->

<style>
    

    /* @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap'); */
    /* @import url('https://fonts.googleapis.com/css2?family=Lobster&family=Stalinist+One&display=swap'); */

    div.quote {
        width: 20%;
        color: whitesmoke;
        font-family: 'Oswald', sans-serif;
        font-size: 22px;
        height: 126px;
    }

</style>

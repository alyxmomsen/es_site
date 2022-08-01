<?php

require_once '../db_connect.php' ;

class NecrologueManager {

    protected $pdo ;
    public $allRows = [];


    function __construct($pdo)
    {
        $this->pdo = $pdo ;
    }


    function getAllRows ()
    {
        $statement = $this->pdo->prepare("SELECT necrologue.* FROM necrologue ORDER BY necrologue.died_date ASC") ;
        $statement->execute() ;
        $result = $statement->fetchAll() ;
        return $result ;
    }
}

global $pdo ;

$necroman = new NecrologueManager($pdo) ;
$necroman->allRows = $necroman->getAllRows() ;

?>
<div id="my-profile-necrologue">
    <?php

    foreach ($necroman->allRows as $row)
    {
        echo "<div class='mp-necrologue-item'>" ;
        echo '<div class="mp-necrologue-img-wrapper">' ;
        echo "<img src='$row[img]' alt=''>" ;
        echo '</div>' ;
        echo '<div class="mp-necrologue-main-contant-wrapper">' ;
        echo '<div class="mp-necrologue-full-name-container">' ;
        echo "<span class='name'>$row[name]</span>" ;
        echo "<span class='surname'>$row[surname]</span>" ;
        echo "<span class='patronymic-name'>$row[patronymic_name]</span>" ;
        echo '</div>' ;
        echo '<div class="mp-necrologue-died-date-wrapper">' ;
        echo "<span class='mp-necrologue-died-date-caption'>дата смерти</span><span class='mp-necrologue-died-date-data'>$row[died_date]</span>" ;
        echo '</div>' ;
        echo '<div class="mp-necrologue-src-wrapper">' ;
        echo "<a target='_blank' class='mp-necrologue-src-data' href='$row[proof]'>источник " . parse_url($row['proof'])['host'] . "</a>" ;
        echo '</div>' ;
        echo '</div>' ;
        echo '</div>' ;
    }



    ?>
</div>

<style>

    div#my-profile-necrologue {
        width: 546px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 9px;
        font-family: 'Playfair Display', serif;
    }

    div#my-profile-necrologue .mp-necrologue-item {
        display: flex;
        gap: 9px;
        border: 1px solid black ;
        padding: 9px ;
    }

    div#my-profile-necrologue .mp-necrologue-img-wrapper img {
        width: 100% ;
        height: 100% ;
        object-fit: cover ;
    }

    div#my-profile-necrologue .mp-necrologue-img-wrapper {
        flex: 2;
        height: 144px;
    }

    div#my-profile-necrologue .mp-necrologue-main-contant-wrapper {
        flex: 5;
        font-size: 22px;
    }

    div#my-profile-necrologue .mp-necrologue-full-name-container {
        display: flex ;
        gap: 9px ;
    }

    div#my-profile-necrologue .mp-necrologue-died-date-wrapper {
        display: flex ;
        gap: 9px ;
    }

    div#my-profile-necrologue .mp-necrologue-src-wrapper {

    }

    div#my-profile-necrologue .mp-necrologue-src-wrapper a:hover {
        color:inherit ;
    }

    /*div#my-profile-necrologue {}*/

    /*div#my-profile-necrologue {}*/



</style>
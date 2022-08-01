<?php

require_once '../db_connect.php';

global $pdo;

//var_dump($pdo);

class HumorVideoManager {

    protected $pdo;

    function __construct ($pdo) {
        $this->pdo = $pdo;
    }


    function getVideo () {
        $str = "SELECT video_to_humor.* FROM video_to_humor";
        $statement = $this->pdo->prepare($str);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);


        return $result;
    }



}

$hvm = new HumorVideoManager ($pdo) ;


?>

<div id="module-myProfile-humor">
    <div id="container-videoPlayer">
        <div class="container-display"></div>
        <div class="container-playlist">
            <?php

            foreach ($hvm->getVideo() as $row) {
                echo "<div><span data-kind='$row[kind]' data-path='$row[path]'>$row[title]</span></div>";
            }



            ?>
        </div>
    </div>

</div>
<div id="scriptBlock"></div>


<style>

    #module-myProfile-humor {

    }

    #module-myProfile-humor #container-videoPlayer {
        width: 80%;
        height: 365px;
        display: flex;
        justify-content: stretch;
        align-items: stretch;
        margin: 0 auto;
    }


    #container-videoPlayer div.container-display {
        background-color: black;
        flex: 3;
    }

    #container-videoPlayer div.container-playlist {
        background-color: grey;
        flex: 2;
        overflow-y: scroll;
        padding: 9px;
        font-size: 18px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        column-gap: 9px;
        scrollbar
    }

</style>
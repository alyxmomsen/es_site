<?php

require_once '../db_connect.php';

global $pdo;

//var_dump($pdo);

class HumorVideoManager {

    protected $pdo;
    public $rows;

    function __construct ($pdo) {
        $this->pdo = $pdo;
    }


    function getVideo () {
        $str = "SELECT video_to_humor.* FROM video_to_humor";
        $statement = $this->pdo->prepare($str);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->rows = $result;
        return $result;
    }



}

$hvm = new HumorVideoManager ($pdo) ;
$hvm->getVideo();


?>

<div id="module-myProfile-humor">
    <div id="container-videoPlayer">
        <div class="container-videoPlayer-amount-display"><span class="container-videoPlayer-amount-title">Видео: </span><span class="container-videoPlayer-amount-data"><?= count($hvm->rows) ?></span></div>
        <div class='wrapper'>
            <div class="container-display"></div>
            <div class="container-playlist">
                <?php

                foreach ($hvm->rows as $row) {
                    echo "<div><span data-kind='$row[kind]' data-path='$row[path]'>$row[title]</span></div>";
                }

                ?>
            </div>
        </div>

    </div>

</div>
<div id="scriptBlock"></div>


<style>

    #module-myProfile-humor {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #2a2828;
    }

    #module-myProfile-humor #container-videoPlayer {
        width: 80%;
    }

    #module-myProfile-humor #container-videoPlayer .wrapper {
        width: 100%;
        height: 448px;
        display: flex;
        justify-content: stretch;
        align-items: stretch;
        margin: 0 auto;
        padding: 48px 0;
        background-color: black;
    }


    #container-videoPlayer div.container-display {
        background-color: black;
        flex: 3;
    }

    #container-videoPlayer div.container-playlist {
        background-color: #212121;
        flex: 2;
        overflow-y: scroll;
        padding: 9px;
        font-size: 18px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        column-gap: 9px;
        scrollbar: ;
        color: #adadad;
        scrollbar-width: thin;
    }

    #container-videoPlayer div.container-playlist > div {
        /*transition: .2s ease-out;*/
        width: 100%;
    }

    #container-videoPlayer div.container-playlist > div:hover {
        background-color: whitesmoke;
        color: black;
    }

    #container-videoPlayer div.container-playlist > div > span {
        cursor: pointer;
        transition: .2s ease-out;
        width: 100%;
    }

    #container-videoPlayer div.container-playlist > div > span:hover {
        padding: 0 0 0 6px;
    }



    /*unsorted styles*/


    .container-videoPlayer-amount-display {
        display: flex;
        justify-content: center;
        gap: 9px;
    }

    .container-videoPlayer-amount-display span {
        color: whitesmoke;
        /* font-family: 'Oswald', sans-serif; */
        /*font-family: 'Playfair Display', serif;*/
    }

</style>
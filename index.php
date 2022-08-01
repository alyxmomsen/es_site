<?php

// exit();

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом

// print_r($_SERVER);
require_once "db_connect.php"; 
require "functions_for_themes.php";

class tagsManager {
    public $errors = [];
    public $toDisplay = [];
    public $pdo;

    function __construct ($pdo) {
        if(!$pdo): 
            $errors[] = 'no pdo';
        else:
            $this->pdo = $pdo;
            $this->toDisplay[] = $this->pdo;
        endif;
    }

    function getTagByTagID ($tagID) {
        $statement = $this->pdo->prepare ("SELECT hash_tags.* FROM hash_tags WHERE hash_tags.id = $tagID") ;
        $statement->execute();
        $result = $statement->fetchAll(2);
        if(count($result)):
            if(count($result) > 1):
                $this->toDisplay[] = $result[0]['name'];
                $this->errors[] = 'over';
                return $result[0]['name'];
            else:
                $this->toDisplay[] = $result[0]['name'];
                return $result[0]['name'];
            endif;
        else:
            $this->errors[] = 'null';
            return NULL;
        endif;
    }



    function getTagIDByNewsID ($newsID) {
        $statement = $this->pdo->prepare ("SELECT news_tag.* FROM news_tag WHERE news_id = $newsID") ;
        $statement->execute();
        $result = $statement->fetchAll(2);
        if(count($result)):
            if(count($result) > 1):
                $this->errors[] = 'tags count is over one';
                $this->toDisplay[] = $result[0]['tag_id'];
                return $result[0]['tag_id'];
            else:
                $this->toDisplay[] = $result[0]['tag_id'];
                return $result[0]['tag_id'];
            endif;
        else:
            return NULL ;
        endif;
        return 0;
    }


    function getTagName($newsID) {
        if(!$newsID) return NULL;
        $result = $this->getTagIDByNewsID ($newsID) ;
        if(!$result) return NULL ;
        return $this->getTagByTagID ($result) ;
        return NULL;
    }


}

?>

<?php 
//
//
function get_some_news()
{
    global $pdo;
    $qs = "SELECT news.* from news ORDER by cdt DESC LIMIT 15";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    return $statement->fetchall(PDO::FETCH_ASSOC); // const = 2;
}

// принимает id новости 
// возвращает коллекцию тегов для этой новости
function get_tags_for_the_current_news_row($news_id)
{
    global $pdo;
    $statement = $pdo->prepare('select hash_tags.* from news , hash_tags , news_tag 
    WHERE news.id = ? AND news_tag.news_id = news.id AND news_tag.tag_id = hash_tags.id');
    $statement->execute([$news_id]);
    $result = $statement->fetchall(2); //assoc
    return $result;
}

// принимает id новости 
// возвращает коллекцию тем для этой новости
function get_themes_for_the_current_news_row($news_id)
{
    global $pdo;
    $statement = $pdo->prepare('select themes.* from news , themes , news_theme 
    WHERE news.id = ? AND news_theme.news_id = news.id AND news_theme.theme_id = themes.id');
    $statement->execute([$news_id]);
    $result = $statement->fetchall(2); //assoc
    return $result;
}

// принимает id новости 
// возвращает одну img с комментарием main
function get_first_img_for_current_news_row($news_id)
{
    global $pdo;
    $statement = $pdo->prepare("
    select images.path from news , images , news_img 
    WHERE news.id = ? and news_img.comment = 'main' 
    AND news_img.news_id = news.id 
    AND news_img.images_id = images.id");
    $statement->execute([$news_id]);
    $result = $statement->fetch(PDO::FETCH_COLUMN); //assoc
    return $result;
}

function print_news()
{
    $news_rows = get_some_news(15);
    echo 'hello world';
    var_dump(strtotime($news_rows[0]['cdt']));
    $pagiNation_index = 0; // создание переменной с похожим индексом like over there
    if(isset($_GET['pagination_index'])) $pagiNation_index = $_GET['pagination_index'] * 3;
    for($i = 0 , $news_rows; $i < 3 ; $i++ , $pagiNation_index++)
    {
        if(!$news_rows[$pagiNation_index])
        {
            // игнорим несуществующие строки
            continue;
        }
        $this_body = substr($news_rows[$pagiNation_index]['body'] , 0 , 500);
        echo "
        <div class='news-item'>
            <div class='date-themes-tags flex-container'>
                <div class='date'>
                    <span>" . date('d.m.Y' , strtotime($news_rows[$pagiNation_index]['cdt'])) . " | {$news_rows[$pagiNation_index]['create_time']}</span>
                </div>
                <div class='themes'>
                    <span>";
                    foreach(get_themes_for_the_current_news_row($news_rows[$pagiNation_index]['id']) as $the_theme_item)
                    {
                        echo "<a href='news.php?theme_id=$the_theme_item[id]'> $the_theme_item[theme_name] </a>";
                    }
                    echo "
                    </span>
                </div>
            </div>
            <div class='the-img'>";
                $theimg = get_first_img_for_current_news_row($news_rows[$pagiNation_index]['id']);
                echo "
                <img src='$theimg'>
            </div>
            <h2 class='the-title'><a href='news.php#news-id-{$news_rows[$pagiNation_index]['id']}'>{$news_rows[$pagiNation_index]['title']}</a></h2>
            <p class='the-body'>$this_body...</p>
        </div>
        ";
    }

}

function printLastNews()
{
    global $pdo;
    $tm = new tagsManager ($pdo);


    // global $pdo;
    $select_all_news_qs = "select * from news order by cdt desc limit 15";
    $select_news_data_qs = "";
    $sel_all_news_sttmnt = $pdo->prepare($select_all_news_qs);
    $sel_all_news_sttmnt->execute();
    $result_arr = $sel_all_news_sttmnt->fetchall(PDO::FETCH_ASSOC);

    if($result_arr):

        $is_set_the_active = false;
        $count_of_news_items = count($result_arr);        

        for($this_counter = 0 , $i = 0 ; $i < $count_of_news_items ; $this_counter++)
        {
            echo "
                <div class='carousel-item
            ";

            if(!$is_set_the_active) 
            {
                echo " active";
                $is_set_the_active = true;
            }
            echo "
            ' data-interval='8000'>";

            echo "

            <div class='item-group'>
            
            ";
            
                for($c = 0 ; $c < 3 && $i < $count_of_news_items ; $c++ , $i++)
                {
                    // $tm->getTagName($result_arr[$i]['id']);

                    $the_img_for_current_news_id = get_first_img_for_current_news_row($result_arr[$i]['id']);
                    $themes_by_news_id = get_themes_for_the_current_news_row($result_arr[$i]['id']);
                    $trimmed_body_str = substr($result_arr[$i]['body'] , 0 , 499);
                    echo "
                    
                    <div id='block-{$result_arr[$i]['id']}' class='the_slide'>
                        <div class='date-time-block'>
                            <div class='date-time'>
                                <span date=''>" . date('d.m.Y' , strtotime($result_arr[$i]['cdt'])) ."</span>
                                <span class='separator'> | </span>
                                <span date=''>" . date('h:i:s' , strtotime($result_arr[$i]['cdt'])) ."</span>";
                    $got_tag_name = $tm->getTagName($result_arr[$i]['id']);
                                    if($got_tag_name):
                                        echo "<span class='separator'> | </span>
                                        <span date=''>" . $got_tag_name . "</span>";
                                    endif;

                            echo "</div> 
                        </div>
                        <a href='th1nws.php?th1nwsID={$result_arr[$i]['id']}'><img src='$the_img_for_current_news_id'></a>
                        <div class='body'>
                            <span class='theme'><a href=''>{$themes_by_news_id[0]['theme_name']}</a></span>
                            <span class='content'>" . strip_tags($trimmed_body_str) . "</span>
                            <div class='hidder_lol'></div>
                        </div>
                        <div class='mask-cover'></div>
                    </div>

                    ";
                }


            echo "

            </div>
            
            ";

            echo '</div>';

            
        }

    endif;


    echo '<div hidden="true">';
    print_r($tm->toDisplay);
    print_r($tm->errors);
    echo '</pre>';
    echo '</div>';

}

?>
<script></script>
<!doctype html>
<html lang="ru-RU">
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,400;0,500;1,400;1,500&display=swap" rel="stylesheet">
        <!-- ========= -->
        <?php require "meta.php"?>
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!-- \bootstrap -->
        <link rel="stylesheet" href="css/indx_v2.css?v=<?= time() ?>">
        <!-- <link rel="stylesheet" href="css/footer_v2.css?v=20210830_1538"> -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        </style>
    </head>
<body>

    <div id='' class="superMain">
        <?php require "head.php"?>
        <div class='last-news-section'>
            <!-- <h1 class='last-news-title'><a href="news.php">Новости</a></h1> -->
            <div id="carouselExampleCaptions" data-touch='true' class="carousel slide parallax" data-ride="carousel">
                <div class="carousel-inner">

                    <?php 
                        printLastNews();
                    ?>

                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                <?php 
                
                $number_of_these_news = count(get_some_news()); 
                $iterations = ceil($number_of_these_news / 3);
                $is_active_set = false;

                echo "

                    <ol class='carousel-indicators'>

                ";

                for($i = 0 ; $i < $iterations ; $i++)
                {
                    echo "
                        <li data-target='#carouselExampleCaptions' data-slide-to='$i'
                    "; 
                    
                    if(!$i) echo "class='active'";

                    echo "
                        ></li>
                    ";

                }
                
                echo "

                    </ol>

                ";


                ?>
            </div>

        </div>
        <?php require "footer.php"?>
        <?php require "modules/module_asidePanel.php"?>
    </div>
    <!-- <script src="javaScript/arch.js"></script> -->
    <!-- <script src="javascript/snow-fall.js"></script>     -->
    <script>
        // window.onresize = function(){
        //     alert(window.innerWidth);
        // };
    </script>
    <script>
    
</script>
</body>
</html>

<?php 

// echo '<div hidden="true">';
// print_r($tm->toDisplay);
// print_r($tm->errors);
// echo '</pre>';
// echo '</div>';

?>

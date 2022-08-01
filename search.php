<?php

require 'db_connect.php';
require "functions_for_themes.php";

function getThemeID_ByNewsID($thisNewsID)
{
    global $pdo;

    $qs = "SELECT * FROM news_theme , themes , news 
    WHERE news.id = ?
    AND news.id = news_theme.news_id 
    AND news_theme.theme_id = themes.id";
    
    $statement = $pdo->prepare($qs);
    $statement->execute([$thisNewsID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

function get_news($theme = '' , $tag = '' , $keyword_string = '')
{

    $where = false;
    $and = false;
    
    global $pdo;

    // стартовая строка запроса
    // получаем все новости 
    $qs = 'select news.* from news';
    
    if($theme):
        $qs .= ' , themes , news_theme';
    endif;

    if($tag):
        $qs .= ' , hash_tags , news_tag';
    endif;
    
    if($theme != false)
    {
        $qs .= " where themes.id = $theme and news_theme.theme_id = themes.id
        and news_theme.news_id = news.id";
        $where = true;
    }

    if($tag != false)
    {
        if($where == false) $qs .= ' where';
        if($where == true) $qs .= ' and';
        $qs .= " hash_tags.id = $tag     
        and news_tag.tag_id = hash_tags.id
        and news_tag.news_id = news.id";
    }

    if($keyword_string):
        if($where == false) $qs .= ' where';
        if($where == true) $qs .= ' and';
        $qs .= " news.body like '%$keyword_string%'";
    endif;

    // echo $qs;

    $image_select_qs = 'SELECT news.* from news , themes , hash_tags , news_theme , news_tag 
    WHERE themes.id = 144 
    and hash_tags.id = 532 
    and news_theme.theme_id = themes.id
    and news_theme.news_id = news.id
    and news_tag.tag_id = hash_tags.id
    and news_tag.news_id = news.id';

    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result_array = $statement->fetchall(PDO::FETCH_ASSOC);

    return $result_array;
}


// echo '<pre>';
// print_r($_COOKIE);
// echo '</pre>';

if($_GET['theme_id'] == false && $_GET['tag_id'] == false && $_GET['keyword'] == false)
{
    header('location: news.php');
}







?>

<style>
    div.container {
        /* border: 1px solid black; */
    }

    div.section {
        width:66%;
        text-align: justify;
        margin: 0 auto;
    }

    div.section > div > a > h2 {
        font-size: 1.6em;
        font-weight: bold;
    }

    div.section > div > a > p {
        font-size: 1.2em;
    }

</style>

<!doctype html>
<html lang="ru-RU">
    <head>
    <?php require "meta.php"?>
    <link rel="stylesheet" href="css/mainCss_v37.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- ========= -->
    </head>
<body>
    <div class="superMain">
        <?php require "head.php"?>

        <div class="container">
            <div class="section news">
                <?php

                foreach(get_news($_GET['theme_id'] , $_GET['tag_id'] , $_GET['keyword']) as $news_arr)
                {
                    // print_r($news_arr['id']);
                    // print_r(getThemeID_ByNewsID(4));
                    // заранее обрезание строки
                    $the_trimmed_body_string = substr($news_arr['body'] , 0 , 499);

                    echo "
                    <div><a href='news.php?theme_id=" . getThemeID_ByNewsID($news_arr['id'])[0]['theme_id'] . "'>
                    <h2>$news_arr[title]</h2>
                    <p>$the_trimmed_body_string ...</p>
                    </a></div>
                    ";
                }

                ?>
            </div>
            <div class="section img"></div>
            <div class="section pdf"></div>
            <div class="section video"></div>
            <div class="section audio"></div>
        </div>

        <?php require "footer.php"?>
    </div>
    <script src="javaScript/arch.js"></script>
</body>
</html>




<script src="jquery/jquery-3.5.1.min.js"></script>
    

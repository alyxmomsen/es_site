<?php 

require 'db_connect.php';
require "functions_for_themes.php";

/// возвращает ID темы если есть в глобальном массиве
function getThemeID_fromQueryString()
{
    $themeID = null;

    if(isset($_GET['theme_id'])) $themeID = $_GET['theme_id'];

    return $themeID;
}



function queryConstructor()
{
    // nothig yet
    // конструирует (собирает) строку зароса
    // по контексту

}

// определяет дату понедельника прошедшей недели
function getLastMondayDate()
{
    $theDay = (int)date('N');
    if($theDay == 1):
        $that_monday = time() - ((60 * 60 * 24) * 7);
    else:
        $that_monday = time() - ((60 * 60 * 24) * 7) - ((60 * 60 * 24) * ($theDay - 1));
    endif;
    $date_arr = explode(' ' , date('Y m d' , $that_monday));
    $date_str = (implode('-' , $date_arr));

    return $date_str;
}

// возвращает все поля из таблицы news 
// в зависимости от существующих переменных $_GET['theme_id'] и $_GET['tag_id']
function get_all_news_rows()
{
    global $pdo;

    $theme = $_GET['theme_id'];
    $tag = $_GET['tag_id'];

    // $last_monday_date = getLastMondayDate();

    $last_monday_date = '2020-01-01';

    $all_news_qs = "SELECT * from news where cdt >= ? order by cdt desc";

    $all_news_by_theme_id_qs = "SELECT news.* from news , themes , news_theme 
    where themes.id = ? AND themes.id = news_theme.theme_id 
    and news_theme.news_id = news.id order by cdt desc";

    $all_news_by_tag_id_qs = "SELECT news.* from news , hash_tags , news_tag 
    where hash_tags.id = ?  AND hash_tags.id = news_tag.tag_id 
    and news_tag.news_id = news.id order by cdt desc";

    if($theme && !$tag):
        $statement = $pdo->prepare($all_news_by_theme_id_qs);
        $statement->execute([$theme]);
        $news_all_rows_result_arr = $statement->fetchall(PDO::FETCH_ASSOC);
    elseif(!$theme && $tag):
        $statement = $pdo->prepare($all_news_by_tag_id_qs);
        $statement->execute([$tag]);
        $news_all_rows_result_arr = $statement->fetchall(PDO::FETCH_ASSOC);
    elseif(!$theme && !$tag):
        $statement = $pdo->prepare($all_news_qs);
        $statement->execute([$last_monday_date]);
        $news_all_rows_result_arr = $statement->fetchall(); // not PDO::FETCH_ASSOC
    endif;

    return $news_all_rows_result_arr;
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
// возвращает коллекцию img+comment для этой новости
function get_imgs_for_current_news_row($news_id)
{
    global $pdo;
    $statement = $pdo->prepare('select images.id , images.path , news_img.comment from news , images , news_img  
    WHERE news.id = ? AND news_img.news_id = news.id AND news_img.images_id = images.id');
    $statement->execute([$news_id]);
    $result = $statement->fetchall(2); //assoc
    return $result;
}

// возвращает все строки из таблицы images
function get_all_img()
{
    global $pdo;
    $qs = "select * from images";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $current_news_images_request_result = $statement->fetchall(PDO::FETCH_ASSOC); // ошибки в названии
    return $current_news_images_request_result;
}


//
// принимает ID темы
// возвращает коллекцию видео по ID темы

function getVideosByThemeID($themeID)
{
    global $pdo;

    $qs = "SELECT 
	video_files.id as vID , 
    video_files.path as vPath ,
    themeid_videoid.description as description ,
    themeid_videoid.cdt , 
    themes.theme_name
    FROM themeid_videoid , 
    video_files , 
    themes 
    WHERE themes.id = ? 
    and themes.id = themeid_videoid.theme_id
    AND themeid_videoid.video_id = video_files.id
    ORDER BY themeid_videoid.cdt DESC";

    $statement = $pdo->prepare($qs);

    $statement->execute([$themeID]);

    $result = $statement->fetchall(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($result);
    // echo '</pre>';
    return $result;

}


function getDescriptonForThisVideoByThemeID()
{

}

// возввращает название темы по её ID
function getThemeNameByID($themeID)
{
    global $pdo;
    $qs = "SELECT theme_name FROM themes WHERE themes.id = ? LIMIT 1";
    $statement = $pdo->prepare($qs);
    $statement->execute([$themeID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC)[0];
    return $result;
}


function getAllVideo()
{
    global $pdo;
    $qs = "SELECT 
    video_files.path as vPath ,
    video_files.cdt , 
    video_files.id as vID
    FROM video_files 
    ORDER BY cdt DESC";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

// проверить существование медиа для новости по её ID
function isExistMediaForTheNewsID($table_name , $newsID)
{
    global $pdo;
    $qs = "select * from $table_name where news_id = ?";
    $statement = $pdo->prepare($qs);
    $statement->execute([$newsID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}


/////////////////////////////
////// preprocessor /////////
///////////////////////////



?>

<!doctype html>
<html lang="ru-RU">
    <head>
        <?php require "meta.php"?>
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!-- ========= -->
        <link rel="stylesheet" href="css/news.css?v=20210916_1352">
        <!-- sticky sidebar -->
        <script src="less&css/theia-sticky-sidebar.js"></script>
        <script src="less&css/ResizeSensor.js"></script>
        <!-- ========= -->
    </head>
<body>
    <div class='superMain news'>
        <?php require 'head.php'; ?>
        <h1 class='page-title'>новости</h1>
        <div class="wrapper main">
            <?php

            // print_r(get_all_news_rows());
            if(get_all_news_rows()) require "wrapper_news_feed_2.php";  // not news_feed_wrapper.php
            else require "wrapper_media.php";
            
            ?>
            <?php
                // видео будет загружаться в любом случае
                // require "wrapper_media.php" ;
            ?>
            <div class="arrow-to-up base">
                <a href="#" class="arrow-to-up target">
                    <div class="arrow-background">
                        <div class="the-arrow"></div>
                    </div>
                </a>
            </div>
        </div>
        <?php require 'footer.php'; ?>
    </div>
</body>
</html>
<script>

$(document).ready(function(){
    
    // $('.carousel').carousel({
    //     interval: 100 , 
    //     wrap: false
    // });
    
    jQuery('a.arrow-to-up.target').theiaStickySidebar({
        containerSelector: '.wrapper.main'
        // additionalMarginTop: 30 , 
    });

    document.getElementsByClassName('wrapper main')[0].scrollIntoView();

});

</script>
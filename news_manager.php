<?php

define('SITE_ROOT' , "$_SERVER[DOCUMENT_ROOT]/egorsukhachev/");

require "db_connect.php";




//////////////////////////////////////
////////// pre processor /////////////
//////////////////////////////////////

// switch ($) {
//     case 'value':
//         # code...
//     break;
//     default:
//         # code...
//     break;
// }


// возвращает все поля из таблицы news
function get_all_news_rows()
{
    global $pdo;
    $all_news_qs = "select * from news";
    $statement = $pdo->prepare($all_news_qs);
    $statement->execute();
    $news_all_rows_result_arr = $statement->fetchall(PDO::FETCH_ASSOC);
    return $news_all_rows_result_arr;
}

// принимает id текущей новости
// возвращает все фото для текущей новости
function get_all_img_to_current_row($news_id)
{
    global $pdo;
    $qs = "select images.* , news_img.* from images , news , news_img 
    where news.id = ? and news.id = news_img.news_id 
    and news_img.images_id = images.id";
    $statement = $pdo->prepare($qs);
    $statement->execute([$news_id]);
    $current_news_images_request_result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $current_news_images_request_result;
}

function get_all_img()
{
    global $pdo;
    $qs = "select * from images";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $current_news_images_request_result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $current_news_images_request_result;
}


//принимает комментарий для фото
//возвращает цвет в виде строки
function setColorFrameForCurrentImg($commentary)
{
    $colors = array('regular' => 'black' , 'main' => 'red' , 'second' => 'blue');
    switch ($commentary) {
        case 'regular':
            return 'black';
        break;
        case 'main':
            return 'red';
        break;
        case 'second':
            return 'blue';
        break;
        default:
        return 'grey';
        break;
    }
}

//////////// styles ////////////////end jquery ))


echo "
<script src='jquery/jquery-3.5.1.min.js'></script>

<style>
    * {
        box-sizing: border-box;
    }

    div.flex-container.row {
        border: 1px solid #000;
        padding: 9px;
        display: flex;
        justify-content: left;
    }

    div.flex-item {
        border: 1px solid red;
        width: 199px;
        position: relative;
        display: flex;
        flex-wrap: wrap;
    }

    div.flex-item.img > img {
        width: 50%;
        object-fit: cover;
    }

    div.flex-item.img > div.photo-display {
        position: absolute;
        width: 400%;
        border: 6px solid grey;
        background-color:white;
        z-index: 9;
        display: none;
    }

</style>
";

///////// main section //////////////
echo "<h1>Новости</h1>";

foreach(get_all_news_rows() as $row)
{
    echo "
    <div class='flex-container row'>
        <div class='flex-item img'>";
            foreach(get_all_img_to_current_row($row['id']) as $current_img)
            {
                $border_color = setColorFrameForCurrentImg($current_img['comment']);
                echo "
                <img style='border: 4px solid $border_color;' src='$current_img[path]'>
                ";
            }
        echo "
        <div>
        ";

            
        echo "
        </div>
        </div>
        <div class='flex-item title'>
            $row[title]
        </div>
        <div class='flex-item body'>" .
            substr($row['body'] , 0 , 299)
            . "
            ...
        </div>
        <div class='flex-item video'>";
        
        
        echo "
        </div>
        <div class='flex-item'></div>
        <div class='flex-item'></div>
    </div>
    ";
}

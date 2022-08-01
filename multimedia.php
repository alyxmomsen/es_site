<?php

require "db_connect.php";

/*************************************************/
function extGetter($full_name)
{
    $arr = explode('.' , $full_name);
    end($arr);
    return current($arr);
}


// получендие мультимедиа
// принемает расширение и исходный путь 
// возвращает коллекцию путей к файлам
function foo1($dir_path , $ext , &$arr)
{
    $dir_descriptor = opendir($dir_path);

    while(false != ($the_dir_item = readdir($dir_descriptor)))
    {
        $the_path_deeper = implode('/' , [$dir_path , $the_dir_item]);
        if($the_dir_item === '.' || $the_dir_item === '..') continue;
        if(is_dir($the_path_deeper))
        {
            foo1($the_path_deeper , $ext , $arr);
        }
        elseif(extGetter($the_dir_item) === $ext)
        {
            $arr[] = implode('/' , [$dir_path , $the_dir_item]);
        }
        
    }
   
}

/*************************************************/


// добавляет данные о мультимедиа файле в БД
// принимает коллекцию (не менее одного файла) ,  расширение  и ссылку на массив
//
function foo2($src = array() , $ext = null)
{

    if(!$src || !$ext) die('false');  

    global $pdo;
    $qs = "INSERT ignore into video_files (path) VALUES (?);";
    // $qs = "insert ignore into media (src , ext) values (:src , :ext)";
    $statement = $pdo->prepare($qs);

    foreach($src as $val)
    {
        // $statement->execute([]);
        $statement->execute([':src' => $val , ':ext' => $ext]);
    }
    
}


/*************************/

function showMedia()
{
    global $pdo;
    $qs = "select * from media";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);

    foreach($result as $val)
    {
        echo "
        <img style='width:99px;' src='$val[src]'>
        <span> id : $val[id]</span>
        ";
    }
}





$ar = array();

$the_ext = 'mp4';


// //собираем коллекцию в массив
foo1('data' , $the_ext , $ar);


// //передаем коллекцию в бд
foo2($ar , $the_ext);


// //выведение результата
echo '<pre>';
print_r($ar);
echo '</pre>';

// showMedia();



?>


<!-- <iframe frameborder="0" style="border:none;width:100%;height:70px;" width="100%" height="70" src="https://music.yandex.ru/iframe/#track/70619465/11945528">Слушайте 
    <a href='https://music.yandex.ru/album/11945528/track/70619465'>Если тебе будет грустно</a> — 
    <a href='https://music.yandex.ru/artist/4330960'>Rauf & Faik</a> на Яндекс.Музыке
</iframe> -->





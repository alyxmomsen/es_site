<?php 

// этот файл содержит вспомогательные функции для заполнения базы данных нужным контентом

require 'db_connect.php';

//эта функция добавляет путь к файлу в базу данных

function add_this_file_into_data_base($path)
{
    global $pdo;
    $qs = "insert ignore into audio_files (path) values (?)";
    $statement = $pdo->prepare($qs);
    $statement->execute([$path]);
}

function find_audio_and_add_path_into_db($path)
{
    $audio_dir_descriptor = opendir($path);
    while(false !== ( $dir_item = readdir($audio_dir_descriptor)))
    {
        if($dir_item === '.' || $dir_item === '..') continue;
        if(is_dir(implode('/' , [$path , $dir_item])))
        {
            find_audio_and_add_path_into_db(implode('/' , [$path , $dir_item]));
        }
        // echo $dir_item . '<br>';
        $dir_item_exploded_like_array = explode('.' , $dir_item);
        end($dir_item_exploded_like_array);
        if(current($dir_item_exploded_like_array) === 'mp3')
        {
            add_this_file_into_data_base(implode('/' , [$path , $dir_item]));
        }
    }

}

find_audio_and_add_path_into_db('data');
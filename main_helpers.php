<?php

require "db_connect.php";

function extGetter($full_name)
{
    $arr = explode('.' , $full_name);
    end($arr);
    return current($arr);
}


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

function foo2($src = array() , $ext = null)
{
    global $pdo;
    // print_r($src);
    if(!$src) die('false');  

    global $pdo;
    $qs = "INSERT INTO video_files (path) VALUES (?)";

    $statement = $pdo->prepare($qs);

    foreach($src as $val)
    {

        $statement->execute([$val]);
    }
    
}


$arr = array();

foo1('data' , 'mp4' , $arr);

echo '<pre>';
print_r($arr);
echo '</pre>';

foo2($arr);

?>
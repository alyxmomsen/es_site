<?php

require_once "db_connect.php";

function opendir_fu($path , $to , $exeption)
{
    global $pdo;
    $result_path_array = array();

    $desc = opendir($path);
    while(false !== ($row = readdir()))
    {
        if($row === '.' || $row === '..') continue;
        $arr = explode('.' , $row);
        end($arr);
        if(current($arr) === 'jpg' || current($arr) === $exeption)
        $result_path_array[] = implode('/' , [$path , $row]);
    }

    if(!$result_path_array)
    {
        echo "<pre>";
        print_r($result_path_array);
        echo "</pre>";
        echo '<br>' . "null";
        exit();
    }

    $pdo_st_desc = $pdo->prepare("insert ignore into $to (url) values (?)");

    foreach($result_path_array as $r)
    {
        $pdo_st_desc->execute([$r]);
    }
    
    echo "<pre>";
    print_r($result_path_array);
    echo "</pre>";
}


// opendir_fu('data/fotoForBlog/акция протеста 051020','video_files','mp4');



function insertIntoThemeSection($section)
{
    global $pdo;
    $selectedSectionStatment = $pdo->prepare("select sections.section, sections.id from sections");
    $selectedSectionStatment->execute();
    $sections_result_arr = $selectedSectionStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($sections_result_arr);
    //comment
    foreach($sections_result_arr as $row)
    {
        $selectedThemesStatment = $pdo->prepare("select themes.theme_name, themes.id from themes where themes.section = '$row[section]'");
        $selectedThemesStatment->execute();
        $result_arr = $selectedThemesStatment->fetchall(PDO::FETCH_ASSOC);
                
        foreach($result_arr as $theme_row)
        {
            echo "sdfs";
            echo $theme_row['id'] , ' / ' , $row['id'] , "<br>";
            $insert_statment = $pdo->prepare("insert into themesid_sectionid (theme_id,section_id) values ($theme_row[id] , $row[id])");
            $insert_statment->execute();
        }
    }
    
    
}

// insertIntoThemeSection('about');


function photoAndThemeConnection()
{
    global $pdo;
    $trnc_stmnt = $pdo->prepare('truncate table themeid_photoid');
    $trnc_stmnt->execute();
    $selectedImagesStatment = $pdo->prepare("select images.id from images");
    $selectedImagesStatment->execute();
    $images_result_arr = $selectedImagesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($sections_result_arr);
    //comment
    $selectedThemesStatment = $pdo->prepare("select themes.id,themes.theme_name from themes");
    $selectedThemesStatment->execute();
    $themes_result_arr = $selectedThemesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($themes_result_arr);
    // print_r();echo '<br>';
    // echo ($themes_result_arr[array_rand($themes_result_arr)]['id']) . '<br>';

    // $insert_statment = $pdo->prepare("insert ignore into themeid_phototid (photo_id,theme_id) values (?,?)");

    foreach($images_result_arr as $esm)
    {
        $val_1 = $images_result_arr[array_rand($images_result_arr)]['id'];
        $val_2 = $themes_result_arr[array_rand($themes_result_arr)]['id'];
        echo $val_1 . ' ' . $val_2;
        $insert_statment = $pdo->prepare("insert ignore into themeid_photoid (photo_id,theme_id) values ($val_1,$val_2)");
        echo '<br>';
        $insert_statment->execute([$images_result_arr[array_rand($images_result_arr)]['id'] , $themes_result_arr[array_rand($themes_result_arr)]['id']]);
    }
}

// photoAndThemeConnection();


function loadVideo($path)
{
    global $pdo;
    $video_inserting_statment = $pdo->prepare("insert ignore into video_files (path) values (?)");

    $folder_descriptor = opendir($path);
    while(false !== ($row = readdir($folder_descriptor)))
    {
        if($row === '.' || $row === '..') continue;
        if(is_dir(implode('/' , [$path , $row]))) 
        {
            $new_path = implode('/' , [$path , $row]);
            loadVideo($new_path);
        }
        else
        {
            $filename_arr = explode('.' , $row);
            end($filename_arr);
            if(current($filename_arr) === 'mp4' || current($filename_arr) === 'mpeg4')
            {
                echo '<br>' . $row;
                $video_inserting_statment->execute([implode('/' , [$path , $row])]);
            }
        }
    }
}

// loadVideo('data');

function videoAndThemeLinking()
{
    global $pdo;
    $selectedImagesStatment = $pdo->prepare("select video_files.id from video_files");
    $selectedImagesStatment->execute();
    $images_result_arr = $selectedImagesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($sections_result_arr);
    //comment
    $selectedThemesStatment = $pdo->prepare("select themes.id,themes.theme_name from themes");
    $selectedThemesStatment->execute();
    $themes_result_arr = $selectedThemesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($themes_result_arr);
    print_r($images_result_arr);
    // print_r();echo '<br>';
    // echo ($themes_result_arr[array_rand($themes_result_arr)]['id']) . '<br>';

    // $insert_statment = $pdo->prepare("insert ignore into themeid_phototid (photo_id,theme_id) values (?,?)");

    foreach($images_result_arr as $esm)
    {
        $val_1 = $images_result_arr[array_rand($images_result_arr)]['id'];
        $val_2 = $themes_result_arr[array_rand($themes_result_arr)]['id'];
        echo $val_1 . ' ' . $val_2;
        $insert_statment = $pdo->prepare("insert ignore into themeid_videoid (video_id,theme_id) values ($val_1,$val_2)");
        echo '<br>';
        $insert_statment->execute([$images_result_arr[array_rand($images_result_arr)]['id'] , $themes_result_arr[array_rand($themes_result_arr)]['id']]);
    }
}


// videoAndThemeLinking();

function loadAudio($path)
{
    global $pdo;
    $video_inserting_statment = $pdo->prepare("insert ignore into audio_files (path) values (?)");

    $folder_descriptor = opendir($path);
    while(false !== ($row = readdir($folder_descriptor)))
    {
        if($row === '.' || $row === '..') continue;
        if(is_dir(implode('/' , [$path , $row]))) 
        {
            $new_path = implode('/' , [$path , $row]);
            loadAudio($new_path);
        }
        else
        {
            $filename_arr = explode('.' , $row);
            end($filename_arr);
            if(current($filename_arr) === 'mp3' || current($filename_arr) === 'mp3')
            {
                echo '<br>' . $row;
                $video_inserting_statment->execute([implode('/' , [$path , $row])]);
            }
        }
    }
}

// loadAudio('data');


function audioAndThemeLinking()
{
    global $pdo;
    $selectedImagesStatment = $pdo->prepare("select audio_files.id from audio_files");
    $selectedImagesStatment->execute();
    $images_result_arr = $selectedImagesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($sections_result_arr);
    //comment
    $selectedThemesStatment = $pdo->prepare("select themes.id,themes.theme_name from themes");
    $selectedThemesStatment->execute();
    $themes_result_arr = $selectedThemesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($themes_result_arr);
    print_r($images_result_arr);
    // print_r();echo '<br>';
    // echo ($themes_result_arr[array_rand($themes_result_arr)]['id']) . '<br>';

    // $insert_statment = $pdo->prepare("insert ignore into themeid_phototid (photo_id,theme_id) values (?,?)");

    foreach($images_result_arr as $esm)
    {
        $val_1 = $images_result_arr[array_rand($images_result_arr)]['id'];
        $val_2 = $themes_result_arr[array_rand($themes_result_arr)]['id'];
        echo $val_1 . ' ' . $val_2;
        $insert_statment = $pdo->prepare("insert ignore into themeid_audioid (audio_id,theme_id) values ($val_1,$val_2)");
        echo '<br>';
        $insert_statment->execute([$images_result_arr[array_rand($images_result_arr)]['id'] , $themes_result_arr[array_rand($themes_result_arr)]['id']]);
    }
}

// audioAndThemeLinking();

function loadDocuments($path)
{
    global $pdo;
    $video_inserting_statment = $pdo->prepare("insert ignore into documents (path) values (?)");

    $folder_descriptor = opendir($path);
    while(false !== ($row = readdir($folder_descriptor)))
    {
        if($row === '.' || $row === '..') continue;
        if(is_dir(implode('/' , [$path , $row]))) 
        {
            $new_path = implode('/' , [$path , $row]);
            loadDocuments($new_path);
        }
        else
        {
            $filename_arr = explode('.' , $row);
            end($filename_arr);
            if(current($filename_arr) === 'pdf' || current($filename_arr) === 'pdf')
            {
                echo '<br>' . $row;
                $video_inserting_statment->execute([implode('/' , [$path , $row])]);
            }
        }
    }
}


// loadDocuments('data');

// эта и несколько предыдущих функций, скопированы в надежде сыкономить время, и затем минимально отредактированы
function documentsAndThemeLinking()
{
    global $pdo;
    $selectedImagesStatment = $pdo->prepare("select documents.id from documents");
    $selectedImagesStatment->execute();
    $images_result_arr = $selectedImagesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($sections_result_arr);
    //comment
    $selectedThemesStatment = $pdo->prepare("select themes.id,themes.theme_name from themes");
    $selectedThemesStatment->execute();
    $themes_result_arr = $selectedThemesStatment->fetchall(PDO::FETCH_ASSOC);
    // print_r($themes_result_arr);
    print_r($images_result_arr);
    // print_r();echo '<br>';
    // echo ($themes_result_arr[array_rand($themes_result_arr)]['id']) . '<br>';

    // $insert_statment = $pdo->prepare("insert ignore into themeid_phototid (photo_id,theme_id) values (?,?)");

    foreach($images_result_arr as $esm)
    {
        $val_1 = $images_result_arr[array_rand($images_result_arr)]['id'];
        $val_2 = $themes_result_arr[array_rand($themes_result_arr)]['id'];
        echo $val_1 . ' ' . $val_2;
        $insert_statment = $pdo->prepare("insert ignore into themeid_documentid (document_id,theme_id) values ($val_1,$val_2)");
        echo '<br>';
        $insert_statment->execute([$images_result_arr[array_rand($images_result_arr)]['id'] , $themes_result_arr[array_rand($themes_result_arr)]['id']]);
    }
}

// documentsAndThemeLinking();

// time_test_foo();


////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// about photo and themes and linking those
function loadPhotoIntoTheTable($path = 'data')
{
    global $pdo;
    $dir_descriptor = opendir($path);
    while(false !== ($dir_item = readdir($dir_descriptor)))
    {
        if($dir_item === '.' || $dir_item === '..') continue;
        $new_path  = implode('/' , array($path , $dir_item));
        $exploded_dir_item_tail = explode('.' , $dir_item);
        end($exploded_dir_item_tail);
        $ext = current($exploded_dir_item_tail);
        if(is_dir($new_path))
        {
            loadPhotoIntoTheTable($new_path);
        }
        else
        {
            if($ext === 'jpeg' || $ext === 'jpg' || $ext === 'png')
            {
                $query_string = 'insert ignore into images (path) values (?)';
                $insert_stmnt = $pdo->prepare($query_string);
                echo $insert_stmnt->execute(array($new_path));
            }
        }
    }
}

// loadPhotoIntoTheTable();

function get_themes_for_images($imageid) 
{
    global $pdo;
    $qr_str = "select themes.id , themes.theme_name from themes , images , themeid_photoid where  
    themeid_photoid.photo_id = ? and themeid_photoid.theme_id = themes.id and themeid_photoid.photo_id = images.id";
    $stmnt = $pdo->prepare($qr_str);
    $stmnt->execute([$imageid]);
    return $stmnt->fetchall(PDO::FETCH_ASSOC);
}

function get_hash_tags_for_the_image($imageid)
{
    global $pdo;
    $qr_str = "SELECT hash_tags.id, hash_tags.name FROM images, imgid_tagid, hash_tags WHERE images.id = ? AND imgid_tagid.img_id = images.id AND imgid_tagid.tag_id = hash_tags.id";
    $stmnt = $pdo->prepare($qr_str);
    $stmnt->execute([$imageid]);
    return $stmnt->fetchall(PDO::FETCH_ASSOC);
}

function create_theme_if_that_not_exist_and_then_link_to_the_picture($theme_name , $photo_id)
{
    if(trim($theme_name) === ''): 
        header("location:$_SERVER[PHP_SELF]");
        die('fuckyoudickhead');
    endif;
    global $pdo;
    $seting_new_theme_q_s = "insert into themes (themes.theme_name) values (?)";
    $trying_to_set_new_theme = $pdo->prepare($seting_new_theme_q_s);
    $trying_to_set_new_theme->execute([trim($theme_name)]);
    $link_theme_to_photo_query_string = 
    "insert ignore into themeid_photoid (themeid_photoid.theme_id, themeid_photoid.photo_id)
    values (? , ?)";
    $select_theme_id_for_new_theme_stmnt = "select themes.id from themes where themes.theme_name = ?";
    $new_theme_id_select_statment = $pdo->prepare($select_theme_id_for_new_theme_stmnt);
    $new_theme_id_select_statment->execute([trim($theme_name)]);
    $new_theme_id = $new_theme_id_select_statment->fetch(PDO::FETCH_COLUMN);
    $link_theme_to_photo_stmnt = $pdo->prepare($link_theme_to_photo_query_string);
    $link_theme_to_photo_stmnt->execute([$new_theme_id , $photo_id]);
}

function get_all_hash_tag_list()
{
    global $pdo;
    $query_string = 'select * from hash_tags';
    $statement = $pdo->prepare($query_string);
    $statement->execute();
    return $statement->fetchall(PDO::FETCH_ASSOC);
}

function img__tag_link()
{
    global $pdo;
    $insert_by_id_statement = $pdo->prepare("insert into imgid_tagid (img_id , tag_id) value (? , ?)");
    $insert_new_tag_statement = $pdo->prepare("insert into hash_tags (name) values (?)");
    $get_id_by_name_statement = $pdo->prepare("select hash_tags.id from hash_tags where hash_tags.name = ?");
    foreach($_GET['tag'] as $the_tag)
    {
        $get_id_by_name_statement->execute([$the_tag]);
        $tag_request_result = $get_id_by_name_statement->fetchall(PDO::FETCH_COLUMN);
        if($tag_request_result):
            $insert_by_id_statement->execute([$_GET['photo_id'] , $tag_request_result[0]]);
        else:
            if(trim($the_tag)):
            $insert_new_tag_statement->execute([$the_tag]);
            $get_id_by_name_statement->execute([$the_tag]);
            $tag_request_result = $get_id_by_name_statement->fetchall(PDO::FETCH_COLUMN);
            $insert_by_id_statement->execute([$_GET['photo_id'] , $tag_request_result[0]]);
            endif;
        endif;
    }
}

function just_unlink_photo_and_theme()
{
    global $pdo;
    $unlink_photo_by_theme_query_string = "
    DELETE from themeid_photoid where themeid_photoid.theme_id = :themeid and themeid_photoid.photo_id = :photoid";
    $unlink_photo_by_theme = $pdo->prepare($unlink_photo_by_theme_query_string);
    $unlink_photo_by_theme->execute([':themeid' => $_GET['theme'] , ':photoid' => $_GET['photo_id']]);
}

function just_unlink_photo_and_the_tag()
{
    global $pdo;
    $unlink_photo_by_theme_query_string = "
    DELETE from imgid_tagid where imgid_tagid.img_id = ? and imgid_tagid.tag_id = ?";
    $unlink_photo_by_theme = $pdo->prepare($unlink_photo_by_theme_query_string);
    $unlink_photo_by_theme->execute([$_GET['photo_id'] , $_GET['tag']]);
}

function display_content()
{
    global $pdo;

    if ((isset($_GET['mod']))):
        switch ($_GET['mod']) {
            case 'del_theme':
                just_unlink_photo_and_theme();
                header('location:' . $_SERVER['PHP_SELF']);
            break;
            case 'set_theme':
                create_theme_if_that_not_exist_and_then_link_to_the_picture(trim($_GET['theme']) , $_GET['photo_id']);
                header('location:' . $_SERVER['PHP_SELF']);
            break;
            case 'set_tag':
                img__tag_link();
                header('location:' . $_SERVER['PHP_SELF']);
            break;
            case 'del_tag':
                just_unlink_photo_and_the_tag();
                header('location:' . $_SERVER['PHP_SELF']);
            break;
            default:
                header('location:' . $_SERVER['PHP_SELF']);
            break;
        }
    endif;


    ///
    $photo_select_stmnt = $pdo->prepare('select images.id , images.path , images.create_date , images.create_time from images');
    $photo_select_stmnt->execute();
    $images_rows = $photo_select_stmnt->fetchall();
    ///


    echo <<<htmltext
        <style>
            div.base-flex-container {
                border: 1px solid red;
                display:flex;
                justify-content: center;
            }

            div.base-flex-item {
                border: 1px solid green;
                flex-basis: 20%;
            }

            div.base-flex-item > img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
        </style>
htmltext;

    foreach($images_rows as $image_row)
    {
        // echo $row['id'];
        
        echo "<div class='base-flex-container'>";
        ////
        echo "<div class='base-flex-item'>";
        echo "<img src='$image_row[path]'>";
        echo "</div>";
        ////
        echo "<div class='base-flex-item themes'>";
        foreach(get_themes_for_images($image_row['id']) as $data_about_the_theme)
        {
            echo "<li><a href=$_SERVER[PHP_SELF]?mod=del_theme&theme=$data_about_the_theme[id]&photo_id=$image_row[id]>$data_about_the_theme[theme_name]</a></li> ";
        }
        echo "<form method='get' action='$_SERVER[PHP_SELF]'>";
        echo "<input type=text name='theme'>";
        echo "<input type='submit'>";
        echo "<input type='hidden' name='mod' value='set_theme'>";
        echo "<input type='hidden' name='photo_id' value='$image_row[id]'>";
        echo "</form>";
        echo "</div>";
        ////
        echo "<div class='base-flex-item hash_tags'>";
        foreach(get_hash_tags_for_the_image($image_row['id']) as $hash_tags)
        {
            echo "<li><a href=$_SERVER[PHP_SELF]?mod=del_tag&tag=$hash_tags[id]&photo_id=$image_row[id]>$hash_tags[name]</a></li> ";
        }
        echo "<form method='get' action='$_SERVER[PHP_SELF]'>";
        echo "<select multiple name='tag[]'>";
        foreach(get_all_hash_tag_list() as $the_hash_tag_row)
        {
            echo "<option>$the_hash_tag_row[name]</option>";
        }
        // print_r(get_all_hash_tag_list());
        echo "</select>";
        echo "<input type='text' name='tag[]'>";
        echo "<input name='mod' value='set_tag' type='hidden'>";
        echo "<input name='photo_id' value='$image_row[id]' type='hidden'>";
        echo "</form>";
        echo "</div>";
        ////
        echo "</div>";
    }
}

display_content();

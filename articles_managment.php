<?php 
require_once 'db_connect.php';
// echo "<pre>";
// print_r($_GET);
// print_r($_POST);
// print_r(normaliseArray($_POST));
// echo "</pre>";

//////////////////// handlers ///////////////////

function setText($text , $article_id , $qs)
{
    global $pdo;
    $statement = $pdo->prepare($qs);
    $statement->execute([$text , $article_id]);
    // echo $text , ' ' , $article_id , ' ' , $qs;
}

function linkImageToArticle($data_arr , $articleID)
{
    global $pdo;
    $qs = "insert ignore INTO articleid_photoid (article_id , photo_id, comment) VALUES (? , ? , ?)";
    $stmt = $pdo->prepare($qs);

    foreach($data_arr as $data_item)    
    {
        $stmt->execute([$articleID , $data_item['imgId'] , $data_item['gradient']]);
    }
}

function unlinkImgByTheArticle($artID , $photoID)
{
    global $pdo;
    $qs = "DELETE FROM articleid_photoid where article_id = ? and photo_id = ?";
    $statement = $pdo->prepare($qs);
    $statement->execute([$artID , $photoID]);
}

////// for post from photo 
function normaliseArray($ar)
{
    $arr = array();
    foreach($ar['imgId'] as $img)
    {
        $arr[] = array('imgId' => $img , 'gradient' => $ar['gradient'][$img][0]);
    }
    return $arr;
}
////////////        /////////////////////   /////////
/////////        ///////////////////   /////////////
///  preprocessor  /////////////   ////////////////

$the_mode = $_REQUEST['mode'];
// echo '<pre>';
// print_r(normaliseArray($_POST));
// print_r($_REQUEST);
// echo '</pre>';
// echo $_GET['mode'];

if ($the_mode !== ''):
    switch ($the_mode) {
        case 'setMainText':
            $qs = "UPDATE articles set text = ? , create_date = now() , create_time = now() WHERE id = ?";
            setText($_POST['mainText'] , $_POST['articleId'] , $qs);
            header("location:$_SERVER[PHP_SELF]");
            // print_r($_POST);
        break;
        case 'setTitleText':
            $qs = "UPDATE articles set title = ? , create_date = now() , create_time = now() WHERE id = ?";
            setText($_POST['titleText'] , $_POST['articleId'] , $qs);
            header("location:$_SERVER[PHP_SELF]");
        break;
        case 'setImg':
            linkImageToArticle(normaliseArray($_POST), $_POST['articleId']);
            header("location:$_SERVER[PHP_SELF]");
        break;
        case 'unlink_img':
            echo 'iaminside';
            unlinkImgByTheArticle($_GET['articleID'] , $_GET['photoID']);
            // header("location:$_SERVER[PHP_SELF]");
            header("location:index.php");
            echo "lskdfjlsdkjflskdflskdjflskjdf";
        break;
    }
endif;



$select_articles_qs = "select * from articles";
$select_all_images_qs = "select * from images";
$select_articles_stmt = $pdo->prepare($select_articles_qs);
$select_all_imgs_stmt = $pdo->prepare($select_all_images_qs);
$select_articles_stmt->execute();
$select_all_imgs_stmt->execute();
$all_images_response = $select_all_imgs_stmt->fetchall(PDO::FETCH_ASSOC);
$articles_res = $select_articles_stmt->fetchall(PDO::FETCH_ASSOC);

$select_images_to_articles_qs = "select images.id, images.path, articleid_photoid.comment from images , articles , articleid_photoid where articles.id = ? and 
articles.id = articleid_photoid.article_id and articleid_photoid.photo_id = images.id";
$select_images_to_articles_stmt = $pdo->prepare($select_images_to_articles_qs);

echo <<<headhtmltag
<style>

* {
    box-sizing:border-box;
}

div.base-container {
    border: 1px solid red;
}

div.flex-container.article.row {
    border: 6px solid blue;
    display: flex;
    flex-direction: column;
    justify-content: left;
    align-items: flex-start;
    gap: 9px;
}

div.flex-container.article.row > div.item-container {
    border: 1px solid red;
}

div.flex-container.article.row > div.item-container.value > div {
    border: 1px solid red;
}

div.flex-container-item.content {
    border: 4px solid purple;
}

div.row-item {
    border: 1px solid red;
}

img.main {
    width:160px;
}

img.second {
    width:140;
}

img.regular {
    width:99px;
}

</style>
headhtmltag;

echo "<div class='base-container'>";
echo "<a href='{$_SERVER['PHP_SELF']}?mode=set_article'>add new article</a>";
foreach($articles_res as $row_from_articles_table)
{
    echo "<div class='flex-container article row'>

    <div class='row-item'>
    <div class='flex-container-item content'>$row_from_articles_table[title]</div>
    <div class='interface'>
    <form method='post' action='$_SERVER[PHP_SELF]'>
    <textarea placeholder='enter some laters' name='titleText' rows='16' cols='66' minlength='' maxlength=''></textarea>
    <input type='hidden' name='mode' value='setTitleText'>
    <input type='hidden' name='articleId' value=$row_from_articles_table[id]>
    <input type='submit'>
    </form>
    </div>
    </div>
    
    <div class='row-item'>
    <div class='flex-container-item content'>$row_from_articles_table[text]</div>
    <div class='interface'>
    <form method='post' action='$_SERVER[PHP_SELF]'>
    <textarea placeholder='enter some laters' name='mainText' rows='16' cols='66' minlength='' maxlength=''></textarea>
    <input type='hidden' name='mode' value='setMainText'>
    <input type='hidden' name='articleId' value=$row_from_articles_table[id]>
    <input type='submit'>
    </form>
    </div>
    </div>

    <div class='row-item'>
    <div class='flex-container-item content'>";
    $select_images_to_articles_stmt->execute([$row_from_articles_table['id']]);
    $img_to_the_article_result = $select_images_to_articles_stmt->fetchall(PDO::FETCH_ASSOC);
    // print_r($img_to_the_article_result);
    foreach($img_to_the_article_result as $thePhoto)
    {
        echo "<a href='$_SERVER[PHP_SELF]?mode=unlink_img&articleID=$row_from_articles_table[id]&photoID=$thePhoto[id]'>
        <img src='$thePhoto[path]' class='$thePhoto[comment]'></a>";
    }
    echo "</div>
    <div class='interface forImg'>
    <form method='post' action='$_SERVER[PHP_SELF]'>";
    foreach($all_images_response as $the_image_row)
    {
        echo "<label for='$the_image_row[id]'><img style='width:10%;' src='$the_image_row[path]'></label>
        <input type='checkbox' id='$the_image_row[id]' name='imgId[]' value='$the_image_row[id]'>
        <select name='gradient[$the_image_row[id]][]' value='$the_image_row[id]'>
        <option>regular</option>
        <option>main</option>
        <option>second</option>
        </select>";
    }
    echo "
    <input type='hidden' name='mode' value='setImg'>
    <input type='hidden' name='articleId' value='$row_from_articles_table[id]'>
    <input type='submit'>
    </form>
    </div>
    </div>
    </div>

    </div>";
    echo "</div>";
}
echo "</div>";
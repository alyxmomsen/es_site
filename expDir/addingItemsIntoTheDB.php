<?php

require '../db_connect.php';



class dbManagement {

  public $lastInsertedTaggId = 999;

  public $lastInsertedTagID;

  // private $tmp = "" ;

  // private $name = "" ;

  // private $path = "" ;

  // private $imgName = "" ;

  // private $statement = "" ;

  // private $pdo = "";

  // private $lastInsertedNewsId = "";
  // private $lastInsertedImgId = "";

  // --------------------------

  function __construct(){

    if(isset($GLOBALS['pdo'])){

      $this->pdo = $GLOBALS['pdo'] ;
      
      echo 'this pdo object exist<br>' ; 
    }

  }

  function addImg(){

    echo "img adding result: <br>";

    if(!empty($_FILES['userfile']['tmp_name'])){
      // echo "itsNotNull";
      //Получаем временный файл
      $tmp = $_FILES['userfile']['tmp_name'];
    
      //Получаем имя присланного файла
      $name = $_FILES['userfile']['name'];

      // news-20210813-24-main.jpg

      $theDate = date("Y-m-d");

      $theDateArr = explode('-' , $theDate);

      $name = "news-" . $theDateArr[0] . $theDateArr[1] . $theDateArr[2] . "-" . time() . "-main.jpg";

      echo "new img that is added : $name<br>";

      $this->path = "../data/img/" . $name;
      
      //Пишем куда в дальнейшем, надо будет впихнуть файл, 
      //в данном случае в папку images, имя файла оставляем родное
      
      //перемещаем файл на сервер
      move_uploaded_file($tmp, $this->path);
      
      //Собственно выводим изображение
      // echo "<img style='width:199px;' src='{$this->path}' alt='{$this->name}' />";

      $this->imgName = $name;

    }

  }

  private function loadVideo () {

  }

  private function addImgIntoDB(){

    // SELECT * FROM `images` WHERE `path` LIKE 'qwerty'

    // $search_statement = "SELECT * FROM `images` WHERE `path` LIKE 'qwerty'";

    $statement = $this->pdo->prepare("INSERT INTO `images` (`id` , `path` , `commentary` , `kindOfMultimedia`) VALUES (NULL , 'data/img/{$this->imgName}' , NULL , 'photo')"); // одиночные кавычки обязательны
    
    // echo "img is " . 
    $this->isImgAdded = $statement->execute();
    
    if(!$this->isImgAdded){
      echo "img не добавлен<br>" . $this->isImgAdded;
      return 0;
    }
    else {
      $this->lastInsertedImgId = $this->pdo->lastInsertId();
      echo "<span class='data'> last inserted img id:<b> {$this->lastInsertedImgId}</b></span><br>";
    }
  }
      
  private function addNewsIntoDB(){

    $words = array(
      'Вы прекрасны!!!' , 
      'Молодец !!! :-*' , 
      'Отлично!!!' ,  
      'Всё чотко!' , 
      'Могёшь'
    );

    $par =  trim($_POST['paragraph']);

    $source_from = trim($_POST['source']);

    if($source_from == ''):
      $source_from = NULL;
    endif;
    
    $statementParagraph = $this->pdo->prepare("INSERT INTO `news` (`id`, `first_word`, `title`, `body`, `source_from`, `type`, `cdt`, `hidden`) VALUES (NULL, NULL, NULL, '{$par}' , '{$source_from}', 'news', CURRENT_TIMESTAMP, '1')");

    $this->newsAddingTryResult = $statementParagraph->execute();
    
    if(!$this->newsAddingTryResult):
      echo "<span class='alarm' style=''>блэт, новость не добавлена, АЛЯРМ !!!!</span><br>";
    else:
      echo "<span class='goodResult' style=''>Всё прекрасно, Вы прекрасны, новость успешно добавлена</span><br>";

      // echo "<p>"; 

      echo $words[time() % (count($words))] . "<br>";
      
      // echo "</p><br>";
    endif;
    
    $this->lastInsertedNewsId = $this->pdo->lastInsertId();

    echo "<span class='data' style=''>Идентификатор добавленной новости: $this->lastInsertedNewsId</span><br>";
    
    //INSERT INTO `news_img` (`news_id`, `images_id`, `comment`, `caption`, `description`, `style`) VALUES ('00000000000000000', '272', '', NULL, NULL, NULL)
  }

  private function doTheme(){
    echo "ревизия существующих Тем.<br>";
    // echo "<span style=''></span><br>";
    // echo "<span style=''></span><br>";
    // echo "<span style=''></span><br>";
    // echo "<span style=''></span><br>";

    $theme_name = trim($_POST['theme_name']);
    
    // $theme_name = trim($theme_name);
    
    // SELECT themes.* FROM `themes` WHERE theme_name LIKE '%аб%'


    
    $search_themes_by_theme_name_statement = $this->pdo->prepare("SELECT themes.* FROM `themes` WHERE theme_name LIKE '{$theme_name}' ORDER BY `id` DESC");
    
    $search_themes_by_theme_name_statement->execute();
    
    $result = $search_themes_by_theme_name_statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<span style=''>результат: </span><br>";
    if(count($result)):
      // echo "<span style='background-color:green; color:whitesmoke;'>the theme name <b>{$result[0][theme_name]}</b> exist</span><br>";
      // echo "<span style=''></span><br>";
    // echo "<span style=''></span><br>";
      
      echo "<span class='data' style='data'>тема с именем <b>{$result[0][theme_name]}</b> уже существует.</span><br>";
      

      // echo "this theme propertys: <br>";
      // echo "this theme \"reserve\" : {$result[0]['reserve']}<br>";
      // echo "this theme \"disabled\"  : {$result[0]['disabled']}<br>";

      /* update exist theme */
      $updateStatement = $this->pdo->prepare("UPDATE themes SET themes.reserve = '', themes.disabled = 'true' WHERE themes.id = {$result[0]['id']}");
      $updateResult = $updateStatement->execute();
      /* END update exist theme */

      if($updateResult) echo "<span class='goodResult' style=''>тема успешно активирована.</span><br>";
      else echo "<span style=''>тема не активирована.</span><br>";

      

      $this->lastInsertedThemeID = $result[0]['id'];

      echo "<span class='data' style=''>идентификатор темы: <b>{$this->lastInsertedThemeID}</b></span><br>";
    else:
      $this->themeAdd_statement = $this->pdo->prepare("INSERT INTO `themes` (`id`, `theme_name`, `disabled`, `priority`, `reserve`, `blink`, `styles`) VALUES (NULL, '{$theme_name}', 'true', '1', '', NULL, NULL)");
      $executedRes = $this->themeAdd_statement->execute();
      $this->lastInsertedThemeID = $this->pdo->lastInsertId();
      echo "<span class='data' style=''>создана новая тема</span><br>";
      echo "<span class='data' style=''>имя Темы: <b>{$theme_name}</b></span><br>";
    endif;
  }


  function doTag () {

    $tag = trim($_POST['tag']);
    
    if(isset($_POST['tag']) && $tag !== '') {
      
      
      $statement = $this->pdo->prepare("SELECT hash_tags.* FROM hash_tags WHERE hash_tags.name LIKE '$tag'");
      $executeResult = $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      if(count($result)) {
        echo "<span class='data' style=''>заданый тег уже существует</span><br>";
        $this->lastInsertedTaggId = $result[0]['id'];
        // echo "<h1>$this->lastInsertedTagId</h1>";
        // echo "<h1>$this->lastInsertedTagId</h1>";
      }
      else {
        $insertStatement = $this->pdo->prepare("INSERT INTO hash_tags (name) VALUES (?)");
        $executeResult2 = $insertStatement->execute([$tag]);
        // var_dump($executeResult2);
        
        if($executeResult2) {
          $this->lastInsertedTaggId = $this->pdo->lastInsertId();
          echo "<span class='goodResult'>{$this->lastInsertedTaggId}</span>";
        }
        else {
          echo "<span class='alarm' style=''>тег не добавлен</span><br>";
        }
      }

    }
    else {
      $this->lastInsertedTaggId = NULL;
      echo "<span class='data' style=''>#тег не задан</span><br>";
    }
    // return 0;
  }

  private function addVideoScriptTextIntoDB(){
    // echo "<span style=''></span><br>";
    $videoScriptText = trim($_POST['video']);
  
    if($videoScriptText == ''):
        $this->lastInsertedVideoID = 0;
        echo "<span class='data' style=''>запрос на добавление нового видео отсутствует</span><br>";
        return 0;
    else:
      // $theme_name = trim($theme_name);
  
      // SELECT themes.* FROM `themes` WHERE theme_name LIKE '%аб%'
  
      $search_video_by_video_name_statement = $this->pdo->prepare("SELECT video_files.* FROM `video_files` WHERE `path` LIKE '{$videoScriptText}' ORDER BY `id` DESC");
  
      $search_video_by_video_name_statement->execute();
  
      $result = $search_video_by_video_name_statement->fetchAll(PDO::FETCH_ASSOC);
  
      if(count($result)):
        // echo "not";
        echo "<span class='' style=''>найдено похожее видео в базе данных</span><br>";
        $this->lastInsertedVideoID = $result[0]['id'] ;
        // echo "the same theme is alredy exist<br>";
        // var_dump($theme_name) ;
        // echo "<br>" . count($result);
        echo "<span class='data' style=''>идентификатор существующего видео в базе данных: {$this->lastInsertedVideoID}</span><br>";
      else:
        $vidoSource = $_POST['video_source'] ;
        // echo count($result);  
        $videoAdd_statement = $this->pdo->prepare("INSERT INTO `video_files` (`id`, `path`, `title`, `cover`, `description`, `cdt`, `src`) VALUES (NULL, '{$videoScriptText}', NULL, NULL, NULL, CURRENT_TIMESTAMP, '{$vidoSource}')");
        $executedRes = $videoAdd_statement->execute() ;
        $this->lastInsertedVideoID = $this->pdo->lastInsertId() ;
        // $this->lastInsertedVideoID
        if($executedRes):
          echo "<span class='goodResult' style=''>видео добавлено в БД</span><br>";
          echo "<span class='data' style=''>идентификатор: {$this->lastInsertedVideoID}</span><br>";
        else:
          echo "<span class='alarm' style=''>видео небыло добавленно. sorry</span><br>";
        endif;
        
        // var_dump($executedRes);
        // echo "done";
      endif;
  
    endif;
  
      
  }

  private function linkNewsID_imgID(){
    $newsImg_statement = $this->pdo->prepare("INSERT INTO `news_img` (`news_id`, `images_id`, `comment`, `caption`, `description`, `style`) VALUES ('{$this->lastInsertedNewsId}', '{$this->lastInsertedImgId}', 'main', NULL, NULL, NULL)");
    
    if($newsImg_statement->execute()) {
      echo "<span class='goodResult'>графический файл привязан</span><br>";
    }
  }

  private function link_news_themes(){
    $linkNewsTheme_statement = $this->pdo->prepare("INSERT INTO `news_theme` (`news_id`, `theme_id`) VALUES ('{$this->lastInsertedNewsId}', '{$this->lastInsertedThemeID}')");
    if($linkNewsTheme_statement->execute()) {
      echo "<span class='goodResult'>тема привязана</span><br>";
    }
  }

  private function linkNewsID_VideoID(){
    $linkNewsTheme_statement = $this->pdo->prepare("INSERT INTO `newsid_videoid` (`news_id`, `video_id`, `cdt`, `caption`, `description`, `priority`) VALUES ('{$this->lastInsertedNewsId}', '{$this->lastInsertedVideoID}', CURRENT_TIMESTAMP, NULL, NULL, 'regular')");
    if($linkNewsTheme_statement->execute()) {
      echo "<span class='goodResult'>видео привязано</span><br>";
    }
  }


  private function linkNewsID_tagID(){
    
    $linkNewsTheme_statement = $this->pdo->prepare("INSERT INTO `news_tag` (`news_id`, `tag_id`) VALUES ('{$this->lastInsertedNewsId}', '{$this->lastInsertedTaggId}')");
    
    if($linkNewsTheme_statement->execute()) {
      echo "<span class='goodResult'>тег привязан</span><br>";
    }
    
  }
   


  function doIt(){

    $this->addImg();

    $this->addImgIntoDB();

    $this->doTheme();

    $this->doTag();

    // echo "<h1>{$this->lastInsertedTaggId}</h1>";

    $this->addVideoScriptTextIntoDB();

    $this->addNewsIntoDB();

    $this->linkNewsID_imgID();

    $this->link_news_themes();

    if($this->lastInsertedTaggId !== NULL) {
      $this->linkNewsID_tagID();
    }

    // $this->link_news_tag();

    if($this->lastInsertedVideoID):
        $this->linkNewsID_VideoID();
    endif;

    // header("Location: ".$_SERVER['REQUEST_URI']);

    // return $this->id;
  }
}

$newManage = new dbManagement();
$newManage->doIt();

$dataThatGot = ob_get_contents();
ob_end_clean();
// var_dum p($dataThatGot);

// echo $dataThatGot;

// echo $lastID . "<br>";

// header("Location: http://egorsukhachev.com/expDir/tempLoc.php");

?>

<a href="http://egorsukhachev.com/expDir/expModule.php">НАЗАД</a>



<style>
  .alarm {
    background-color: red;
    padding: 6px;
    display: inline-block;
    color: whitesmoke;
  }

  .goodResult {
    background-color: green;
    padding: 6px;
    display: inline-block;
    color: whitesmoke;
  }

  .data {
    background-color: yellow;
    padding: 6px;
    display: inline-block;
    color: black;
  }
</style>

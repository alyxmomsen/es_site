<?php 

require '../db_connect.php';

class adding_other_img_into_db {

    private $imgName;

    function __construct(){

        if(isset($GLOBALS['pdo'])){
          $this->pdo = $GLOBALS['pdo'] ;
          echo 'constructor: ok<br>' ;
        }
    }

    private function addImg() {
        echo "adding img into the dir: start<br>";

        if(!empty($_FILES['userfile']['tmp_name'])){
            // echo "itsNotNull";
            //Получаем временный файл
            $tmp = $_FILES['userfile']['tmp_name'];
            
            //Получаем имя присланного файла
            $name = $_FILES['userfile']['name'];

            // news-20210813-24-main.jpg

            $theDate = date("Y-m-d");

            $theDateArr = explode('-' , $theDate);

            $name = "news-" . $theDateArr[0] . $theDateArr[1] . $theDateArr[2] . "-" . time() . "-regular.jpg";
            
            echo "file name is: $name<br>";

            $this->path = "../data/img/" . $name;
            
            //Пишем куда в дальнейшем, надо будет впихнуть файл, 
            //в данном случае в папку images, имя файла оставляем родное
            
            //перемещаем файл на сервер
            move_uploaded_file($tmp, $this->path);
            
            //Собственно выводим изображение
            // echo "<img style='width:199px;' src='{$this->path}' alt='{$this->name}' />";

            $this->imgName = $name;
            echo "adding img into the dir: has ended<br>";
        }
    }

    private function addImgIntoDB(){
        echo "adding img into data base: starting";
        // SELECT * FROM `images` WHERE `path` LIKE 'qwerty'
        
        // $search_statement = "SELECT * FROM `images` WHERE `path` LIKE 'qwerty'";
        
        $statement = $this->pdo->prepare("INSERT INTO `images` (`id` , `path` , `commentary` , `kindOfMultimedia`) VALUES (NULL , 'data/img/{$this->imgName}' , NULL , 'photo')"); // одиночные кавычки обязательны
        
        $this->isImgAdded = $statement->execute();

        echo "statement executed: $this->isImgAdded<br>";
        
        if(!$this->isImgAdded){
            echo "error: img has not added<br>";
            return 0;
        }
        else {
          $this->lastInsertedImgId = $this->pdo->lastInsertId();
          // $this->getImgID_statement = $pdo->prepare("");
          echo "last inserted id: $this->lastInsertedImgId<br>";
        }
        echo "adding img into data base: ended<br>";
    }

    private function link_news_img() {  
        echo "link img to news is geting start<br>";
        // echo 'hello world'; 
        $newsID = $_POST['news-id'];
        echo "news id: $newsID<br>";
        $newsImg_statement = $this->pdo->prepare("INSERT INTO `news_img` (`news_id`, `images_id`, `comment`, `caption`, `description`, `style`) VALUES ('{$newsID}', '{$this->lastInsertedImgId}', 'regular', NULL, NULL, NULL)");
        $result = $newsImg_statement->execute();
        echo "result: $result<br>";
    }

    function doIt() {
        $this->addImg();
        $this->addImgIntoDB();
        $this->link_news_img();
        echo "function 'doIt': done<br>";
    }

}


$addingImg = new adding_other_img_into_db();
$addingImg->doIt();
echo "the programm has finished<br>";

?>
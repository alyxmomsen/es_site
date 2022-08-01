<?php 

// ob_start();


// echo 'hello world';

require_once '../db_connect.php';

class addingTagByNewsID {

    private $pdo;

    private $tagName = NULL;
    private $newsID = NULL;
    private $tagID = NULL;
    private $IsNewsIDAlreadyLinked = true;

    function __construct ($pdo) {
        echo '<br><span class="data first">__construct started</span>';
        
        if(!$pdo) {
            die('fuck');
        }

        $this->pdo = $pdo;    

        if(isset($_POST['tag_name'])):
            echo '<br>';
            var_dump($_POST['tag_name']);
            $this->tagName = trim($_POST['tag_name']);
        else:
            echo '<br>' . 'no tag name';
        endif;

        if(isset($_POST['news_ID'])):
            echo '<br>';
            var_dump($_POST['news_ID']);
            $this->newsID = trim($_POST['news_ID']);
        else:
            echo '<br>' . 'no news ID';
            $this->newsID = NULL ;
        endif;
        echo '<br><span class="data first">__construct ended</span>';
    }


    function fetchTagName() {
        echo '<br><span class="data first">fetchTagName started</span>';
        // ob_start();
        if(!$this->tagName) {
            die('<br>no tag!!!');
        }

        $statement = $this->pdo->prepare("SELECT hash_tags.* FROM hash_tags WHERE hash_tags.name LIKE '$this->tagName'");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo '<br>';
        // var_dump($result);
        // echo '<br>end';

        if(count($result)):
            if(count($result) > 1):
                echo '<br><span class="data second">over one</span>';
            else:
                echo '<br><span class="data second">gotcha one</span>';
                $this->tagID = $result[0]['id'];
                echo "<br><span class='data second'>tagID = {$result[0]['id']}</span>";
            endif;
        else:
            echo 'no one, sorry';
            $this->tagID = NULL ;
        endif;


        echo '<br><span class="data first">fetchTagName ended</span>';
    }


    function fetchNewsID () {

        echo '<br><span class="data first">fetchNewsID started</span>';

        if(!$this->newsID): 
            echo '<br><span class="data second">this news id is not exist</span>';
            return 0;
        endif;

        $statement = $this->pdo->prepare("SELECT news.* FROM news WHERE news.id = {$this->newsID};");
        $statement->execute();
        $result = $statement->fetchAll(2);
        // echo '<br>';
        // var_dump($result);

        if(count($result)):
            echo '<br><span class="data second">gotcha something</span>';
            if(count($result) > 1):
                echo '<br><span class="data second">over one</span>';
                $this->newsID = NULL;
            else:
                echo '<br><span class="data second">gotcha one</span>';
                $this->newsID = $result[0]['id'];
                echo "<br><span class='data second'>newsID = {$result[0]['id']}</span>";
            endif;
        else:
            $this->newsID = NULL;
            echo '<br><span class="data second">new ID is not existing</span>';
        endif;
        
        echo '<br><span class="data first">fetchNewsID ended</span>';
    }


    function isSatTagOnTheNewsByNewsID() {

        echo '<br><span class="data first">isSatTagOnTheNewsByNewsID started</span>';

        if(!$this->newsID):
            echo '<br><span class="data second">news ID is not sat</span>';
            return 0;
        endif;

        $statement = $this->pdo->prepare("SELECT news_tag.* FROM news_tag WHERE news_id = {$this->newsID}");
        $statement->execute();
        $result = $statement->fetchAll(2);

        if(count($result)):
            echo "<br><span class='data second'>this news ID already linked</span>";
            $this->IsNewsIDAlreadyLinked = true ;

        else:
            echo "<br><span class='data second'>this news ID is vacant</span>";
            $this->IsNewsIDAlreadyLinked = false ;
        endif;

        echo '<br><span class="data first">isSatTagOnTheNewsByNewsID ended</span>';

    }


    function linkTagOnNews() {

        echo '<br><span class="data first">linkTagOnNews started</span>';

        if($this->IsNewsIDAlreadyLinked):
            echo "<br><span class='data second'>sorry linking is not posible</span>";
            return 0;
        endif;


        if(!$this->tagID || !$this->newsID):
            echo "<br><span class='data second'>no id to link</span>";
            return 0;
        endif;



        $statement = $this->pdo->prepare("INSERT INTO news_tag (news_tag.news_id , news_tag.tag_id) VALUES ('$this->newsID' , '$this->tagID');");
        
        if($statement->execute()):
            echo "<br><span class='data second'>linked</span>";
            echo "<br><span class='data second'>lastInsertId: {$this->pdo->lastInsertId()}</span>";
        else:
            echo "<br><span class='data second'>NO LINKED!!!!</span>";
        endif;
        
        echo '<br><span class="data first">linkTagOnNews ended</span>';

    }

    function display() {
        // ob_start();
        echo '<br>';
        var_dump($this->pdo);
    }
}



global $pdo;

// var_dump($pdo);

$ATBNID = new addingTagByNewsID($pdo);

// $ATBNID->display();

$ATBNID->fetchTagName();

$ATBNID->fetchNewsID();

$ATBNID->isSatTagOnTheNewsByNewsID();

$ATBNID->linkTagOnNews();


?>

<br><a href='linkTagInterface.php'>НАЗАД!!!</a>


<style>

span.data.first {
    color: red;
}

span.data.second {
    color: green;
}

</style>
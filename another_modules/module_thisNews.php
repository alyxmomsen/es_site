<?php 

// echo '<pre>' ;
// var_dump($_SERVER);
// echo '</pre>' ;


require_once 'db_connect.php' ;

global $pdo ;

class DBManager {

    protected $pdo ;

    public $thisNewsData = NULL ;
    public $thisNewsTheme = NULL ;
    public $thisNewsVideo = NULL ;
    public $thisNewsImages = NULL ;
    public $thisNewsTags = NULL ;

    function __construct($pdo) {
        $this->pdo = $pdo ;
    }

    

    

    function getThemeToTheNews ($newsID) {
        $statement = $this->pdo->prepare("SELECT themes.* 
        FROM news , themes , news_theme 
        WHERE news.id = ? 
        AND news.id = news_theme.news_id 
        AND news_theme.theme_id = themes.id"); 
        //
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>' ;
        // var_dump($result);
        // echo '</pre>' ;

        if(count($result)) {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return $result ;
        }
        else {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return NULL ;
        }
        
    }

    function getVideoToTheNews ($newsID) {
        $statement = $this->pdo->prepare("SELECT video_files.* 
        FROM news , video_files , newsid_videoid 
        WHERE news.id = ? 
        AND news.id = newsid_videoid.news_id 
        AND newsid_videoid.video_id = video_files.id");
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(count($result)) {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return $result ;
        }
        else {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return NULL ;
        }
        return 0 ;
    }

    function getImagesToTheNews ($newsID) {
        $statement = $this->pdo->prepare("SELECT images.* , news_img.comment 
        FROM news , images , news_img 
        WHERE news.id = ? 
        AND news.id = news_img.news_id 
        AND news_img.images_id = images.id");
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(count($result)) {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return $result ;
        }
        else {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return NULL ;
        }
        return 0 ;
    }

    function getTagsToTheNews ($newsID) {
        $statement = $this->pdo->prepare("SELECT hash_tags.* 
        FROM news  , hash_tags , news_tag 
        WHERE news.id = ? 
        AND news.id = news_tag.news_id 
        AND news_tag.tag_id = hash_tags.id");
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(count($result)) {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return $result ;
        }
        else {
            // echo '<pre>' ;
            // var_dump($result);
            // echo '</pre>' ;
            return NULL ;
        }
        return 0 ;
    }

    function getThisNewsDataStatement () {
        $statement = $this->pdo->prepare("SELECT news.* FROM news WHERE news.id = {$_GET['NID']}"); 
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->thisNewsData = $result ;

        //

        $this->thisNewsTheme = $this->getThemeToTheNews($result[0]['id']);
        // echo '<pre>' ;
        // var_dump($this->thisNewsTheme);
        // echo '</pre>' ;
        $this->thisNewsVideo = $this->getVideoToTheNews($result[0]['id']) ;

        $this->thisNewsImages = $this->getImagesToTheNews($result[0]['id']) ;

        $this->thisNewsTags = $this->getTagsToTheNews($result[0]['id']) ;



        return $result ;
    }

    function foo1() {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            // echo 'get' ;

            // echo '<pre>' ;
            // var_dump($_GET);
            // echo '</pre>' ;


            if(isset($_GET['NID'])) {
                return $this->getThisNewsDataStatement();
                echo 'qwerty';
            }


        }
    }

}

$dbm = new DBManager($pdo) ;

$dbm->foo1() ;

// echo '<pre>' ;
// var_dump(parse_url($dbm->thisNewsData[0]['source_from']));
// echo '</pre>' ;


// $dbm->thisNewsData ;

?>

<div id='module_thisNews'>
    <div class='m-tn-main-wrapper'>
        <div class='m-tn-date-time-wrapper'>
            <div class='m-tn-date-time'>
                <?= $dbm->thisNewsData[0]['cdt'] ?>
            </div>
            <div class="m-tn-hash-tag">
                <?= $dbm->thisNewsTags[0]['name'] ?>
            
            </div>
        </div>
        <div class='m-tn-multimedia-wrapper'>
            <div class='m-tn-photo-wrapper'>
                <?php 

                if(count($dbm->thisNewsImages) > 1) {
                    // echo "<img src='{$dbm->thisNewsImages[0]['path']}'>" ;
                    
                    foreach ($dbm->thisNewsImages as $item) {
                        if($item['comment'] === 'main') {
                            echo "<div class='m-tn-displaying-img-wrapper'><img class='m-tn-displaying-img' src='{$item['path']}'></div>" ;
                        }
                    }
                    // echo $dbm->thisNewsImages ;
                    
                    echo "<div class='m-tn-other-img-main-wrapper'>" ;

                    $multimediaWrapperCounter = 0 ;
                    $multimediaWrapperClass = 'm-tn-current-img' ;
                    foreach ($dbm->thisNewsImages as $item) {
                        if($multimediaWrapperCounter < 1) $multimediaWrapperClass = 'm-tn-current-img' ;
                        else $multimediaWrapperClass = '' ;
                        echo "<div class='m-tn-other-img-personal-wrapper $multimediaWrapperClass'><img class='m-tn-other-img' src='{$item['path']}'></div>" ;
                        $multimediaWrapperCounter++ ;
                    }

                    echo "</div>" ;
                    
                }
                else {
                    echo "<div class='m-tn-displaying-img-wrapper m-tn-current-img'><img class='m-tn-displaying-img' src='{$dbm->thisNewsImages[0]['path']}'></div>" ;
                }
                 
                
                ?>
            </div>
            
            <div class="m-tn-video-main-wrapper">
                <?php

                    if(true) {
                        echo '<pre>' ;
                        var_dump($dbm->thisNewsVideo);
                        echo '</pre>' ;
                    }
                
                
                ?>
                
            </div>
        </div>
        <div class='m-tn-body-wrapper'>


            <span class='m-tn-news-theme'><?= $dbm->thisNewsTheme[0]['theme_name'] ?></span>
            <div class='m-tn-main-text'>
                <!-- <div class="m-tn-title"></div> -->
                <div class="m-tn-body"><?= $dbm->thisNewsData[0]['body'] ?></div>
            </div>
        </div>
        <div class='m-tn-link-wrapper'>

            <a href='#'><?= parse_url($dbm->thisNewsData[0]['source_from'])['host'] ?></span>
        </div>
    </div>
</div>
<link rel="stylesheet" href="css/module_thisNews.css?v=<?= time(); ?>">
<script>

</script>
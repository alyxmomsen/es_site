<?php

require_once 'db_connect.php';
global $pdo ;
class TimeMachineMoreButton {

    protected $pdo = '';

    function __construct ($pdo) {
        $this->pdo = $pdo;


    }


    function getNewsByThemeID () {
        $fullDate = $_POST['data-me'];
        $themeID = $_POST['themeID'];
        $date = explode(' ' , $fullDate)[0];

        $statement = $this->pdo->prepare("SELECT news.* FROM news , news_theme , themes WHERE theme_id = {$themeID} AND themes.id = news_theme.theme_id AND news_theme.news_id = news.id AND news.cdt < {$fullDate} ORDER BY news.cdt DESC LIMIT 5");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getNewsByDate () {
        $fullDate = $_POST['data-me'];
        $date = explode(' ' , $fullDate)[0];

        $statement = $this->pdo->prepare("SELECT news.* FROM news WHERE news.cdt LIKE '$date%' AND news.cdt < '$fullDate' ORDER BY news.cdt DESC LIMIT 5");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    function getVideoByNewsID ($newsID) {
        $statement = $this->pdo->prepare("SELECT video_files.* FROM news , video_files , newsid_videoid WHERE news.id = $newsID AND news.id = newsid_videoid.news_id AND newsid_videoid.video_id = video_files.id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    function getImgByNewsID ($newsID) {
        $statement = $this->pdo->prepare("SELECT images.* , news_img.comment FROM news, images , news_img WHERE news.id = $newsID and news.id = news_img.news_id AND news_img.images_id = images.id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getThemeByNewsID ($newsID) {
        $statement = $this->pdo->prepare("SELECT themes.* FROM themes , news , news_theme WHERE news.id = $newsID AND news.id = news_theme.news_id AND news_theme.theme_id = themes.id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getTagByNewsID ($newsID) {
        $statement = $this->pdo->prepare("SELECT hash_tags.* FROM hash_tags , news , news_tag WHERE news.id = $newsID AND news.id = news_tag.news_id AND news_tag.tag_id = hash_tags.id");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function link(){
        $arr = [];
        $news = $this->getNewsByThemeID();
        $images = [];
        foreach ($news as $row) {
            $images = $this->getImgByNewsID($row['id']);
            $video = $this->getVideoByNewsID($row['id']);
            $themes = $this->getThemeByNewsID($row['id']);
            $tags = $this->getTagByNewsID($row['id']);
            $arr[] = ['news' => $row , 'images' => $images , 'video' => $video , 'themes' => $themes , 'tags' => $tags];
        }


        return json_encode($arr);
    }
}

$tmmb = new TimeMachineMoreButton($pdo);
echo $tmmb->link();
//echo '';
//echo $_POST['data-me'];




?>
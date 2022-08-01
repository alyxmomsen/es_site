<?php
// для дееспособности футера
require "functions_for_themes.php";
require "db_connect.php";

class tagsManager {
    public $errors = [];
    public $toDisplay = [];
    public $pdo;

    function __construct ($pdo) {
        if(!$pdo): 
            $errors[] = 'no pdo';
        else:
            $this->pdo = $pdo;
            $this->toDisplay[] = $this->pdo;
        endif;
    }

    function getTagByTagID ($tagID) {
        $statement = $this->pdo->prepare ("SELECT hash_tags.* FROM hash_tags WHERE hash_tags.id = $tagID") ;
        $statement->execute();
        $result = $statement->fetchAll(2);
        if(count($result)):
            if(count($result) > 1):
                $this->toDisplay[] = $result[0]['name'];
                $this->errors[] = 'over';
                return $result[0]['name'];
            else:
                $this->toDisplay[] = $result[0]['name'];
                return $result[0]['name'];
            endif;
        else:
            $this->errors[] = 'null';
            return NULL;
        endif;
    }



    function getTagIDByNewsID ($newsID) {
        $statement = $this->pdo->prepare ("SELECT news_tag.* FROM news_tag WHERE news_id = $newsID") ;
        $statement->execute();
        $result = $statement->fetchAll(2);
        if(count($result)):
            if(count($result) > 1):
                $this->errors[] = 'tags count is over one';
                $this->toDisplay[] = $result[0]['tag_id'];
                return $result[0]['tag_id'];
            else:
                $this->toDisplay[] = $result[0]['tag_id'];
                return $result[0]['tag_id'];
            endif;
        else:
            return NULL ;
        endif;
        return 0;
    }


    function getTagName($newsID) {
        if(!$newsID) return NULL;
        $result = $this->getTagIDByNewsID ($newsID) ;
        if(!$result) return NULL ;
        return $this->getTagByTagID ($result) ;
        return NULL;
    }


}






/// возвращает ID темы если есть в глобальном массиве
function getThemeID_fromQueryString()
{
    $themeID = null;

    if(isset($_GET['theme_id'])) $themeID = $_GET['theme_id'];

    return $themeID;
}

function getThemeNameByID($themeID)
{
    global $pdo;
    $qs = "SELECT theme_name FROM themes WHERE themes.id = ? LIMIT 1";
    $statement = $pdo->prepare($qs);
    $statement->execute([$themeID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC)[0];
    return $result;
}

function getNewsID_fromGlobals()
{
    $th1nwsid = null;

    if(isset($_GET['th1nwsID'])) $th1nwsid = $_GET['th1nwsID'];

    return $th1nwsid;
}



function getThisNewsByID($nwsID)
{
    // $nwsID;
    global $pdo;
    $qs = "select * from news where id = ?";
    $statement = $pdo->prepare($qs);
    $statement->execute([$nwsID]);
    return $statement->fetchall(PDO::FETCH_ASSOC)[0];
}

function get_imgs_for_current_news_row($news_id)
{
    global $pdo;
    $statement = $pdo->prepare('select images.id , images.path , news_img.comment from news , images , news_img  
    WHERE news.id = ? AND news_img.news_id = news.id AND news_img.images_id = images.id');
    $statement->execute([$news_id]);
    $result = $statement->fetchall(2); //assoc
    return $result;
}


function getAllVideoByTheNewsID($newsID)
{
    global $pdo;

    $qs = "SELECT 
    newsid_videoid.news_id as newsid ,
    newsid_videoid.video_id as videoid , 
    newsid_videoid.caption , 
    newsid_videoid.priority , 
    newsid_videoid.description ,
    newsid_videoid.cdt ,
    video_files.path , 
    video_files.src
    FROM newsid_videoid , video_files , news 
    WHERE news.id = ? 
    AND newsid_videoid.news_id = news.id 
    AND newsid_videoid.video_id = video_files.id";

    $statement = $pdo->prepare($qs);

    $statement->execute([$newsID]);

    return $statement->fetchall(PDO::FETCH_ASSOC);
}

function getAllPhotoByTheNewsID($photoID)
{
    global $pdo;

    $qs = "SELECT 
    news_img.news_id as newsid ,
    news_img.images_id as photoid , 
    news_img.caption as caption, 
    news_img.comment as priority , 
    news_img.description ,
    images.path , news_img.style
    FROM news_img , images , news 
    WHERE news.id = ? 
    AND news_img.news_id = news.id 
    AND news_img.images_id = images.id";

    $statement = $pdo->prepare($qs);

    $statement->execute([$photoID]);

    return $statement->fetchall(PDO::FETCH_ASSOC);
}

function getNewsThemeByThisNewsId($thisNewsID)
{
    global $pdo;
    $qs = "SELECT themes.theme_name 
    FROM 
    themes , news_theme , news 
    WHERE news.id = ? 
    AND news.id = news_theme.news_id 
    AND news_theme.theme_id = themes.id";
    $statement = $pdo->prepare($qs);
    $statement->execute([$thisNewsID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}


$images_array = get_imgs_for_current_news_row(getNewsID_fromGlobals()); 
$this_news_by_id = getThisNewsByID(getNewsID_fromGlobals());

?>
<!doctype html>
<html lang="ru-RU">
    <head>
        <title><?= $this_news_by_id['title'] ?></title>
        <meta charset="UTF-8">
        <?php require 'meta.php'; ?>
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <!-- ========= -->
        
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <link rel="stylesheet" href="css/th1nws.css?v=<?= time() ; ?>">
        
        <script src="jquery/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="theia-sticky-sidebar-master/dist/ResizeSensor.js?v=<?= time() ; ?>"></script>
        <script type="text/javascript" src="theia-sticky-sidebar-master/dist/theia-sticky-sidebar.js?v=<?= time() ; ?>"></script>
        <script type="text/javascript" src="theia-sticky-sidebar-master/js/test.js?v=<?= time() ; ?>"></script>
        <script>
            jQuery(document).ready(function() {
                document.getElementsByClassName('root-flex-container')[0].scrollIntoView();
                // window.scrollTo(100 , 666);

                jQuery('.stuck').theiaStickySidebar({
                    // containerSelector: 'div.root-flex-container' ,
                    // additionalMarginBottom: 19 
                    // additionalMarginTop: 19
                });
                
            });
        </script>
        </head>
    <?php
        // echo '<pre>';
        // print_r(getThisNewsByID(getNewsID_fromGlobals()));
        // print_r(get_imgs_for_current_news_row(getNewsID_fromGlobals()));
        // echo '</pre>';
    ?>
    <body>
    <?php 
    
    
    ?>
        <div class='superMain this-one-news'>
            <?php require 'head.php'; ?>
            <div class="root-flex-container">
                <div class="turn-up-bar stuck">
                    <div class="theiaStickySidebar">
                        <div class="to-up-link-bar">
                            <a href="#" class="to-up-arrow"></a>
                        </div>
                    </div>
                </div>
                <div class="the-news-container stuck">

                    <?php 
                    global $pdo;
                    $tm = new tagsManager ($pdo);
                    ?>


                    <div class="date-flex-container">
                        <span class='date'>
                            <?= date('d.m.Y' , strtotime($this_news_by_id['cdt'])) ?>
                        </span>
                        <span class='separator'>&nbsp;|&nbsp;</span>
                        <span class="time">
                            <?= date('h:i:s' , strtotime($this_news_by_id['cdt'])) ?>&nbsp;|&nbsp;
                        </span><span class="date"><?= $tm->getTagName(getNewsID_fromGlobals()); ?></span>
                    </div>
                    <div class="main-images-slider-module">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <!-- <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol> -->
                            <div class="carousel-inner">



                            <!-- <div class="carousel-inner">
                                <div class="carousel-item active">
                                <img src="..." class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Метка первого слайда</h5>
                                    <p>Некоторый репрезентативный заполнитель для первого слайда.</p>
                                </div>
                                </div> -->





                                <?php
                                    $photo_arr = getAllPhotoByTheNewsID(getNewsID_fromGlobals());
                                    $isSetActivAttr = false;
                                    foreach($photo_arr as $ph)
                                    {
                                        echo "

                                            <div class='carousel-item

                                        ";
                                        if(!$isSetActivAttr):
                                            echo " active";
                                            $isSetActivAttr = true;
                                        endif;
                                        echo "'><img style='";
//                                        echo $ph['style'];
                                        echo "' src='$ph[path]' class='d-block w-100' alt=''>";
                                        if($ph['caption'] != NULL) {
                                            echo "<div class='carousel-caption d-none d-md-block'>" ;
                                            echo "<h5>{$ph['caption']}</h5>" ;
                                            echo "<p></p>" ;
                                            echo "</div>" ; 
                                        }
                                        echo "</div>";
                                    }

                                ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <h1><?= $this_news_by_id['title'] ?></h1>
                    <div class="the-news-body"><span class="theme-prefix"><a href="#"><?= getNewsThemeByThisNewsId($this_news_by_id['id'])[0]['theme_name'] ?></a></span><?= $this_news_by_id['body'] ?></div>
                    <?php
                    if($this_news_by_id['source_from']):
                    echo "
                    
                        <a style='font-size: 1.2em;color: gray;' target='_blank' href='$this_news_by_id[source_from]'>" . parse_url($this_news_by_id['source_from'])['host'] . "</a>
                        <br><br>

                    ";
                    endif;
                    
                    ?>
                </div> 
                <div class="media-flex-container stuck">
                    <?php 
                    // print_r();
                    $video_arr = getAllVideoByTheNewsID(getNewsID_fromGlobals());
                    foreach( $video_arr as $v )
                    {
                        echo "
                        <div style='' class='container video-item'>
                            <div class='video-container background'>
                        ";
                        
                        if($v['src'] === 'ytb'): 
                            echo $v['path'];
                        else:
                            echo "
                                <video controls preload='none'>
                                    <source controls width='100%' height='100%' src='data/video/public_video/$v[path]'>
                                    Your browser does not support HTML video.
                                </video>
                            ";
                        endif;
                        echo "
                            </div>
                            <div class='caption'>
                                
                            </div>
                            <div class='descripton'>
                                $v[description]
                            </div>
                        </div>
                        ";
                    }
                    ?>
                    
                </div>
                <!--  -->
            </div>
            <?php require 'footer.php'; ?>
        </div>
    </body>
    
</html>

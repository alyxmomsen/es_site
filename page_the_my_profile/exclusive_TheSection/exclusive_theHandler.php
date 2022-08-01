<?php 

class ExclusiveContentManager {

    /* protected $pdo ; */

    function __construct() {

        $this->pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

    }

    function getEntries() {
        $statement = $this->pdo->prepare('SELECT news.* 
        FROM news , news_theme 
        WHERE news_theme.theme_id = 22014 
        AND news_theme.news_id = news.id order by cdt desc limit 5');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;

    }


    function getImg ($newsID) {
        $statement = $this->pdo->prepare('SELECT images.* , news_img.* 
        FROM news_img , images 
        WHERE news_img.news_id = ? 
        AND news_img.images_id = images.id');
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;
    }


    function getVideo ($newsID) {
        $statement = $this->pdo->prepare('SELECT news.id , newsid_videoid.* 
        FROM news , newsid_videoid , video_files 
        WHERE newsid_videoid.video_id = video_files.id 
        AND news.id = ? 
        AND newsid_videoid.news_id = news.id;');
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;
    }

    function getTheme () {
        $statement = $this->pdo->prepare('');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;
    }

    function getTag ($newsID) {
        $statement = $this->pdo->prepare('SELECT hash_tags.* 
        FROM news_tag , hash_tags 
        WHERE news_tag.news_id = ? 
        AND news_tag.tag_id = hash_tags.id');
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;
    }

}

$ecm = new ExclusiveContentManager();


$someContent = $ecm->getEntries() ;








?>
<div class='theExclusive-SuperMain_wraper'>
    <div class="theExclusive-mainSection">
        <div class="theExclusive-mainSection-metaLine">

        </div>
        <div class="theExclusive-mainSection-mediaLine">
            <div class="theExclusive-mainSection-mediaLine-imagesBlock">
                <div class="theExclusive-mainSection-mediaLine-mainImgContainer">
                    <?php 
                    
                    $images = $ecm->getImg($someContent[0]['id']);
                    
                    echo '<img src="' . $images[0]['path'] . '">' ;
                    
                    
                    ?>
                </div>
                

                <?php 
                
                if(count($images) > 1):
                    echo '<div class="theExclusive-mainSection-mediaLine-otherImagesContainer">' ;

                    foreach($images as $img):
                        echo '<div class="theExclusive-mainSection-mediaLine-otherImgContainer">' ;
                        echo '<img alt="" src="' . $img['path'] . '">' ;
                        echo '' ;
                        // echo 'hello' ;
                        echo '</div>' ;
                    endforeach;
                    echo '' ;
                    echo '' ;
                    echo '</div>' ;
                endif;

                
                ?>


                

                
            </div>
            <div class="theExclusive-mainSection-mediaLine-videoContainer"></div>
            
        </div>
        <div class="theExclusive-mainSection-body">
            <div class="theExclusive-mainSection-title">
                <?php /* echo $someContent[0]['title'] */ ?>
            </div>
            <div class="theExclusive-mainSection-contentText">
                <?php 

                    echo $someContent[0]['body'] ;


                ?>
            </div>
            <div class="theExclusive-mainSection-contentSource">

            </div>
        </div>
    </div>
    <div class="theExclusive-LastNewsSideBar">
        <div class="theExclusive-LastNewsSideBar-contantContainer">
<?php 


$h_tag = NULL ;
foreach( $someContent as $entry ) {


    $h_tag = $ecm->getTag($entry['id']);
    $images = $ecm->getImg($entry['id']) ;

    echo '<div class="theExclusive-theEntry">';
    echo '<div class="theExclusive-theEntry-metaLine">' ;
    /* echo '' ; */
    
    if(count($h_tag)):
        
        echo '<div class="theExclusive-theEntry-tag">' ;
        echo $h_tag[0]['name'] ;
        echo '</div>' ; /* theExclusive-theEntry-tag */
        
    endif;
    
    
    echo '</div>' ; /* theExclusive-theEntry-metaLine */

    echo '<div class="theExclusive-theEntry-body">' ; 

    if(count($images)):

        foreach($images as $img):
            if($img['comment'] === 'main'):

                echo '<div class="theExclusive-theEntry-imgContainer">' ;
                echo '<img alt="" src="' . $img['path'] . '">' ;
                echo '</div>' ; /* theExclusive-theEntry-imgContainer */
                
            endif;
        endforeach;

    endif;

    echo '<div class="theExclusive-theEntry-titleContainer">' ;
    echo $entry['title'] ; 
    echo '</div>' ; /* theExclusive-theEntry-titleContainer */
    echo '</div>' ; /* theExclusive-theEntry-body */
    echo '</div>' ; /* theExclusive-theEntry */
    /* echo '<br>' ;
    echo 'isEntry' ; */
}


?>
            
        </div> <!-- theExclusive-LastNewsSideBar-contantContainer -->
        <div class="theExclusive-morebuttonContainer">
            <button>ещё</button>
        </div>
    </div> <!-- theExclusive-LastNewsSideBar -->
</div> <!-- theExclusive-SiperMain_wraper -->
<style>

.theExclusive-mainSection-mediaLine {
	display: flex;
}



.theExclusive-SuperMain_wraper {
	display: flex;
    height: 100%;
}

.theExclusive-mainSection {
	flex: 4;
    border: 1px solid;
}


/* -------------------------------------------------------- */

.theExclusive-mainSection-mediaLine-imagesBlock {
	position: relative;
}

.theExclusive-mainSection-mediaLine-otherImagesContainer {
	position: absolute;
	bottom: 0;
	width: 100%;
	height: 25%;
	background: #8080807d;
	display: flex;
}

.theExclusive-mainSection-mediaLine-otherImgContainer {
	width: 25%;
	height: 100%;
}


.theExclusive-mainSection-mediaLine-otherImgContainer img {
	width: 100%;
	height: 100%;
	object-fit: contain;
}

/* -------------------------------------------------------- */

.theExclusive-LastNewsSideBar {
	flex: 2;
	height: 100%;
	/* overflow: scroll; */
}

.theExclusive-theEntry {
	border: 1px solid;
	margin: 6px;
	padding: 6px;
}

.theExclusive-LastNewsSideBar-contantContainer {
	height: 96%;
	overflow-y: scroll;
    overflow-x: hidden;
}


.theExclusive-theEntry-body {
	display: flex;
}

.theExclusive-theEntry-tag {
	font-weight: bold;
}

.theExclusive-theEntry-imgContainer {
	flex: 2;
}

.theExclusive-theEntry-body img {
	width: 100%;
	height: 144px;
	object-fit: cover;
}

.theExclusive-theEntry-titleContainer {
	flex: 4;
}

.theExclusive-morebuttonContainer {
	height: 4%;
	/* border: 2px solid; */
	display: flex;
	justify-content: center;
}
</style>
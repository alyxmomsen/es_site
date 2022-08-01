<?php



$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

function setNewIPitoDB ($pdo) {

    $statement = $pdo->prepare("INSERT INTO guests (`id`, `ip`) VALUES (NULL, '{$_SERVER['REMOTE_ADDR']}')");
    $result = $statement->execute();
    echo var_dump($result);

}

//setNewIPitoDB($pdo);

class TimeMachineManager {
    protected $pdo;
    public $newsByDate = [] ;
    public $tagByNewsID = [] ;
    public $imagesByNewsID = [] ;
    public $themeByNewsID = [] ;
    public $videoByNewsID = [] ;




    function __construct($pdo)
    {
        $this->pdo = $pdo;

    }


    function getNewsByDate($limit = NULL) {
        if(!$limit) $limit = '' ;
        else $limit = "LIMIT $limit" ;
        $GET_array = $this->getGET_DateData();
        $statement = $this->pdo->prepare("SELECT news.* FROM news WHERE cdt LIKE '{$GET_array['year']}-{$GET_array['month']}-{$GET_array['day']}%' ORDER BY cdt DESC $limit");
        $statement->execute([$limit]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->newsByDate = $result;
        return $result ;
    }


    function getTagByNews ($newsID) {
        // echo '$newsID' . $newsID;
        $statement = $this->pdo->prepare(
                "SELECT hash_tags.* FROM news , hash_tags , news_tag WHERE news.id = {$newsID} AND news_tag.news_id = news.id and news_tag.tag_id = hash_tags.id"
        );
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->tagByNewsID = $result;
        // var_dump($this->tagByNews);
        return $result;
    }


    function getThemeByNewsID ($newsID) {
        $statement = $this->pdo->prepare(
            "SELECT themes.* FROM news , news_theme , themes WHERE news.id = ? AND news.id = news_theme.news_id AND news_theme.theme_id = themes.id"
        );
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->themeByNewsID = $result;

        return $result;
    }


    function getIMGBYNewsID ($newsID) {
        $statement = $this->pdo->prepare(
                "SELECT images.* , news_img.style , news_img.comment FROM images , news , news_img WHERE news.id = ? AND news_img.news_id = news.id AND images.id = news_img.images_id"
        );
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        /*$this->imagesByNewsID = $result;*/
        return $result;
    }


    function getVideoByNewsID ($newsID) {
        $statement = $this->pdo->prepare(
            "SELECT video_files.* FROM video_files , news , newsid_videoid WHERE news.id = ? AND news.id = newsid_videoid.news_id AND newsid_videoid.video_id = video_files.id"
        );
        $statement->execute([$newsID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        // $this->videoByNewsID = $result;
        /*var_dump($newsID);
        var_dump($result);*/
        return $result;
    }

    function getGET_DateData () {
        $arr = [];
        $arr['year'] = $_GET['year'];
        if((int)$_GET['month'] < 10) {
            $arr['month'] = '0' . $_GET['month'];
        }
        else {
            $arr['month'] = $_GET['month'];
        }
        if((int)$_GET['day'] < 10) {
            $arr['day'] = '0' . $_GET['day'];
        }
        else {
            $arr['day'] = $_GET['day'];
        }


        return $arr ;
    }

}

$tmm = new TimeMachineManager ($pdo);
$tmm->getNewsByDate();
$tmm->tagByNewsID = $tmm->getTagByNews($tmm->newsByDate[0]['id']);
$tmm->imagesByNewsID = $tmm->getIMGBYNewsID($tmm->newsByDate[0]['id']);
$tmm->themeByNewsID = $tmm->getThemeByNewsID($tmm->newsByDate[0]['id']);
$tmm->videoByNewsID = $tmm->getVideoByNewsID($tmm->newsByDate[0]['id']);



?>
<!doctype html>
<html lang="en">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
</style>
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>новости за сутки | <?= $tmm->newsByDate[0]['cdt'] ; ?> | Егор Сухачев</title>
    <!--bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!--/bootstrap-->
    <link rel="stylesheet" href="css/head_v1.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/footer_v2.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/timemachine.css?v=<?= time() ?>">
    <script src="https://kit.fontawesome.com/da9981aa25.js" crossorigin="anonymous"></script>
</head>
<body>
<div id="time_machine-main">
    <?php require 'head.php' ; ?>
    <div id="time_machine-main-content-container">
        <div id="time_machine-news_card">
            <div class="news_card-caption">
                <div class="chronometr"><?php echo $tmm->newsByDate[0]['cdt'] ?></div>
                <?php

                $tmm->getTagByNews($tmm->newsByDate[0]['id']);
                if(count($tmm->tagByNewsID)) {
//                    var_dump($tmm->tagByNewsID);
                    echo "<div style='' class='hash-tag'>{$tmm->tagByNewsID[0]['name']}</div>";
                }
                else {
/*                    echo "<div style='display: none;' class='hash-tag'>#<?php echo $tmm->tagByNewsID[0]['name'] ?></div>";*/
                    echo "<div style='display: none;' class='hash-tag'></div>";
                }
                ?>

            </div>
            <div class="time-machine-wrapper-main-body">
                <div class="time-machine-column-wrapper-left">
                    <div class="news_card-img_section">
                        <div class="main-img-container">
                            <?php

                            foreach ($tmm->imagesByNewsID as $row) {
                                if($row['comment'] === 'main') {
                                    echo "<img class='main-image  click_to_open' src='$row[path]'>";
                                }
                            }

                            ?>

                            <div class='other-images'>

                                <?php

                                if(count($tmm->imagesByNewsID) > 1) {
                                    foreach ($tmm->imagesByNewsID as $row) {
                                        echo "<div class='other-img-wrapper'><img " ;

                                        if($row['comment'] === 'main') {
                                            echo 'class="displayed-img"';
                                        }

                                        echo " src='" . $row['path'] . "'></div>";
                                    }
                                }

                                ?>

                            </div>
                            <div class="closebutton">X</div>
                        </div>


                        <?php

                        if(count($tmm->videoByNewsID)) {
                            echo '<div style="display: block;" class="time-machine-video-container">';
                        }
                        else {
                            echo '<div style="display: block;" class="time-machine-video-container">';
                        }

                        ?>

                            <?php

                            if(count($tmm->videoByNewsID)) {
                                echo "<div class='time-machine-video-wrapper'>" ;

                                foreach ($tmm->videoByNewsID as $row) {
                                    if($row['src'] === 'ytb'):
                                        echo $row['path'];
                                    else:
                                        echo "<video controls width='100%' height='100%' style='object-fit: cover;'>" ;
                                        echo "<source src='http://egorsukhachev.com/data/video/public_video/" . $row['path'] . "' type='video/mp4'>" ;
                                        echo "</video>" ;
                                    endif;
                                }
                                echo "</div>" ;
                            }
                            else {
                                echo "<div class='time-machine-video-wrapper'>";
                                echo "<img style='width: 100%; height: 100%; object-fit: cover;' src='http://egorsukhachev.com/data/img/anotherPhoto/noVideo.jpg'>" ;
                                echo "</div>" ;
                            }

                            /*var_dump($tmm->videoByNewsID);*/
                            ?>

                        <?php

                        echo '</div>';

                        ?>


                    </div>
                    <div class="news_card-content-container">
                        <div class="time-machine-theme"><?php echo $tmm->themeByNewsID[0]['theme_name'] ?></div>
                        <div class="time-machine-card-content">
                            <?php echo $tmm->newsByDate[0]['body'] ?>
                        </div>
                        <div class="time-machine-card-source-container">
                            <?php
                                echo "<a target='_blank' class='time-machine-card-source' href='";
                                echo $tmm->newsByDate[0]['source_from'] ;
                                echo "'>";
                                if($tmm->newsByDate[0]['source_from'] !== ''):
                                    echo parse_url($tmm->newsByDate[0]['source_from'])['host'];
                                else:
                                    echo 'egorsukhachev.com';
                                endif;
                                echo "</a>";
                             ?>
                        </div>
                    </div>
                </div>
                <div class="time-machine-column-wrapper-right">

                    <div class="all-hash-tags-by-date">
                        <?php

                        $totalAllTagsToDate = [];
                        foreach ($tmm->newsByDate as $row) {
                            foreach ($tmm->getTagByNews($row['id']) as $row) {
                                $totalAllTagsToDate[] = $row['name'];
                            }
                        }

//                        var_dump($totalAllTagsToDate);
//                        echo count($totalAllTagsToDate);
//                        echo "<br>";
                        $newArray = array_unique($totalAllTagsToDate);
//                        echo count($totalsAllTagsToDate);
                        foreach ($newArray as $row) {
                            echo "<div class='clickable-tag'>$row</div>";
                        }

//                        var_dump($newArray);
//                        echo count($newArray);

                        ?>
                    </div>

                    <div class="time-machine-amount-container">
                        <span class="time-machine-news-amount"><?= count($tmm->newsByDate) ?></span>
                        <span class="time-machine-string"> публикаций за </span>
                        <span class="time-machine-about-news-date">
                            <?php echo trim($_GET['day']) . '.' . trim($_GET['month']) . '.' . trim($_GET['year']) ?>
                        </span>
                    </div>

                    <div class="time-machine-last-news-feed">
                        <?php
                        $timeMachineCurrentItem = 0;
                        $tmm->getNewsByDate(5);
                        foreach ($tmm->newsByDate as $row) {
                            echo "<div data-news-id='$row[id]' data-news-date='$row[cdt]' class='time-machine-news-feed-item" ;
                            if(!$timeMachineCurrentItem) echo " current";
                            echo "'>" ;
                            echo "<div class='time-machine-news-feed-item-caption'>" ;

                            
                            $tmm->getTagByNews($row['id']);
                            if(count($tmm->tagByNewsID)) echo "<span class='time-machine-news-feed-item-tag'>{$tmm->tagByNewsID[0]['name']}</span>" ;
                            else echo "<span></span>";
                            echo "<span class='time-machine-news-feed-item-date'>" . explode(' ' , $row['cdt'])[1] . "</span>" ;
                            echo "</div>" ;
                            echo "<div class='time-machine-news-feed-item-body'>" ;
                            echo "<div class='time-machine-news-feed-item-img-wrapper'>";
                            foreach ($tmm->getIMGBYNewsID($row['id']) as $row3) {
                                if($row3['comment'] === 'main') {
                                    echo "<img src='$row3[path]'>" ;
                                    break;
                                }
                            }
                            echo "</div>" ;
                            echo "<div class='news-feed-item-content-container'>" ;
                            $tmm->getThemeByNewsID($row['id']);
                            echo "<span class='time-machine-news-feed-item-theme'>{$tmm->themeByNewsID[0]['theme_name']}</span>";
                            echo "<p class='time-machine-news-feed-item-content'>";
                            echo mb_strimwidth(rtrim(strip_tags($row['body']) , "!,.-") , 0 , 200 , ' ...') ;
                            echo "</p>";
                            echo "</div>" ;
                            echo "</div>" ;
                            echo "</div>" ;

                            $timeMachineCurrentItem++;
                        }

                        ?>


                        <div class="time-machine-news-feed-more-button-container">
                            <div class="time-machine-news-feed-more-button">ещё</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        class GetMoreNewsButton {
            _newsItemSelectors;
            _buttonSelector;
            _feedContainer;
            _newsItems;
            myThis;
            _mainImg;
            _otherImgs;

            constructor() {
                let myThis = this;
                this._buttonSelector = document.querySelector('.time-machine-news-feed-more-button');
                this._feedContainer = document.querySelector('.time-machine-last-news-feed');
                this._newsItemSelectors = document.querySelectorAll('.time-machine-news-feed-item');

                this._mainImg = document.querySelector('.main-image');
                this._otherImgs = document.querySelectorAll('.other-images .other-img-wrapper img');

                this._buttonSelector.addEventListener('click', () => {
                    let xhr = new XMLHttpRequest();
                    let feedContainerElement = document.querySelector('.time-machine-last-news-feed');
                    let button = this._buttonSelector;
                    let lastElement = document.querySelectorAll('.time-machine-news-feed-item');
                    xhr.open('POST', 'handler_timemachine_getmorenews.php');
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    let mythis2 = myThis;
                    xhr.addEventListener('readystatechange', () => {
                        if (xhr.status === 200 && xhr.readyState === 4) {

                            let itemContainer = document.createElement('div');
                            itemContainer.className = 'time-machine-news-feed-item';
                            // itemContainer.setAttribute('data-news-id' , '');
                            let caption = document.createElement('div');
                            caption.className = 'time-machine-news-feed-item-caption';
                            let caption_time = document.createElement('span');
                            caption_time.className = 'time-machine-news-feed-item-date';
                            let caption_tag = document.createElement('span');
                            caption_tag.className = 'time-machine-news-feed-item-tag';
                            let body = document.createElement('div');
                            body.className = 'time-machine-news-feed-item-body';
                            let body_img_container = document.createElement('div');

                            body_img_container.className = 'time-machine-news-feed-item-img-wrapper';

                            let body_img = document.createElement('img');
                            let body_content_container = document.createElement('div');
                            body_content_container.className = 'news-feed-item-content-container';
                            let body_theme = document.createElement('span');
                            body_theme.className = 'time-machine-news-feed-item-theme';
                            let body_content = document.createElement('p');
                            body_content.className = 'time-machine-news-feed-item-content';

                            body_content_container.append(body_theme);
                            body_content_container.append(body_content);

                            body_img_container.append(body_img);
                            body.append(body_img);
                            body.append(body_content_container);

                            caption.append(caption_tag);
                            caption.append(caption_time);

                            lastElement = document.querySelectorAll('.time-machine-news-feed-item');
                            // console.log(lastElement[lastElement.length - 1]);
                            let feedContainerClone = feedContainerElement;
                            // console.log('response : ');
                            // console.log(JSON.parse(xhr.response));
                            myThis.newsItems = JSON.parse(xhr.response);
                            let newsitems = myThis.newsItems;


                            let cptn, tag, time;
                            let bady, imgCont, img, contentContainer, theme, cntnt;
                            let itemCont;
                            newsitems.forEach((item, i, items) => {

                                tag = caption_tag.cloneNode();
                                if ((typeof item.tags[0]) !== 'undefined') {

                                    tag.append(item.tags[0].name);

                                }
                                // tag.append(item.tags[0].name);
                                time = caption_time.cloneNode();
                                time.append(item.news.cdt.split(' ')[1]);
                                cptn = caption.cloneNode();
                                if ((typeof item.tags[0]) !== 'undefined') {
                                    cptn.append(tag);
                                } else {
                                    cptn.append(document.createElement('span'));
                                }

                                cptn.append(time);
                                bady = body.cloneNode();
                                img = body_img.cloneNode();
                                cntnt = body_content.cloneNode();
                                contentContainer = body_content_container.cloneNode();
                                item.images.forEach((item, i, arr) => {
                                    if (item.comment === 'main') {
                                        img.src = item.path;
                                    }
                                });
                                imgCont = body_img_container.cloneNode();
                                imgCont.append(img);
                                theme = body_theme.cloneNode();
                                theme.append(item.themes[0].theme_name);

                                let bodyText = item.news.body;
                                bodyText = bodyText.replace(/<\/?[^>]+(>|$)/g, "");
                                if (bodyText.length > 200) {
                                    bodyText = bodyText.substring(0, 200) + "...";
                                }
                                cntnt.append(theme);
                                cntnt.append(bodyText);
                                contentContainer.append(cntnt);
                                bady.append(imgCont);
                                bady.append(contentContainer);

                                itemCont = itemContainer.cloneNode();
                                itemCont.setAttribute('data-news-date', item.news.cdt);
                                itemCont.setAttribute('data-news-id', item.news.id);
                                itemCont.append(cptn);
                                itemCont.append(bady);


                                // feedContainerElement.append(cptn);
                                // feedContainerElement.append(bady);
                                // feedContainerElement.append(itemCont);
                                // button.insertBefore(itemCont);
                                // console.log(item.news.cdt);
                                // alert();
                                let parent = button.parentNode.parentNode;
                                parent.insertBefore(itemCont , button.parentNode);

                            });


                            // console.log(myThis.newsItems);
                            // myThis._feedContainer.innerHTML= this.newsItems[0].images[0].path ;
                            // console.log(myThis._feedContainer);

                            // console.log('click_button');
                            // this.addEventsOnNewsItems();
                            mythis2.addEventsOnNewsItems();


                        }
                    })
                    // console.log(lastElement[lastElement.length -1].getAttribute('data-news-id'));

                    xhr.send('data-me=' + lastElement[lastElement.length - 1].getAttribute('data-news-date') + '&themeID=22088');
                    // console.log('lastElement : ' + lastElement[lastElement.length - 1].getAttribute('data-news-id'));

                });


            }


            addEventOnImgMINI() {
                let myThis = this;
                let mythis2;
                this._otherImgs.forEach((item , i , arr) => {

                    item.onclick = () => {
                        let allOtherAndMainIMG = document.querySelectorAll('.main-img-container .other-images img');
                        allOtherAndMainIMG.forEach((item , i , arr) => {
                            item.classList.remove('displayed-img');
                        });
                        let mainIMG = document.querySelector('.main-img-container img.main-image');
                        mainIMG.src = item.src;
                        item.classList.add('displayed-img');
                    }
                });

            }

            alerting() {
                alert('alert from my this');
            }


            addEventsOnNewsItems() {
                console.log('adeventlistener end');
                this._newsItemSelectors = document.querySelectorAll('.time-machine-news-feed-item');

                let superMythis = this;

                this._newsItemSelectors.forEach((item, i, arr) => {

                    item.classList.remove('current');
                    item.onclick = function (e) {

                        let allItems = document.querySelectorAll('.time-machine-news-feed-item');
                        allItems.forEach((item2 , i , arr) => {
                            item2.classList.remove('current');
                        });
                        item.classList.add('current');
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST' , 'handler_timeMachiner_getThisNews.php');
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.addEventListener('readystatechange' , () => {
                            if (xhr.status === 200 && xhr.readyState === 4) {

                                // console.log(JSON.parse(xhr.response));
                                let date = document.querySelector('.news_card-caption .chronometr');
                                let mainImg = document.querySelector('.news_card-img_section img');
                                let theme = document.querySelector('.time-machine-theme');
                                let tag = document.querySelector('#time_machine-news_card .hash-tag');
                                let content = document.querySelector('.time-machine-card-content');
                                let aLink = document.querySelector('.time-machine-card-source');
                                let videoContainer = document.querySelector('.time-machine-video-container');
                                let otherImgs = document.querySelector('#time_machine-news_card .news_card-img_section .other-images');

                                date.innerHTML = JSON.parse(xhr.response)[0].news.cdt;
                                mainImg.src = JSON.parse(xhr.response)[0].images[0].path;
                                theme.innerHTML = JSON.parse(xhr.response)[0].themes[0].theme_name;
                                content.innerHTML = JSON.parse(xhr.response)[0].news.body;

                                // alert(JSON.parse(xhr.response)[0].news.source_from);
                                if (JSON.parse(xhr.response)[0].news.source_from) {
                                    const url = new URL(JSON.parse(xhr.response)[0].news.source_from);
                                    aLink.innerHTML = url.hostname ;
                                    aLink.href = JSON.parse(xhr.response)[0].news.source_from ;
                                }
                                else {
                                    aLink.innerHTML = 'egorsukhachev.com';
                                }

                                /**************** теги  *********/

                                if( JSON.parse(xhr.response)[0].tags.length > 0) {
                                    console.log(typeof JSON.parse(xhr.response)[0].tags);
                                    tag.innerHTML = JSON.parse(xhr.response)[0].tags[0].name;
                                    tag.classList.add('hash_tag');
                                    tag.style.display = 'block';
                                }
                                else {
                                    tag.innerHTML = '';
                                    tag.style.display = 'none' ;
                                }

                                /******************** video *********************/

                                if(JSON.parse(xhr.response)[0].video.length > 0) {
                                    videoContainer.innerHTML = '';
                                    let videoWrapper = document.createElement('div');
                                    videoWrapper.classList.add('time-machine-video-wrapper');
                                    let newVW ;

                                    let videoTag  = document.createElement('video');
                                    videoTag.controls = 'controls';
                                    videoTag.width = '100%';
                                    videoTag.height = '100%';
                                    videoTag.style.objectFit = 'cover';

                                    let sourceVideoTag = document.createElement('source');
                                    sourceVideoTag.type = 'video/mp4' ;
                                    let newSVT ;

                                    let newVT ;
                                    JSON.parse(xhr.response)[0].video.forEach((item , i , arr) => {
                                        newVW = videoWrapper.cloneNode();
                                        if(item.src === 'ytb') {
                                            // alert('ytb');

                                            // alert('youtube');
                                            newVW.innerHTML = item.path ;
                                            videoContainer.append(newVW);
                                            // videoContainer.style.display = 'flex' ;
                                        }
                                        else {
                                            // alert('not ytb');

                                            if (item.src === 'local') {
                                                newVT = videoTag.cloneNode();
                                                newVT.style.width = "100%" ;
                                                newVT.style.height = "100%" ;
                                                newSVT = sourceVideoTag.cloneNode();
                                                newSVT.src = 'http://egorsukhachev.com/data/video/public_video/' + item.path;
                                                newSVT.type = 'video/mp4';
                                                //     // <video controls width='100%' height='100%' style='object-fit: cover;'>" ;
                                                //     //     echo "<source src='http://egorsukhachev.com/data/video/public_video/" . $row['path'] . "' type='video/mp4'>" ;
                                                //     //         echo "</video>" ;
                                                // // endif;
                                                newVT.append(newSVT);
                                                videoContainer.append(newVT);
                                                // videoContainer.style.display = 'flex' ;
                                                // alert('local');
                                            }
                                            else {
                                                // alert('what');
                                            }

                                        }
                                    });

                                }
                                else {
                                    videoContainer.innerHTML = '';
                                    let novideo_img = document.createElement('img');
                                    novideo_img.style.width = '100%';
                                    novideo_img.style.height = '100%';
                                    novideo_img.style.objectFit = 'cover';
                                    novideo_img.src = 'http://egorsukhachev.com/data/img/anotherPhoto/noVideo.jpg';
                                    videoContainer.append(novideo_img);
                                    videoContainer.style.display = 'block' ;
                                }


                                /**************     ****************/


                                if(JSON.parse(xhr.response)[0].images.length > 1) {
                                    otherImgs.innerHTML = '';
                                    let imgWrapper = document.createElement('div');
                                    imgWrapper.classList.add('other-img-wrapper');
                                    let otherImg = document.createElement('img');
                                    let newImg , newWrapper;
                                    imgWrapper.append(otherImg);
                                    JSON.parse(xhr.response)[0].images.forEach((item , i , arr) => {


                                        newImg = otherImg.cloneNode();
                                        newImg.src = item.path;

                                        if(newImg.src == mainImg.src) {
                                            newImg.classList.add('displayed-img');
                                        }


                                        newWrapper = imgWrapper.cloneNode();
                                        newWrapper.append(newImg);
                                        otherImgs.append(newWrapper);



                                    });

                                }
                                else {
                                    otherImgs.innerHTML = '';
                                }

                                // alert();
                                // alert(JSON.parse(xhr.response)[0].themes[0].theme_name);
                                // mainImg.setAttribute('src' , xhr.response[0].images[0].path);
                                console.log(JSON.parse(xhr.response));
                                // alert();
                                /*item.scrollIntoView();*/
                                date.scrollIntoView();

                                let otherIMG = document.querySelectorAll('.main-img-container .other-images img');
                                otherIMG.forEach((item , i , arr) => {
                                    item.onclick = (eve) => {
                                        eve.stopPropagation();
                                        let mainIMG = document.querySelector('.main-img-container img.main-image');
                                        otherIMG.forEach((item2 , i , arr) => {
                                            item2.classList.remove('displayed-img');
                                            // item.classList
                                        })

                                        item.classList.add('displayed-img');
                                        mainIMG.src = item.src;

                                    }
                                });

                                let mainIMG_Elem = document.querySelector('.main-img-container img.main-image.click_to_open');
                                // superMythis.alerting();
                                let closeButton = document.querySelector('.main-img-container .closebutton');

                                mainIMG_Elem.onclick = superMythis.fullScreenIMG;

                                closeButton.onclick = superMythis.collapseIMGByCLoseButton;








                            }
                        });
                        xhr.send('newsID=' + item.getAttribute('data-news-id'));

                        // console.log('item.innerHTML : ' + item.innerHTML) ;
                        // alert();
                    }
                });
            }


            fullScreenIMG () {
                // mythis.alerting();
                let mythis = this ;
                // mythis.alerting();
                let imgCont = document.querySelector('.main-img-container');
                let closeButton = document.querySelector('.main-img-container .closebutton');
                imgCont.style.position = 'fixed';
                imgCont.style.width = '100%' ;
                imgCont.style.height = '100%' ;
                let mainIMGel = document.querySelector('.main-img-container img.main-image.click_to_open');
                // mainIMGel.onclick = mythis.collapseIMG;
                closeButton.style.display = 'flex' ;
                // mythis.alerting();
                // alert();
            }


            collapseIMGByCLoseButton () {
                let imgCont = document.querySelector('.main-img-container');
                let closeButton = document.querySelector('.main-img-container .closebutton');
                closeButton.style.display = 'none' ;
                imgCont.style.position = 'relative';

            }

            addEventsOnTags () {
                let allClickableTags = document.querySelectorAll('.all-hash-tags-by-date .clickable-tag');
                allClickableTags.forEach((item , i , arr) => {
                    item.onclick = () => {
                        let newsItem = document.querySelectorAll('#time_machine-news_card .time-machine-news-feed-item');

                        allClickableTags.forEach((item2 , i2 , arr2) => {
                            item2.removeAttribute('data-filter-item');
                        });
                        // alert(item.textContent);
                        item.setAttribute('data-filter-item' , 'true');

                        newsItem.forEach((item3 , i3 , arr) => {
                            // item3.removeAttribute('data-filtered-item');
                            item3.classList.add('filtered-item');
                            // if(item3.textContent === item.textContent) {
                            //     alert('got');
                            // }
                            if(item3.children[0].children[0].textContent === item.textContent) {
                                // alert(item.textContent);
                                item3.classList.remove('filtered-item');
                                //     item3.setAttribute('data-filtered-item' , 'true');
                            }

                            console.log(item3.children[0].children[0].textContent);
                            console.log(item.textContent);
                        });
                    }
                });
            }
        }

        // fullscreenMainIMG () {
        //
        // }

        let GMN = new GetMoreNewsButton();
        GMN.addEventsOnNewsItems();
        GMN.addEventOnImgMINI();
        GMN.addEventsOnTags();
        // alert();
    </script>


    <?php require "modules/module_asidePanel.php" ; ?>
    
    <?php require 'footer.php' ; ?>
</div>

</body>

</html>

<!-- we have bugs in footer script -->
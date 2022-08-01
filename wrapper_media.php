<?php

require "db_connect.php";

function getThemeForTheVideoByVIdeoID($videoID)
{
    global $pdo;
    $qs = "SELECT 
    themes.id as themeID , 
    themes.theme_name
    FROM video_files , themeid_videoid , themes 
    WHERE video_files.id = ? 
    and video_files.id = themeid_videoid.video_id 
    AND themeid_videoid.theme_id = themes.id";
    $statement = $pdo->prepare($qs);
    $statement->execute([$videoID]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}


$videoByTheme_array = getVideosByThemeID(getThemeID_fromQueryString());
$media_title = 'видео по теме: ';
if(!$videoByTheme_array) 
{
    $videoByTheme_array = getAllVideo();
    $media_title = 'еще видео: ';
}

// echo '<pre>';
// print_r($videoByTheme_array);
// echo '</pre>';
?>

<div class='wrapper'>
    <h2 class="header"><?= $media_title ?></h2>
    <div class="flex-container">
    <?php
        // $videoByTheme_array наследуется от родительского компонента
        foreach($videoByTheme_array as $v)
        {
            // print_r($v['videoID']);
            // print_r(getThemeForTheVideoByVIdeoID($v['vID']));
            // echo '<pre>';
            // getThemeForTheVideoByVIdeoID($v['vID']);
            // echo '</pre>';
            echo "
                <div class='container video-item'>
                    <div class='theme-date flex-container'>
                        <span class=''><a href='news.php?theme_id=" . getThemeForTheVideoByVIdeoID($v['vID'])[0]['themeID'] ."'>" . getThemeForTheVideoByVIdeoID($v['vID'])[0]['theme_name'] ."</a></span>
                        <span class='date-time'>
                            <span class='date'>$v[date]</span><span class='separator'> | </span><span class='time'>$v[time]</span>
                        </span>
                        </span>
                    </div>
                    <div class='video-container background'>
                        <video controls preload='none'>
                            <source src='$v[vPath]'>
                            Your browser does not support HTML video.
                        </video>
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
</div>

<style>
    div.video-container.background {
        background-color: #2b2b2b;
    }

</style>
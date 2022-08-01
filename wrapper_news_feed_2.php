<?php 

$all_news_rows = get_all_news_rows();
// print_r($all_news_rows);
$total_news_amount = count($all_news_rows); 

?>

<div class="wrapper news-feed">
    <?php
    
    for($mainCounter = 0 ; $mainCounter < $total_news_amount ; $mainCounter++)
    {
        
        echo "
            <div " ;

                if($innerCounter) echo "style='border-top: 2px solid #ddd;'";

            echo  "id='news-id-{$all_news_rows[$mainCounter]['id']}' class='news-container'>
                <div class='date-theme-tags-container'>
                    <div class='date-and-time-container'>
                        <a href='$_SERVER[PHP_SELF]'>{$all_news_rows[$mainCounter]['cdt']}</a>
                    </div>";
                    

                    $tags_arr = get_tags_for_the_current_news_row($all_news_rows[$mainCounter]['id']);
                    if($tags_arr):
                        echo "
                            <div class='tags'>
                        ";
                        // print_r($tags_arr);
                        foreach($tags_arr as $tag_row)
                        {
                            echo "<a href=''> $tag_row[name] </a>";
                        }
                        echo "
                            </div>
                        ";
                    endif;

                    // print_r(isExistMediaForTheNewsID('newsid_videoid' , $news_row['id']));

                    $newsID_imgID_rows = isExistMediaForTheNewsID('news_img' , $all_news_rows[$mainCounter]['id']);                        
                    $count_of_img = function($array){
                        //можно было сделать и проще ))
                        return count($array);
                    };

                    if(!$newsID_imgID_rows):
                    $news_img_ghost_class['class'] = ''; // класс-флаг показывающий отсутствие контента
                    $news_img_ghost_class['icon'] = 'image.png';
                    else:
                    $news_img_ghost_class['class'] = '';
                    $news_img_ghost_class['icon'] = './data/icons/image.png';
                    endif;

                    $newsID_videoID_count = count(isExistMediaForTheNewsID('newsid_videoid' , $all_news_rows[$mainCounter]['id']));

                    if(!$newsID_videoID_count):
                    $news_video_ghost_class['class'] = ''; // класс-флаг показывающий отсутствие контента
                    $news_video_ghost_class['icon'] = 'file-earmark-play.svg';
                    else:
                    $news_video_ghost_class['class'] = '';
                    $news_video_ghost_class['icon'] = 'cinema.gif';
                    endif;

                    $news_audio = isExistMediaForTheNewsID('news_img' , $all_news_rows[$mainCounter]['id']);

                    echo "
                        <div class='multimedia-icons'>
                        <img class='$news_video_ghost_class[class]' src='$news_video_ghost_class[icon]'>
                        <span class='number-of-the-content'>$newsID_videoID_count</span>
                        <img style='display:none;' class='' src='file-earmark-music.svg'>
                        <img class='$news_img_ghost_class[class]' src='$news_img_ghost_class[icon]'>
                        <span class='number-of-the-content'>{$count_of_img($newsID_imgID_rows)}</span>
                    ";

                    echo "
                        </div>                        
                    ";

                    echo "
                    
                </div>
                <h2 class='news-title'>
                    <a href='th1nws.php?th1nwsID={$all_news_rows[$mainCounter]['id']}'>
                        {$all_news_rows[$mainCounter]['title']}
                    </a>
                </h2>
                <div class='imgs'>
                    <div class='grid-sub-container'>";
                    foreach(get_imgs_for_current_news_row($all_news_rows[$mainCounter]['id']) as $img_ro)
                    {
                        echo "
                        <div class='img-container $img_ro[comment]'>
                                <img class='to-fullscreen' src='$img_ro[path]'>
                        </div>
                        ";
                    }
                    echo "
                    </div>
                </div>
                <div class='body'><span class='themes'>";
                    foreach(get_themes_for_the_current_news_row($all_news_rows[$mainCounter]['id']) as $theme_row)
                    {
                        echo "<a href='$_SERVER[PHP_SELF]?theme_id=$theme_row[id]'> $theme_row[theme_name] </a>";
                    }
                    // echo "</div"
                echo "</span>";


                    echo mb_substr($all_news_rows[$mainCounter]['body'] , 0 , 499 , 'utf-8');
                echo "
                ... <a style='color:black;' href='th1nws.php?th1nwsID={$all_news_rows[$mainCounter]['id']}'>далее</a>
                </div>
            </div>
        ";

    }

    
    ?>
</div>
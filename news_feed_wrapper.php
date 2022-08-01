<?php 
var_dump($_GET);

function get_all_news_by()
{
    return true ; 
}

?>
<div class="news-feed-wrapper">
    <?php 
        $local_counter = 0;
        foreach(get_all_news_rows() as $rows)
        {
            // var_dump($rows);
            // echo "<br>";
            
            echo "
                <div " ;

                    if($local_counter) echo "style='border-top: 2px solid #ddd;'";

                echo  "id='news-id-{$rows['id']}' class='news-container'>
                    <div class='date-theme-tags-container'>
                        <div class='date-and-time-container'>
                            <a href='$_SERVER[PHP_SELF]'>{$rows['cdt']}</a>
                        </div>
                        <div class='themes'>";
                        foreach(get_themes_for_the_current_news_row($rows['id']) as $theme_row)
                        {
                            
                            echo "<a href='$_SERVER[PHP_SELF]?theme_id=$theme_row[id]'> $theme_row[theme_name] </a>";
                        }
                        echo "
                            </div>
                        ";

                        $tags_arr = get_tags_for_the_current_news_row($rows['id']);
                        if($tags_arr):
                            echo "
                                <div class='tags'>
                            ";
                            // print_r($tags_arr);
                            foreach($tags_arr as $tag_row)
                            {
                                echo "<a href='$_SERVER[PHP_SELF]?tag_id=$tag_row[id]'> $tag_row[name] </a>";
                            }
                            echo "
                                </div>
                            ";
                        endif;

                        // print_r(isExistMediaForTheNewsID('newsid_videoid' , $news_row['id']));

                        $newsID_imgID_rows = isExistMediaForTheNewsID('news_img' , $rows['id']);                        
                        $count_of_img = function($array){
                            //можно было сделать и проще ))
                            return count($array);
                        };

                        if(!$newsID_imgID_rows):
                        $news_img_ghost_class['class'] = 'ghost'; // класс-флаг показывающий отсутствие контента
                        $news_img_ghost_class['icon'] = 'image.png';
                        else:
                        $news_img_ghost_class['class'] = '';
                        $news_img_ghost_class['icon'] = './data/icons/image.png';
                        endif;

                        $newsID_videoID_count = count(isExistMediaForTheNewsID('newsid_videoid' , $rows['id']));

                        if(!$newsID_videoID_count):
                        $news_video_ghost_class['class'] = 'ghost'; // класс-флаг показывающий отсутствие контента
                        $news_video_ghost_class['icon'] = 'file-earmark-play.svg';
                        else:
                        $news_video_ghost_class['class'] = '';
                        $news_video_ghost_class['icon'] = 'cinema.gif';
                        endif;

                        $news_audio = isExistMediaForTheNewsID('news_img' , $rows['id']);

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
                        <a href='th1nws.php?th1nwsID={$all_news_rows['id']}'>
                            {$all_news_rows[$local_counter]['title']}
                        </a>
                    </h2>
                    <div class='imgs'>
                        <div class='grid-sub-container'>";
                        foreach(get_imgs_for_current_news_row($all_news_rows['id']) as $img_ro)
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
                    <div class='body'>
                    ";
                        // echo substr($all_news_rows['body'] , 0 , 499);
                        // echo nl2br(mb_strimwidth($all_news_rows['body'] , 0 , 499 , '...'));
                        echo mb_strimwidth($all_news_rows['body'] , 0 , 499 , '...');
                    echo "
                    ...
                    </div>
                </div>
            ";
            
            $local_counter++;
        }

    ?>

</div>
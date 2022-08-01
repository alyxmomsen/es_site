<div class="wrapper news-feed">
    <?php

    echo "

        <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
        <ol style='display:none;' class='carousel-indicators'>
            <li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>
            <li data-target='#carouselExampleIndicators' data-slide-to='1'></li>
            <a style='display:none;' class='to-archive-link' href='archive.php'>архив</a>
        </ol>
        <div class='carousel-inner'>

    ";
    $all_news_rows = get_all_news_rows();
    // print_r($all_news_rows);
    $total_news_amount = count($all_news_rows);

    for($total = 0 , $mainCounter = 0 ; $mainCounter < $total_news_amount ; )
    {



        echo "
            
            <div class='carousel-item
        ";

        if($mainCounter <= 0) echo "active";

        echo"

            '>
            
        ";



        for($innerCounter = 0 ; $innerCounter < 10 && $mainCounter < $total_news_amount ; $mainCounter++ ,  $innerCounter++ )
        {
            
            echo "
                <div " ;

                    if($innerCounter) echo "style='border-top: 2px solid #ddd;'";

                echo  "id='news-id-{$all_news_rows[$mainCounter]['id']}' class='news-container'>
                    <div class='date-theme-tags-container'>
                        <div class='date-and-time-container'>
                            <a href='$_SERVER[PHP_SELF]'>{$all_news_rows[$mainCounter]['cdt']}</a>
                        </div>
                        <div class='themes'>";
                        foreach(get_themes_for_the_current_news_row($all_news_rows[$mainCounter]['id']) as $theme_row)
                        {
                            echo "<a href='$_SERVER[PHP_SELF]?theme_id=$theme_row[id]'> $theme_row[theme_name] </a>";
                        }
                        echo "
                            </div>
                        ";

                        $tags_arr = get_tags_for_the_current_news_row($all_news_rows[$mainCounter]['id']);
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

                        $newsID_imgID_rows = isExistMediaForTheNewsID('news_img' , $all_news_rows[$mainCounter]['id']);                        
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

                        $newsID_videoID_count = count(isExistMediaForTheNewsID('newsid_videoid' , $all_news_rows[$mainCounter]['id']));

                        if(!$newsID_videoID_count):
                        $news_video_ghost_class['class'] = 'ghost'; // класс-флаг показывающий отсутствие контента
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
                    <div class='body'>
                    ";
                        echo substr($all_news_rows[$mainCounter]['body'] , 0 , 499);
                    echo "
                    ... <a style='color:#ce5a57;' href='th1nws.php?th1nwsID={$all_news_rows[$mainCounter]['id']}'>читать далее</a>
                    </div>
                </div>
            ";

        }


        echo "

            </div>
        
        ";



        
    }

    echo "
        </div>
        </div>

    ";

    foreach(get_all_news_rows() as $news_row)
    {
        
    }
    ?>
</div>
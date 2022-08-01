<?php require "db_connect.php";

//warning this is a hardcode


function getNewsForTheTHeme($theme_id)
{
    global $pdo;

    $qs = "SELECT news.* 
    from news , themes , news_theme 
    WHERE themes.id = ? 
    AND news_theme.theme_id = themes.id 
    AND news_theme.news_id = news.id";

    $statement = $pdo->prepare($qs);
    $statement->execute([$theme_id]);
    $result_arr = $statement->fetchall();
    return $result_arr;
}

function get_themes($letter = 'А')
{
    global $pdo;
    $statement = $pdo->prepare("select * from themes where theme_name like '$letter%'");
    $statement->execute();
    $rows = $statement->fetchall(PDO::FETCH_ASSOC);
    return $rows;
}

function getPhoto($theme_name , $section)
{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM images,themes, themeid_photoid WHERE images.id = themeid_photoid.photo_id AND themeid_photoid.theme_id = themes.id AND themes.theme_name = :themename AND themes.section = :section");
    $statement->execute([':themename' => $theme_name , ':section' => $section ]);
    return $statement->fetchall(PDO::FETCH_ASSOC);
}

function getPages($section , $theme)
{
    global $pdo;
    $select_statement = $pdo->prepare("SELECT * FROM pages , sections, themes , themeid_pageid , themesid_sectionid where 
    sections.section = ? and 
    themes.theme_name = ? AND
    sections.id = themesid_sectionid.section_id and 
    themesid_sectionid.theme_id = themes.id and
    pages.id = themeid_pageid.page_id and 
    themeid_pageid.theme_id = themes.id");
    $select_statement->execute([$section , $theme]);
    return $select_statement->fetchall(PDO::FETCH_ASSOC);
}


// return video pathes collection
function getVideo($themeID)
{
    global $pdo;
    $select_statement = $pdo->prepare("SELECT * FROM video_files , themes , themeid_videoid 
    where themes.id = ? 
    and video_files.id = themeid_videoid.video_id 
    and themeid_videoid.theme_id = themes.id");
    $select_statement->execute([$themeID]);
    return $select_statement->fetchall(PDO::FETCH_ASSOC);
}

function getAudio($section , $theme)
{
    global $pdo;
    $select_statement = $pdo->prepare("SELECT * FROM audio_files , sections, themes , themeid_audioid , themesid_sectionid where 
    sections.section = ? and 
    themes.theme_name = ? AND
    sections.id = themesid_sectionid.section_id and 
    themesid_sectionid.theme_id = themes.id and
    audio_files.id = themeid_audioid.audio_id and 
    themeid_audioid.theme_id = themes.id");
    $select_statement->execute([$section , $theme]);
    return $select_statement->fetchall(PDO::FETCH_ASSOC);
}

function getDocs($section , $theme)
{
    global $pdo;
    $select_statement = $pdo->prepare("SELECT * FROM documents , sections, themes , themeid_documentid , themesid_sectionid where 
    sections.section = ? and 
    themes.theme_name = ? AND
    sections.id = themesid_sectionid.section_id and 
    themesid_sectionid.theme_id = themes.id and
    documents.id = themeid_documentid.document_id and 
    themeid_documentid.theme_id = themes.id");
    $select_statement->execute([$section , $theme]);
    return $select_statement->fetchall(PDO::FETCH_ASSOC);
}

function getArticles($section , $theme)
{
    global $pdo;
    $select_statement = $pdo->prepare("SELECT * FROM articles , sections, themes , articleid_themeid , themesid_sectionid where 
    sections.section = ? and 
    themes.theme_name = ? AND
    sections.id = themesid_sectionid.section_id and 
    themesid_sectionid.theme_id = themes.id and
    articles.id = articleid_themeid.article_id and 
    articleid_themeid.theme_id = themes.id");
    $select_statement->execute([$section , $theme]);
    return $select_statement->fetchall(PDO::FETCH_ASSOC);
}


function get_number_of_articles($theme_id) {
    global $pdo;
    $query_string = "SELECT news.* FROM news , themes , news_theme WHERE themes.id = ? AND themes.id = news_theme.theme_id AND news_theme.news_id = news.id;";
    $statement = $pdo->prepare($query_string);
    $statement->execute([$theme_id]);
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return count($result);
}

function themePrinter()
{
    // function 
    // определение функции внутри функции
    function get_themeLetter_getParameter()
    {
        if(isset($_GET['themeLetter'])):
            return $_GET['themeLetter'];
        else:
            return 'А';
        endif;
    }
    
    echo "
        <div id='scroll-id-named-theme-lol' class='themes flex-container'>
    ";
    
    foreach(get_themes(get_themeLetter_getParameter()) as $theme_row)
    {
        // print_r($theme_row);

        if($theme_row['reserve'] == true):
            continue;
        endif;
        // print_r($theme_row);
        echo "
            <div class='theme flex-item
        ";
        
        if($theme_row['disabled'] === 'false'):
            echo " visper";
        endif;
        echo " priority-" . $theme_row['priority'];
        echo "
            '>
        ";
        
        // далее может быть различный стиль синтаксиса !!!!!!
        echo "<h1 class='theme-name'><a ";
        
        if($theme_row['disabled'] === 'false'):

            echo "
                '>$theme_row[theme_name]
            ";

        else:

            /*echo "href='news.php?theme_id=$theme_row[id]'>$theme_row[theme_name]";*/
            echo "href='http://egorsukhachev.com/by_theme_page.php?themeID=$theme_row[id]'>$theme_row[theme_name]";

        endif;
        
        echo "</a>"; 
        echo "</h1>";
        $number_of_art = get_number_of_articles($theme_row['id']); 
        
        if($number_of_art):
            echo "<span>" . $number_of_art . "</span>";
        endif;
        
        
        $news_number = count(getNewsForTheTHeme($theme_row['id']));
        $videoRows = getVideo($theme_row['id']);
        // if($news_number) echo "<span class='news-amount'>Новости: $news_number</span><br>";
        // if(count($videoRows)) echo "<span class=''>видео: " . count($videoRows) . "</span><br>";
        echo "</div>";
    }
    
    echo '
        </div>
    ';
}

function titleGenerator($theme_name = false)
{
    if($_GET['section']==='about') return 'обо мне';
    else return 'мир вокруг меня';
}


// functions for thetheme.php only

function themegetter($themeId)
{
    global $pdo;
    $qstring = "select themes.theme_name from themes where themes.id = ? limit 1";
    $theme_name_select_statement = $pdo->prepare($qstring);
    $theme_name_select_statement->execute([$themeId]);
    $result_arr = $theme_name_select_statement->fetch(PDO::FETCH_ASSOC);
    return $result_arr['theme_name'];
}

function fullThemePrinter($section , $theme)
{    
    $article_arr = getArticles($section , themegetter($theme));
    $page_arr = getPages($section , themegetter($theme));
    $video_arr = getVideo($section , themegetter($theme));
    $audio_arr = getAudio($section , themegetter($theme));
    $docs_arr = getDocs($section , themegetter($theme));
    $photo_arr = getPhoto(themegetter($theme) , $section);
    
    if(count($photo_arr)): 
        echo "<li style='font-size:1.6em;text-align: center; list-style-type: none;' class='photo'><a href=landing.php?theme=$theme&tag=#>" . count($photo_arr) . " фото</a></li>";
        echo <<<htmlBlock
        <div id='' class='flex-container'>
htmlBlock;
        foreach($photo_arr as $row)
        {
            echo "<div class='flex-item'><img class='' src='$row[path]'></div>";
        }
        echo '</div>';
    endif;
    if(count($video_arr)) echo "<li class='video'><a href=video.php?theme=$theme&tag=#>video: " . count($video_arr) . "</a></li>";
    if(count($audio_arr)) echo "<li class='audio'><a href=audio.php?theme=$theme&tag=#>audio: " . count($audio_arr) . "</a></li>";
    if(count($docs_arr)) echo "<li class='audio'><a href=docs.php?theme=$theme&tag=#>docs: " . count($docs_arr) . "</a></li>";
    if(count($page_arr)) echo "<li class='pages'><a href=about.php?theme=$theme&tag=#>pages: " . count($page_arr) . "</a></li>";
    if(count($article_arr)) echo "<li class='articles'><a href=articles.php?theme=$theme&tag=#>articles: " . count($article_arr) . "</a></li>";
}


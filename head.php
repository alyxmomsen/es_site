<?php

require 'sandbox/sandbox5.php' ;

// require_once 'db_connect.php';
global $pdo;

require_once 'modules/class_getCoronaData.php';
$gcd = new GetCoronaData($pdo);

require 'modules/class_getMeteoData.php';
$gmd = new getMeteoData();
// exit();

// require "db_connect.php";

//require "alyx_php_functions/quotes_functions.php";

require 'currence.php';
require 'getWeather.php';

require 'covid_stat.php';



function get_covid_stats()
{
    global $pdo;
    $qs = "SELECT * FROM covid_data ORDER by cdt DESC LIMIT 1";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result[0];
}

?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
</style>
<div id="particles-js" class="main-head">
    <div id="mainheader" class="header">
        <div class="quote">

            <?php
                require 'alyx_php_functions/print_quotes_slider_with_qoutes_from_db.php';
            ?>

        </div>

        <div class='covid-stats-display'>
            <div class='stat link-to-source'>
                <div>
                    <?php global $gc19d ; ?>
                    <span><?php echo 'на ' . $gc19d->dateData() ; ?></span>
                </div>
                <div><span style="">выявленно: </span>
                    <span style="">
                        <?php 
                        //echo $gcd->sickChange
                        
                        echo $gc19d->detectedData() ;
                        ?>
                    </span>
                </div>
<!--                <div><span style="">выявленно: </span><span style="">37141</span></div>-->
                <div><span style="">умерло: </span>
                    <span style="">
                        <?php
                        echo $gc19d->diedData() ;
                        // $gcd->diedChange 
                        ?>
                    </span>
                </div>
<!--                <div><span style="">умерло: </span><span style="">1064</span></div>-->
            </div>
			<a class="covid-stats-link" target='_blank' style='' href='https://стопкоронавирус.рф/information/'>стопкоронавирус.рф</a>
        </div>

        <div class='currence-rate'>
            <?php $dataFromDBcontainedCurrenceData = getCurrentRateFromDB('uero');// косяк в наименовании таблицы ?> 
            <div class='euro'>
                <span class='the-currence'>euro: </span>
                <span class='buy'>86,31</span>
                <span class='separator'>|</span>
                <span class='sale'>89,33</span>
            </div>
            <?php $dataFromDBcontainedCurrenceData = getCurrentRateFromDB('usd'); ?>
            <div class='usd'>
                <span class='the-currence'>usd: </span>
                <span class='sale'>75,92</span>
                <span class='separator'>|</span>
                <span class='buy'>78,93</span>
            </div>
        </div>
        <!-- weather section -->
        <div class='weather'>
            <span class='caption'>Москвa: </span><span class='data'><?= $gmd->getDeg() ?></span><!-- <\?= $gmd->getDeg() ?> -->
            <div class='icon-inner-container'>
            <?php
            include 'data/svg/weather_svg.php' ;
            //  require 'another_modules/weather_show_box_module.php'; 
             ?>
             </div>
             <a target='_blank' style='' href='https://meteoinfo.ru'> meteoinfo.ru</a>
        </div>
        <!-- END weather section -->
        <div class="description">
            <p class="description ru">Не сможешь- поможем,<br>не захочешь- накажем.</p>
        </div>
    </div>
    <div class="brand-name-letters flex-container">
        <span class="letter flex-item">е</span>
        <span class="letter flex-item">г</span>
        <span class="letter flex-item">о</span>
        <span class="letter flex-item">р</span>
        <span class="letter flex-item logo paralax"><a href="index.php"></a></span>
        <span class="letter flex-item">с</span>
        <span class="letter flex-item">у</span>
        <span class="letter flex-item">х</span>
        <span class="letter flex-item">а</span>
        <span class="letter flex-item">ч</span>
        <span class="letter flex-item">ё</span>
        <span class="letter flex-item">в</span>
    </div>
    <!-- <div class='link-to-themes'>
        <div class="flex-item container">
            <a href='themes.php#scroll-id-named-theme-lol'>темы</a>
        </div>
        <div class="flex-item container">
            <a href="my_profile.php">обо мне</a>
        </div>
        <div class="flex-item container">
            <a href='#'>люди</a>
        </div>
    </div> -->
    <?php include 'modules/module_menuButton.php'; ?>
</div>
<style>

    @keyframes text_shifting {
        from {

        }

        to {

        }
    }

    #mainheader .quote i {
        display: block;
        text-align: right;
        padding-right: 9px;
        font-size: .8em;
        /* font-style: inherit; */
        font-family: 'Playfair Display', serif;
        font-style: italic;
    }



</style>


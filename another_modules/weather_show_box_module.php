<?php 

// require 'expDir/temp_file.php'; 

?>
<?php 
// echo __FILE__;
// directioryNewPath();

?>
<div class="showbox">
    <!-- <div class="title">
        <p class="heading">Animated Weather Icons</p>
        <p>Inspired by awesome weather icons at <a href="http://www.shutterstock.com/pic.mhtml?id=57368320" target="_blank">shutterstock.com</a>.</p>
    </div> -->
    <div class="div-icons">
        <!--       Sunny -->
        <?php

        // include 'another_modules/weather_icon_patterns/sunny_pat.php'; 
        //  <!--       Partly Cloudy -->
        // include 'another_modules/weather_icon_patterns/partly_cloudy_pat.php?'; 
        // <!--       Cloudy -->
        include 'another_modules/weather_icon_patterns/cloudy_pat.php'; 
        // <!--     Windy -->
        // include 'another_modules/weather_icon_patterns/windy_pat.php?'; 
        // <!--       Rainy -->
        // include 'another_modules/weather_icon_patterns/rainy_pat.php?'; 
        // <!--     Sunshower -->
        // include 'another_modules/weather_icon_patterns/sunshower_pat.php?';
        // <!--     Snowy -->
        // include 'another_modules/weather_icon_patterns/snowy_pat.php?'; 
        // <!--     Rainbow -->
        // include 'another_modules/weather_icon_patterns/rainbow_pat.php?'; 

        ?>
    </div>
    <!-- <div class="credit">
        <p>Color palettes <a href="http://www.colourlovers.com/palette/1473/Ocean_Five" target="_blank">Ocean Five</a> and <a href="http://www.colourlovers.com/palette/848743/(%E2%97%95_%E2%80%9D_%E2%97%95)" target="_blank">(◕ ” ◕)</a> at <a href="http://www.colourlovers.com/"
            target="_blank">colourlovers.com</a>.</p>
    </div> -->
    <style>

    @import url(https://fonts.googleapis.com/css?family=Poppins);
        /* body {
        background-color: #222;
        min-width: 500px;
        font-family: 'Poppins', sans-serif;
        color: #CCC;
        }
        body a {
        text-decoration: none;
        color: #00A0B0;
        } */
        .showbox {
        /* position: absolute; */
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 21px;
        /* display: none; */
        width: 33px;
        margin: 0 auto;
        }
        .title {
        position: absolute;
        width: 100%;
        margin: 10px 0 0 0;
        text-align: center;
        }
        .title .heading {
        font-size: 32px;
        margin: 0px;
        }
        .credit {
        position: absolute;
        width: 100%;
        text-align: center;
        bottom: 0;
        margin: 0 0 10px 0;
        }
        .div-icons {
        /* position: absolute; */
        display: block;
        width: 100% ; 
        text-align: center;
        top: 55%;
        left: 50%;
        height: 100%;
        transform: translate(0%, -16%);
        }
        .icon {
        /* margin: 15px 25px; */
        width: 100%;
        /* height: 100%; */
        }
        .sunny-body path {
        fill: yellow;
        }
        .sunny-long-ray {
        transform-origin: 50% 50%;
        animation: spin 9s linear infinite;
        }
        .sunny-long-ray path {
        fill: yellow;
        }
        .sunny-short-ray {
        transform-origin: 50% 50%;
        animation: spin 9s linear infinite;
        }
        .sunny-short-ray path {
        fill: yellow;
        }
        .cloud-offset path {
        fill: #222;
        }
        .main-cloud path {
        fill: #00b2eb;
        }
        .small-cloud path {
        fill: #00b2eb;
        animation: flyby 6s linear infinite;
        }
        .rain-cloud path {
        fill: #00b2eb;
        /* animation: rain-cloud-color 6s ease infinite; */
        }
        .rain-drops path {
        fill: #00b2eb;
        opacity: 0;
        }
        .rain-drops path:nth-child(1) {
        animation: rain-drop 1.2s linear infinite;
        }
        .rain-drops path:nth-child(2) {
        animation: rain-drop 1.2s linear infinite 0.4s;
        }
        .rain-drops path:nth-child(3) {
        animation: rain-drop 1.2s linear infinite 0.8s;
        }
        .snow-cloud path {
        fill: #CCC;
        }
        .snowflakes path {
        transform-origin: 50% 50%;
        fill: #CCC;
        opacity: 0;
        }
        .snowflakes path:nth-child(1) {
        animation: snow-drop 1.2s linear infinite;
        }
        .snowflakes path:nth-child(2) {
        animation: snow-drop 1.2s linear infinite 0.4s;
        }
        .snowflakes path:nth-child(3) {
        animation: snow-drop 1.2s linear infinite 0.8s;
        }
        .wind-string path {
        stroke: #CCC;
        stroke-linecap: round;
        stroke-width: 7px;
        animation: wind-blow 3s linear infinite;
        }
        .rainbows path {
        stroke-linecap: round;
        animation: rainbow 4.5s linear infinite;
        }
        .rainbows path:nth-child(1) {
        stroke: #BD1E52;
        stroke-width: 6px;
        }
        .rainbows path:nth-child(2) {
        stroke: #E88024;
        stroke-width: 8px;
        }
        .rainbows path:nth-child(3) {
        stroke: #F8CB10;
        stroke-width: 6px;
        }
        .rainbows path:nth-child(4) {
        stroke: #899C3B;
        stroke-width: 14px;
        }
        @keyframes spin {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
        }
        @keyframes flyby {
        0% {
            -webkit-transform: translate(0px, 0px);
            transform: translate(0px, 0px);
            opacity: 0;
        }
        30% {
            -webkit-transform: translate(39px, 0px);
            transform: translate(39px, 0px);
            opacity: 1;
        }
        70% {
            -webkit-transform: translate(91px, 0px);
            transform: translate(91px, 0px);
            opacity: 1;
        }
        100% {
            -webkit-transform: translate(130px, 0px);
            transform: translate(130px, 0px);
            opacity: 0;
        }
        }
        @keyframes rain-cloud-color {
        100%, 0% {
            fill: #666;
        }
        20% {
            fill: #555;
        }
        21.5% {
            fill: #999;
        }
        25% {
            fill: #555;
        }
        27.5% {
            fill: #999;
        }
        30% {
            fill: #555;
        }
        40% {
            fill: #999;
        }
        90% {
            fill: #555;
        }
        }
        @keyframes rain-drop {
        0% {
            -webkit-transform: translate(0px, -60px);
            transform: translate(0px, -60px);
            opacity: 0;
        }
        30% {
            -webkit-transform: translate(0px, -36px);
            transform: translate(0px, -36px);
            opacity: 1;
        }
        80% {
            -webkit-transform: translate(0px, 4px);
            transform: translate(0px, 4px);
            opacity: 1;
        }
        100% {
            -webkit-transform: translate(0px, 20px);
            transform: translate(0px, 20px);
            opacity: 0;
        }
        }
        @keyframes snow-drop {
        0% {
            -webkit-transform: translate(0px, -60px) rotate(0deg);
            opacity: 0;
        }
        30% {
            -webkit-transform: translate(0px, -36px) rotate(108deg);
            opacity: 1;
        }
        80% {
            -webkit-transform: translate(0px, 4px) rotate(288deg);
            opacity: 1;
        }
        100% {
            -webkit-transform: translate(0px, 20px) rotate(360deg);
            opacity: 0;
        }
        }
        @keyframes wind-blow {
        0% {
            stroke-dasharray: 5 300;
            stroke-dashoffset: -200;
            opacity: 1;
        }
        50% {
            stroke-dasharray: 300 300;
            stroke-dashoffset: -100;
            opacity: 1;
        }
        90% {
            stroke-dasharray: 50 300;
            stroke-dashoffset: -20;
            opacity: 0.7;
        }
        100% {
            stroke-dasharray: 20 300;
            stroke-dashoffset: 0;
            opacity: 0.2;
        }
        }
        @keyframes rainbow {
        0% {
            stroke-dasharray: 10 210;
            stroke-dashoffset: 0;
            opacity: 0;
        }
        30% {
            stroke-dasharray: 210 210;
            stroke-dashoffset: 0;
            opacity: 1;
        }
        70% {
            stroke-dasharray: 210 210;
            stroke-dashoffset: 0;
            opacity: 1;
        }
        100% {
            stroke-dasharray: 0 210;
            stroke-dashoffset: -210;
            opacity: 0;
        }
        }


    </style>
</div>
<?php

require 'db_connect.php' ;

function getWeather()
{
    

    $src = file_get_contents('https://meteoinfo.ru/pogoda/russia/moscow-area/moscow') ;

    $pathern = '~Температура воздуха, &deg;C</td><td width="40%"  style="border-bottom: 1px solid #D3D3D3;"  align="center">(?<temperature_now>\S?\d?\d\.?\d?\d?)~';

    // preg_match('~Температура воздуха~', $src , $result_arr);

    preg_match_all($pathern , $src , $result_arr);

    // print_r($result_arr);

    // echo $result_arr['temperature_now'][0];

    return $result_arr['temperature_now'][0];

}


function insertNowWeatherIntoDB()
{
    global $pdo ;

    //таблица в базе именована безграмотно
    $qs = "insert ignore into now_wheter (temperature) values (?)";
    $statement = $pdo->prepare($qs);
    $statement->execute([getWeather()]);
}

function getWeatherFromDB()
{
    global $pdo ;

    //таблица в базе именована безграмотно
    $qs = "select * from now_wheter ORDER by cdt DESC LIMIT 6";
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result[0];

}

insertNowWeatherIntoDB();

// print_r(getWeatherFromDB());

?>
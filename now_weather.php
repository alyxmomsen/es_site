<?php

require "db_connect.php";

function get_weather()
{
    $weather_site_descriptor = curl_init();
    curl_setopt($weather_site_descriptor , CURLOPT_URL , 'https://meteoinfo.ru/pogoda/russia/moscow-area/moscow');
    // curl_setopt($weather_site_descriptor , CURLOPT_SSL_VERIFYPEER , false);
    curl_setopt($weather_site_descriptor , CURLOPT_RETURNTRANSFER , true);
    $result = 
    curl_exec($weather_site_descriptor);
    // echo $result;
    $reg_exp = '~Температура воздуха, &deg;C</td><td width="40%"  style="border-bottom: 1px solid #D3D3D3;"  align="center">(?<temperature>\S\d*\S?\d?)</td></tr>~';
    preg_match_all($reg_exp , $result , $site_data);

    return $site_data['temperature'][0];

}

function send_data_to_bd()
{
    global $pdo;
    $qs = "insert into now_wheter ( temperature ) VALUES (?)";
    $statement = $pdo->prepare($qs);
    $statement->execute([get_weather()]); 
}

send_data_to_bd();

// print_r(get_weather());


?>
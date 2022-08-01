<?php 

require "db_connect.php";


function getSiteCode()
{

    global $pdo;
    setlocale (LC_ALL, "ru_RU.UTF8");
    $curlinit = curl_init();
    curl_setopt($curlinit , CURLOPT_URL , 'https://коронавирус.рф/');
    // curl_setopt($curlinit , CURLOPT_SSL_VERIFYPEER , false);
    curl_setopt($curlinit , CURLOPT_RETURNTRANSFER , true);
    // $theCode = file_get_contents('https://коронавирус.рф/');
    $theCode = curl_exec($curlinit);
    return $theCode;
}

function get_covid_data()
{
    global $pdo;
    
    $theString = getSiteCode();
    // echo $theString;
    // echo 'hello';   
    $to_parse_string = '<div><p>4 086 090 </p><span class="change"><strong>+14 207 </strong> сегодня</span> <span class="title">заболевших</span></div><div><p>3 607 036</p><span class="change"><strong>+13 935</strong> сегодня</span> <span class="title">выздоровевших</span></div><div><p>80 520</p><span class="change"><strong>+394</strong> сегодня</span> <span class="title">умерших</span></div></div>';

    ''; // for exemple string
    // $gig_exp = '~(?<total_dead>\s?\d\d\s?\d\d\d\s?\s?)</p><span class="change"><strong>\S?(?<today_dead>\d?\d?\d?)</strong> сегодня</span> <span class="title">умерших</span></div></div>~i';
    $gig_exp = '~<div><p>(?<total_detected>\d\s\d\d\d\s?\d\d\d\s?)</p><span class="change"><strong>\S?(?<today_detected>\d?\d?\s?\d?\d?\d)\s?</strong> сегодня</span> <span class="title">заболевших</span></div><div><p>(?<total_healed>\d\s?\d\d\d\s?\d\d\d)</p><span class="change"><strong>\S?(?<today_healed>\d?\d?\s?\d?\d?\d?\s?)</strong> сегодня</span> <span class="title">выздоровевших</span></div><div><p>(?<total_dead>\d\d\s?\d\d\d\s?\s?)</p><span class="change"><strong>\S?(?<today_dead>\d?\d?\d?)</strong> сегодня</span> <span class="title">умерших</span></div></div>~i';
    preg_match_all($gig_exp , $theString , $final_result);
    // var_dump($final_result); 
    
    $all_sickers = explode(' ' , trim($final_result['total_detected'][0]));
    $all_sickers = implode('' , $all_sickers);
    $today_have_sicked = explode(' ' , trim($final_result['today_detected'][0]));
    $today_have_sicked = implode('' , $today_have_sicked);
    $all_rebooted = explode(' ' , trim($final_result['total_healed'][0]));
    $all_rebooted = implode('' , $all_rebooted);
    $today_rebooted = explode(' ' , trim($final_result['today_healed'][0]));
    $today_rebooted = implode('' , $today_rebooted);
    $all_deads = explode(' ' , trim($final_result['total_dead'][0]));
    $all_deads = implode('' , $all_deads);
    $today_dead = explode(' ' , trim($final_result['today_dead'][0]));
    $today_dead = implode('' , $today_dead);

    // echo '<pre>';
    // var_dump($all_sickers);
    // var_dump($today_have_sicked);
    // var_dump($all_rebooted);
    // var_dump($today_rebooted);
    // var_dump($all_deads);
    // var_dump($today_dead);
    // echo '<pre>';

    $covid_stat_array = array(
        'all_sickers' => $all_sickers , 
        'today_have_sicked' => $today_have_sicked , 
        'all_rebooted' => $all_rebooted , 
        'today_rebooted' => $today_rebooted , 
        'all_deads' => $all_deads , 
        'today_dead' => $today_dead
    );

    $qs = 'insert ignore into covid_data 
        (all_infected , today_infected , total_cure , today_was_cured , total_dead , today_dead )
        values (? , ? , ? , ? , ? , ?)' 
    ;

    $statement = $pdo->prepare($qs);
    $statement->execute([
        $covid_stat_array['all_sickers'] , 
        $covid_stat_array['today_have_sicked'] , 
        $covid_stat_array['all_rebooted'] , 
        $covid_stat_array['today_rebooted'] ,
        $covid_stat_array['all_deads'] ,
        $covid_stat_array['today_dead'] ,
    ]);

    // print_r($covid_stat_array);

}

get_covid_data();



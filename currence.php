<?php

require 'db_connect.php';


function getEuroUsdCurrenceRateFromInteza()
{
    $bank_of_china_url = 'https://www.bankofchina.com/finadata/brhdatas/moscow.html';
    $inteza_bank_url = 'https://www.bancaintesa.ru/';
    $curlinit = curl_init();
    curl_setopt($curlinit , CURLOPT_URL , $inteza_bank_url);
    curl_setopt($curlinit , CURLOPT_SSL_VERIFYPEER , false);
    curl_setopt($curlinit , CURLOPT_RETURNTRANSFER , true);
    $result = curl_exec($curlinit);
    // $result = file_get_contents($inteza_bank_url);
    // echo $result;
    // echo 'ksjdhflkajhdsflkajshdlfkajshdflkjashdfs dla jflasjdhf laksdjh flkasdj hf';
    // echo 'hello';
    $for_exemple_data = '<td class="exchange-table__heading">Продажа</td>
    </tr>
                                                            <tr>
            <td>USD</td>
            <td>71,50</td>
            <td>76,50</td>
        </tr>
                                                                                                                                    <tr>
            <td>EUR</td>
            <td>87,00</td>
            <td>92,00</td>
        </tr>'; //for exemple

    $reg_exp = '~<td>USD</td>(\s?)*<td>(?<usd_buy>\d?\d?\S?\d?\d?)</td>(\s?)*<td>(?<usd_sale>\d?\d?\S?\d?\d?)</td>(\s?)*</tr>(\s?)*<tr>(\s?)*<td>EUR</td>(\s?)*<td>(?<euro_sale>\d?\d?\S?\d?\d?)</td>(\s?)*<td>(?<euro_buy>\d?\d?\S?\d?\d?)</td>~i';

    preg_match_all($reg_exp , $result , $result_matches);

    // echo '<pre>';
    // print_r($result_matches);
    // echo '</pre>';

    $result_matches['usd_buy'] = implode('.' , explode(',' , $result_matches['usd_buy'][0]));
    $result_matches['usd_sale'] = implode('.' , explode(',' , $result_matches['usd_sale'][0]));
    $result_matches['euro_buy'] = implode('.' , explode(',' , $result_matches['euro_buy'][0]));
    $result_matches['euro_sale'] = implode('.' , explode(',' , $result_matches['euro_sale'][0]));

    // print_r($result_matches);

    return $result_matches;
}

function insertThePriceAboutrmbCurrence()
{
    global $pdo;
    $qs = 'INSERT into currence_rmb (buy_for_ru , sale_for_ru) VALUES ( :buy , :sale)';

}

function insertTheUsdRateIntoDb()
{
    $currency_price_arr = getEuroUsdCurrenceRateFromInteza();

    // var_dump($currency_price_arr);
    global $pdo;
    $qs = 'INSERT into rate_usd_rur_by_inteza (buy , sale) VALUES (? , ?)';
    $statement = $pdo->prepare($qs);
    // $statement->execute([':buy' => $currency_price_arr['usd_buy'] , ':sale' => $currency_price_arr['usd_sale']]);
    $statement->execute([$currency_price_arr['usd_buy'] , $currency_price_arr['usd_sale']]);
}

function insertTheEuroRateIntoDb()
{
    $currency_price_arr = getEuroUsdCurrenceRateFromInteza();

    // var_dump($currency_price_arr);
    global $pdo;
    $qs = 'INSERT into rate_uero_rur_by_inteza (buy , sale) VALUES (? , ?)'; // с ошибкой наименовал таблицу ))
    $statement = $pdo->prepare($qs);
    // $statement->execute([':buy' => $currency_price_arr['usd_buy'] , ':sale' => $currency_price_arr['usd_sale']]);
    $statement->execute([$currency_price_arr['euro_buy'] , $currency_price_arr['euro_sale']]);
}

function getUSDCurrentRateFromDB()
{
    global $pdo;
    $qs = 'SELECT * FROM rate_usd_rur_by_inteza order BY cdt DESC LIMIT 1';
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    return $result;
}

function getCurrentRateFromDB($currency)
{
    global $pdo;
    $qs = 'SELECT * FROM rate_' . $currency .'_rur_by_inteza order BY cdt DESC LIMIT 1';
    $statement = $pdo->prepare($qs);
    $statement->execute();
    $result = $statement->fetchall(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // print_r($result);
    // echo '</pre>';
    return $result[0];
}


// insertThePriceAboutRmbCurrence();  

// getEuroUsdCurrenceRateFromInteza();

insertTheUsdRateIntoDb();

insertTheEuroRateIntoDb();

?>
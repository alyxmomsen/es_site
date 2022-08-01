<?php

// $data =  file_get_contents('https://meteoinfo.ru/');

// $result;


// preg_match_all('~<span class="temp_obs_small">(?<data>\d\d\D\d)&deg;</span>~' , $data , $result);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// echo($data);


class getMeteoData {

    private $regExp = [];
    //
    private $deg = '';
    private $src = 'https://meteoinfo.ru/';
    private $srcResult = '';

    private $arr = [];

    function __construct() {

//        $this->regExp[] = '~<td class="obs_small_txt_2">(?<data>(\d)?\d\D(\d)?)(.)?<span class="obs_small_txt_3">~';
        $this->regExp[] = '~<span class="temp_obs_small">(?<data>(\d)?\d\D(\d)?)&deg;</span>~';
        $this->regExp[] = '~<span class="temp_obs_small">(?<data>\d\d(\.)?(\d)?)(.)?(.)?(.)?(.)?(.)?</span>~';
        $this->regExp[] = '~<span class="temp_obs_small">(?<data>\d(\d)?(\.)?(\d)?)&deg;</span>~';
        $this->regExp[] = '~<td class="obs_small_txt_2">(?<data>(\D)?\d(\d)?(\.)?(\d)?(\d)?) <span class="obs_small_txt_3">~'; /*(\D)?\d(\D)?(\d)?(\d)?(\D)?*/


    }

    function getDeg() {




        if(!$this->arr){

            $this->srcResult = file_get_contents($this->src);

            foreach($this->regExp as $item) {
                preg_match_all( $item , $this->srcResult , $this->arr );
                if(isset($this->arr['data'][0])):
                    $this->deg = $this->arr['data'][0];
                    break;
                endif;

            }


            // echo '<pre>';
            // var_dump($this->arr);
            if($this->deg) {
                return $this->deg;
            }
            else return '?' ;
            // $this->deg = $this->arr['data'][0];
            // print_r($this->deg);
            // echo '</pre>';
        }
        else {
            $this->deg = $this->arr['data'][0];
            return $this->deg;
        }


    }

}

$gmd = new getMeteoData();
echo $gmd->getDeg();
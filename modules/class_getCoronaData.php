<?php

class GetCoronaData {

    public $date = '';

    public $sickChange ;

    public $diedChange ;

    protected $days = [
        'октября' => '10' ,
        'ноября' => '11' , 
        'декабря' => '12'
    ];

    protected $pdo ;
//<cv-stats-virus :stats-data=\'{"sick":"8 168 305","sickChange":"\+37 141","healed":"7 117 060","healedChange":"\+25 453","died":"228 453 ","diedChange":"\+1 064","vaccineFirst":"53 511 786","vaccineSecond":"49 161 150"}
    function __construct($pdo) {
//        echo 'hello';
        $this->pdo = $pdo ;
        $arr = [];
        $pattern = '~<small>По состоянию на (?<date>(\d)?\d .* (\d)?\d:\d\d)</small>(\D)*</h1>(\D)*</div>(\D)*(.)*cv-stats-virus :stats-data=\'{"sick":"(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?","sickChange":"(\+)?(?<sickChange>(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?)","healed":"(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?","healedChange":"(\+)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?","died":"(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)? ","diedChange":"(\+)?(?<diedChange>(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?(\D)?(\d)?(\d)?(\d)?)","vaccineFirst~';
        $sickChangePattern = '~"sickChange":"(\+)?(?<sickChange>(\d)?(\d)?\D?(\d)?(\d)?(\d)?)(\D)?"~'; //sickChange":"+35 660 "
        $diedChangePattern = '~diedChange":"\+(?<diedChange>1[\\\\]u00a0240)"~';
        $datePattern = '~\<small\>По состоянию на (?<date>(\d)?\d\D?октября) 11:00\<\/small\>~';

        $html = file_get_contents('https://xn--80aesfpebagmfblc0a.xn--p1ai/information/');
//        echo $html;
        (preg_match_all( $sickChangePattern , $html , $arr));
        $this->sickChange = preg_replace('/[ ]/' , '' , $arr['sickChange'][0]);
        echo '<div hidden>' ;
        var_dump(preg_match_all( $diedChangePattern , $html , $arr)) ;
        
        var_dump($arr);
        echo '</div>' ;
        $this->diedChange = preg_replace('/[ ]/' , '' , $arr['diedChange'][0]);
        $this->diedChange = preg_replace('/u00a0/' , '' , $this->diedChange);
        $this->diedChange = preg_replace("~[\\\\]~" , '' , $this->diedChange);
        preg_match_all( $datePattern , $html , $arr);
//        echo '<br>' . $arr['date'][0];
//        echo '</pre>';
        $this->date =  explode(' ' , trim($arr['date'][0]));
        $newDate = new DateTime();
        $newDate->setDate('2021' , $this->days[$this->date[1]] , $this->date[0]);
        $this->date = $newDate->format('Y.m.d') ;

//        echo '<br>' . $theDate;
//        var_dump($arr);
    }

}

?>


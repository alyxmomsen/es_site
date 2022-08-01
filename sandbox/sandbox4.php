<?php 
// phpinfo();

// require_once '../db_connect.php' ;
$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
// global $pdo ;

// cv-stats-virus :stats-data=

class getCovidData {


    protected $pdo = NULL ;

    protected $html = 'https://xn--80aesfpebagmfblc0a.xn--p1ai/information/' ; 

    protected $diedregexpes = array() ;
    protected $detectedregexpes = array() ;
    protected $dateregexpes = array() ;

    protected $diedMatches = array() ;
    protected $detectedMatches = array();
    protected $dateMatches = array() ;
    // protected $detectedMatches = array() ;

    // protected $detectedMatches = array() ;


    function __construct ($pdo) {

        $this->pdo = $pdo ;

    }

    function getDateData () {

        $htmlContent = file_get_contents($this->html) ; 

        // var_dump($this->html);

        // echo $htmlContent ;

        $this->dateMatches = array() ; 

        $this->dateregexpes = [ 
            "~(?<data>cv-stats-virus :stats-dat=)~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" , 
            "~cv-stats-tooltip>(.)*\n(.)*\n(.)*По состоянию на (?<data>(\d)?\d(.)*(\d)?\d:\d\d)~" , 
            "~(?<data>cv-stats-virus :sats-data=)~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" 
        ] ; 

        foreach($this->dateregexpes as $item) {

            preg_match_all($item , $htmlContent , $this->dateMatches);
            if($this->dateMatches['data']) {
                echo '<br>chek 1' ;
                return $this->dateMatches['data'] ;
            }
            else {
                echo '<br>chek 0' ;
            }
            
        }

        return 0 ;
    }

    function getDiedData () {

        $htmlContent = file_get_contents($this->html) ; 

        $this->diedMatches = array() ; 

        $this->diedregexpes = [ 
            "~(?<data>cv-stats-virus :stats-dat=)~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" , 
            "~cv-stats-virus :stats-data=(.)*\"diedChange\":\"\D(?<data>(\d)?\d\\\\u00a0\d\d\d)\"~" , 
            "~cv-stats-virus :stats-data=(.)*\"diedChange\":\"\D(?<data>(\d)?\d(\D?)\d\d\d)\"~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" 
        ] ; 

        foreach($this->diedregexpes as $item) {

            preg_match_all($item , $htmlContent , $this->diedMatches);
            if($this->diedMatches['data']) {
                echo '<br>chek 1' ;
                return $this->diedMatches['data'] ;
            }
            else {
                echo '<br>chek 0' ;
            }
            
        }

        return 0 ;
    }


    function getDetectedData () {

        $htmlContent = file_get_contents($this->html) ; 

        $this->detectedMatches = array() ; 

        $this->detectedregexpes = [ 
            "~(?<data>cv-stats-virus :stats-dat=)~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" , 
            "~cv-stats-virus :stats-data=(.*)\"sickChange\":\"\+(?<data>(\d)?(\d)?(\D)?(\d)?(\d)?(\d))(\D)?\"~" , 
            "~(?<data>cv-stats-virus :sats-data=)~" , 
            "~(?<data>cv-stats-virus :stats-dta=)~" 
        ] ; 

        foreach($this->detectedregexpes as $item) {

            preg_match_all($item , $htmlContent , $this->detectedMatches);
            if($this->detectedMatches['data']) {
                echo '<br>chek 1' ;
                return $this->detectedMatches['data'] ;
            }
            else {
                echo '<br>chek 0' ;
            }
            
        }

        return 0 ;
    }


    function setIntoDb () {

        // var_dump($this->getDiedData());

        if(!$this->getDiedData()) {
            return 'no one match from Died' ;
        }
        else {

            if(!$this->getDetectedData()) {
                return 'no one match from Detected' ;
            }
            else {
                if(!$this->getDateData()) {
                    return 'no one match from Date' ;
                }
                else {
                    $statement = $this->pdo->prepare("INSERT INTO `covid_data` 
                    (`id`, `date`, `all_infected`, `today_infected`, `total_cure`, `today_was_cured`, `total_dead`, `today_dead`, `cdt`) 
                    VALUES (NULL, ? , NULL , ? , NULL , NULL , NULL , ? , CURRENT_TIMESTAMP)") ;
                    return 'setIntoDB: ' . $statement->execute([$this->dateMatches['data'][0] , $this->detectedMatches['data'][0] , $this->diedMatches['data'][0]]) ;
                }
                
            }

            return 'ok' ;
            
        }
    }

}

$gcd = new getCovidData($pdo) ;
var_dump($gcd->setIntoDb()) ;

echo '<br>done' ;

?>
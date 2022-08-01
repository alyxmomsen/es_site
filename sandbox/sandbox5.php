<?Php

$pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');

class getCovid19Data {

    private $monthes = [
        'января' => '01' , 'февраля' => '02' , 'марта' => '03' , 'апреля' => '04' , 'мая' => '01' , 'июня' => '01' , 'июля' => '01' , 'августа' => '01' , 'сентября' => '01' , 'октября' => '01' , 'ноября' => '11' , 'декабря' => '01'
    ] ;



    function __construct($pdo) {
        $this->pdo = $pdo ;
    }


    function dateData() {

        
        $result = $this->data['date'] ;
        // echo $result ;
        $result = rtrim($this->data['date']);
        $result = explode(' ' , $result);

        // var_dump($result);
        // foreach($this->monthes as $key => $item){
        //     if($result[1] === $key) {
        //         $result[1] = $item ;
                
        //         var_dump($result);
        //         break ;
        //     }
            
        // }
       
        unset($result[2]) ;
        // $result = $result[0] ; 
        $result = implode(' ' , $result);

        // $result = preg_replace( "~\\\\u00a0~" , '' , $result) ;
        // $result = preg_replace( "~[ ]*~" , '' , $result) ;
        return $result ;
        // echo 'пизддддаааааааа' ;
        return 0 ;
    }

    function diedData() {
        $result = preg_replace( "~\\\\u00a0~" , '' , $this->data['today_dead']) ;
        $result = preg_replace( "~[ ]*~" , '' , $result) ;
        return $result ;
        return 0 ;
    }

    function detectedData() {
        $result = preg_replace( "~[ ]*~" , '' , $this->data['today_infected']) ;
        $result = preg_replace( "~[ ]*~" , '' , $result) ;
        return $result ;
        return 0 ;
    }

    function getData() {
        $statement = $this->pdo->prepare("SELECT * FROM `covid_data` WHERE date IS NOT NULL ORDER BY cdt DESC") ;
        $statement->execute() ;
        $result = $statement->fetch() ;
        $this->data = $result ; 
        // echo $this->data['date'];
        return 0 ;
    }



}

$gc19d = new getCovid19Data($pdo);
$gc19d->getData();
// $gc19d->detectedData();
// $gc19d->diedData();
// $gc19d->dateData();

// echo 'hello' ;
// echo '<pre>' ;
// var_dump($gc19d->data) ;
// echo '</pre>' ;
// echo '<pre>' ;
// var_dump($gc19d->detectedData()) ;
// echo '</pre>' ;
// echo '<pre>' ;
// var_dump($gc19d->diedData()) ;
// echo '</pre>' ;
// echo '<pre>' ;
// var_dump($gc19d->dateData()) ;
// echo '</pre>' ;





?>
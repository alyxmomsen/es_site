<?php 




class DB_Manager {

    function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
    }

    
    function get () {
        $this->pdo->prepare('');
        // $this->
    }
}


(function () {
    $dbm = new DB_Manager ();
    
    /* var_dump($dbm); */
})() ;

// echo 'hello friend, what`s up' ;


?>

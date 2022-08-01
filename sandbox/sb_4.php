<?php

$f = function ($x , $y) {
    return $x * $y;
};


function fB ($func , $x , $y) {
    echo $func($x , $y);
}

fb($f , 6 , 9);




if(count($_GET)) {
//    foreach ($_GET as $index => $item) {
//        echo '<br>' . $index . ' ' . $item . '<br>' ;


//    }

    switch ($_GET['log']) {
        case 'logout':
            $_SESSION = array();
            session_destroy() ;
            echo '<br>' . 'logouted' . '<br>' ;
            break;
        case 'login':
            session_start() ;
            $_SESSION[$_COOKIE['PHPSESSID']] = 'alex' ;
            echo '<br>' . 'logined' . '<br>' ;
            break ;
        default:
            $_SESSION = array();
            session_destroy();
            break;
    }


}






//echo md5(alex) ;



if(count($_SESSION)) {
    echo 'one or more' ;

    foreach ($_SESSION as $index => $item) {
        if($index === $_COOKIE['PHPSESSID']) {
            echo $item ;
        }
    }
}
else {
    echo 'no one' ;
}



//$_SESSION[$_COOKIE['PHPSESSID']] = 'alex';


echo '<pre>' ;

//var_dump($_COOKIE);


print_r($_SERVER) ;
var_dump($_SESSION);
print_r($_COOKIE) ;

echo '</pre>' ;




?>
<div>div</div>

<form method="get" action="">
    <input type=submit name="log" id="login-button" value="login">
    <input type=submit name="log" id="logout-button" value="logout">
</form>

<form action="" method="post"></form>

<script>

    let myHeaders  = new Headers({
        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
    });

    fetch('h_sb_4.php' , {
        method : 'POST' ,
        body : 'hello=world' ,
        headers : myHeaders
    }).then((res) => res.json().then((data) => {
        for (let item in data) {
            console.log(data[item].id);
        }
        // alert(data);
    }));

    console.log('hello world');


    console.log(location);


    let div = document.querySelector('div');


    div.addEventListener('click' , (e) => {
        console.log(e);
        console.log(this);
    });

    window.addEventListener('keyup' , (event) => {
        console.log(event);
    });

</script>
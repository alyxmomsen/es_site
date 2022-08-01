<?php





?>
<head>

</head>
<script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<div id="main"></div>


<script>


    function sendData () {

        let myHeaders  = new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        });

        fetch('handler_sb3.php' , {
            method : 'POST' ,
            body : 'hello=world' ,
            headers : myHeaders
        }).then(resp => resp.json()).then(data => {
            console.log(data);
        });

        return 0;
    }


    sendData();


    function funcC () {
        console.log('hello world');
    }

    function funcD(func) {
        func();
        if(arguments.length > 1) {
            for (let item in arguments) {
                if(typeof arguments[item] === 'function') {
                    continue;
                }
                console.log('param' + item + '  :  ' + arguments[item]);
            }
        }

    }

    funcD(funcC , 'hello' , 'world');



    let x = 5 , y = 6 , z = 3;

    let arrX = [];

    let funcE = (a , b , c) => {
        a = a * b / c;
        arrX[arrX.length] = a;

        console.log(arrX);
    }

    let intervalID = setInterval(funcE , 1000 , x , y , z);

    setTimeout(clearInterval , 5000 , intervalID);








</script>

<script type="text/babel">


</script>

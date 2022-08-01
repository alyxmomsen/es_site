<?php





?>
<head>
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
</head>

<div class="main">

</div>

<div id="like_button_container"></div>
<div id="anotherButton"></div>


<script>

    let myHeaders  = new Headers({
        'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
    });

    fetch('sandbox1_handler.php' , {
        method : 'POST' ,
        body : 'hello=world' ,
        headers : myHeaders
    }).then((resp) => {
        resp.json().then((data) => {

            let elem = document.querySelector('div.main');

            elem.innerHTML = JSON.stringify(data);


            console.log(data);
        });
    });



    let myData = new Date();
    let date = Date.parse('2021-02-19 11:16:06');
    console.log(myData);
    console.log(date);
    let date2 = new Date(date)
    console.log();
    console.log(date2);

    // console.log();




</script>

<script>
    'use strict';

    const e = React.createElement;


    class LikeButton extends React.Component {
        constructor(props) {
            super(props);
            this.state = { liked: false };
        }

        render() {
            if (this.state.liked) {
                return 'You liked this.';
            }

            return e(
                'div',
                { onClick: () => this.setState({ liked: true }) },
                'Like'
            );
        }
    }

    const domContainer = document.querySelector('#like_button_container');
    const anotherButton = document.querySelector('#anotherButton')
    ReactDOM.render(e(LikeButton), domContainer);
    ReactDOM.render(e(LikeButton) , anotherButton);

    let elemente = React.createElement('div' , {className: 'myClass'});

    console.log(elemente);


    ReactDOM.render(elemente , domContainer);


</script>

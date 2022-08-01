
<head>
    <meta charset='utf-8'>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- end bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Stalinist+One&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
</head>
<div id="quotes-slider-module">
    <?php
    require_once '../db_connect.php';
    require '../alyx_php_functions/print_quotes_slider_with_qoutes_from_db.php';
    ?>
</div>
<script>
    var myCarousel = document.querySelector('#quotesSlider')
    var carousel = new bootstrap.Carousel(myCarousel, {
    interval: 2000,
    wrap: false
    });
</script>

<style>

    /* @import url('https://fonts.googleapis.com/css2?family=Lobster&family=Stalinist+One&display=swap'); */
    /* font-family: 'Lobster', cursive; */
    /* font-family: 'Stalinist One', cursive; */

    @font-face {
        font-family: ;
        src: url();
    }

    #quotes-slider-module {
        width: 24%;
        margin: 0 auto;
        background-color: #eee;
    }

    p.quote {
        /* font-family: 'Lobster', cursive; */
        font-family: 'Stalinist One', cursive;
        font-size: 29px;
        padding: 9px;
        text-align: center;
    }
</style>


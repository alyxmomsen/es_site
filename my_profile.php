<?php require 'db_connect.php'; ?>

<?php require 'functions_for_themes.php'; ?>
<?php 
// require 'my_profile_php_handlers/my_profile_my_diary_handler.php';
?>
<!DOCTYPE html>
<html lang="ru-RU">

<head>
    <?php require 'meta.php'; ?>
    <!-- <title>profile</title> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- \bootstrap -->
    <link rel="stylesheet" href="css/my_profile_v2.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_diary.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_useful_things.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_poetry.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_gadgets.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_locations.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_forKids.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_music.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/my_profile/my_profile_humor.css?v=<?= time(); ?>">
    <noscript><span>У Вас отключён JavaScript...</span></noscript>
</head>
<body>

<div class="superMain">
        <?php require 'head.php'; ?>
        

        <div class="grid-container about-me-main-container">
            <div class="text-content">
            <p class="main-text">
            Я, Сухачев Егор Генадиевич, родился в г. Сургут Тюменской области в 1975г. 
            Получил образование в средней школе (11 классов), в ТЮМГНГУ, в МГУ. 
            Жил в поселке Горноправдинск, в г.Мегион, в г.Тюмень (Тюменская обл.). 
            Сейчас живу в Москве (с 2005г.). В разные годы серьезно занимался 2-мя видами спорта. 
            Резко негативно отношусь к табаку, алкоголю, другим дурачущим веществам. 
            Посещал Европу, Африку, Казахстан, Турцию. 
            Имею значительный опыт вождения различных транспортных средств в том числе водных. 
            Имею в собственности однокомнатную квартиру в Южном Бутово, долю в нежилом помещении (90м) в Юго-Восточном,
                (50м) в Юго-Западном округ Москвы, (30м) в г.  Видное, Московская область.
            Четыре а/м: Хёндэ Тусон 2019г.; Газель 2020г.; Фольксваген Каравэл 2020г.; Мерседес Вито 2020г.. 
            Газель и Фольксваген, фактически, на июль 2021г, вот уже более 5 месяцев, а Хёндэ неоднократно,
                в разные периоды, как выведены из строя путинскими дебилами.
            <br><h3 style="text-align:center;color: black; font-size: 23px;">Со мной можно встретиться, , раз в две недели, по следующему расписанию:<br>
                    </h3>
                    <ul>
                <li>в <span class="red-text">субботу</span> на Пушкинской площади (11:00 - 13:00) </li>
                <li>в <span class="red-text">субботу</span> на Большом Москворецком Мосту, у мемориала Б. Немцова (14:00 - 17:00) </li>
                <li>в <span class="red-text">субботу</span> напротив Беларусского посольства в Москве (19:00 - 21:00)</li>
            </ul>
            Подробности в разделе "Обо мне", в подразделе "Объявления".
            </p>
            </div>

            
            <div class="map-and-cars">
                <div class="flex-item-map-container">
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad22e00f71b3806d94d1c178987dde8eeeb19ac66b029536343e17458173c22b8&amp;width=451&amp;height=360&amp;lang=ru_RU&amp;scroll=true"></script>
                        <!-- <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac0c052a3464893be090ce8aefbe1f29e7548874e5e29b2d5ef4b2f56a557f831&amp;source=constructor" frameborder="0"></iframe> -->
                </div>
                <div class="flex-item-img-container">
                    <!-- <div class="img-wrapper-fi">
                        <img src="data/img/my_location.jpeg" alt="" srcset="">
                        <span class="caption">Большая Никитская, 2</span>
                    </div> -->
                    <div class="img-wrapper-fi">
                        <img src="data/img/busy.jpeg" alt="">
                        <span class="caption">Январь, 2021, парковка трц "Атриум"</span>
                    </div>
                    <div class="img-wrapper-fi">
                        <img src="data/img/my_profile_my_transport_mercedes.jpeg" alt="" srcset="">
                        <span class="caption">Весна, 2021 , сквер Мандельштама</span>
                    </div>
                </div>
            </div>
            <!-- <div class="slider"></div> -->
            <div id="carouselExampleCaptions" class="carousel slide slider" data-ride="carousel">
                <!-- <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                </ol> -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="data/img/kindergarten.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>детский сад</h5>
                            <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/pioner_camp.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>пионерлагерь</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/school.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>школа</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    
                    <div class="carousel-item">
                    <img src="data/img/institute.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>институт</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/inside_the_store_2004.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2004</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/turkey_2005.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2005</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/2006.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2006</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/2007_zavidovo.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2007</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                        <img src="data/img/2008_hotel_tukey_egypt.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>2008</h5>
                            <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="data/img/2009_winter_ski_hotel_podmoskovye.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>2009</h5>
                            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/sochi_nice_company_2009.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2009</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/milan_2010.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2010</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/About_2011_May_Turkey_Hotel.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2011</h5>
                        <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/2013_the_red_square_area.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2013</h5>
                        <!-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p> -->
                    </div>
                    </div>
                    <div class="carousel-item">
                    <img src="data/img/about_me_slider.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>2015</h5>
                        <!-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p> -->
                    </div>
                    </div>
                    
                    <div class="carousel-item">
                        <img src="data/img/profile_photo.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>2019</h5>
                            <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="data/img/next_to_the_wall_2020.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>2020</h5>
                            <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div id="my-profile-modal-window">
                <!-- <div class="the-cover"></div> -->
                <div class="my-profile-main-container">
                    
                    <div class="my-profile-content-container">

                    </div>
                    
                </div>
                <div style="display:flex; justify-content:center; align-items:center;" class="close-button"><span>X<span></div>
            </div>
            <?php include 'modules/module_myProfile_modal.php' ?>
            <div id="superDuperNewModalWindow">
                <div class="superDuperNewModalWindow-buttonContainer">
                    <button id="superDuperNewModalWindow-closeButton">X</button>
                </div>
                <div id="superDuperNewModalWindow-toLoad-container"></div>
            </div>
            <?php require "modules/module_asidePanel.php"?>
        </div>
        
        <style>
            div.grid-container.about-me-main-container {
                display: grid;
                grid-template-rows: repeat(2 , auto);
                grid-template-columns: 1fr 1fr 36%;
                grid-auto-flow: row;
                position: relative;
            }

            div.grid-container.about-me-main-container > div {
                /* border: 1px solid red; */
            }

            div.text-content {
                grid-column: 1 / 3;
                height: auto;
                /* background-color: #eee; */
                font-size: 19px;
                text-align: justify;
                padding: 9px;
            }


            div.text-content > p.main-text {
                color: #5b5b5b;
            }

            div.map-and-cars {
                grid-column: 1 / 3;
                height: auto;
                /* background-color: #999; */
                display: flex;
                flex-direction: row;
                justify-content: stretch;

            }

            div.map-and-cars > div.flex-item-img-container > div.img-wrapper-fi {
                position: relative;
            }

            div.map-and-cars > div.flex-item-img-container > div.img-wrapper-fi > span {
                position: absolute;
                bottom: 0;
                left: 0;
                color: whitesmoke;
                text-align: center;
                right: 0;
                padding: 0 0 0 0;
            }
            
            div.flex-item-img-container {
                display: flex;
                flex-direction: row;

            }

            div.flex-item-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            div.slider {
                grid-column: 3 / 4;
                grid-row: 1 / 3;
                /* background-color: #666; */
                /* height: 734px; */
                height: auto;
                width: auto;
            }

            div.slider div.carousel-inner {
                height: 100%;
            }

            div.slider div.carousel-item {
                height: 100%;
            }

            div.slider div.carousel-item > img {
                height: 100%;
                width: 100%;
                object-fit: cover;
            }

            div.slider div.carousel-item .carousel-caption {
                padding: 0 36px;
                bottom: 0;
                right: 0;
                text-align: right;
            }

            /* ======================================== */
           

            @keyframes opcty {
                from {
                    opacity: 0 ;
                }
                
                to {
                    opacity: 1 ;
                }
            }



        
        </style>

        
        <?php require 'footer.php'; ?>
    </div>
</body>
</html>

<style>
    div#my-profile-modal-window {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        /* bottom: 0; */
        /* overflow-y: scroll; */
        background-color: #eee;
        z-index: 99;
        padding: 19px;
        height: 96vh;
    }

    div#my-profile-modal-window div.close-button {
        position: absolute;
        top: 9px;
        right: 9px;
        width: 19px;
        height: 19px;
        background-color: red;
        cursor: pointer;
    }

    div#my-profile-modal-window div.my-profile-main-container {
        width: 100%;
        height: 100%;
        /* overflow-y: scroll; */
    }

    div#my-profile-modal-window div.my-profile-content-container {
        width: 100%;
        height: 100%;

    }

</style>

<style>


    .blinker {
        animation: blinker 1s infinite;
    }


    @keyframes blinker {
        from {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }





</style>



<script>
    // $(document).ready(function(){
    //     window.scrollTo(0 , document.getElementById('my_profile').offsetTop);
    // });
</script>
<script src="javaScript/my_profile_handler_16.js?v=<?= time() ?>"></script>
<script src="javaScript/my_profile_handler_4.js?v=<?= time() ?>"></script>
<script src="javaScript/my_profile_click_buttons.js?v=<?= time() ?>"></script>
<script src="http://egorsukhachev.com/page_the_my_profile/javascript/buttonsTriggers_to_theSections.js?v=<?= time() ?>"></script>
<script>
    
    let rightButton = document.querySelector('div.navigation.to-right');
    let leftButton = document.querySelector('div.navigation.to-left');
    let the_end = document.querySelector('#the-end-of-the-line');
    let right_target = the_end.getBoundingClientRect();
    // let left_target = the_start.getBoundingClientRect();
    
    rightButton.addEventListener('click' , function(){
        // alert();
        let x = document.querySelector('#my_profile > div');    
        // alert(x.scrollLeft);
        x.scrollLeft = right_target.right;
    });

    leftButton.addEventListener('click' , function(){
        let x = document.querySelector('#my_profile > div');    
        // alert();
        x.scrollLeft = 0;
    });

</script>

<style>
.gadgets-body img {
	width: 25%;
	height: auto;
	object-fit: contain;
	display: block;
}
</style>
<style>
    #superDuperNewModalWindow {
    display: none ;
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	background-color: whitesmoke;
	z-index: 199;
}


.superDuperNewModalWindow-buttonContainer {
	display: flex;
	justify-content: flex-end;
	background-color: grey;
    height: 4%;
}


#superDuperNewModalWindow-closeButton {

}




</style>
<style>
#superDuperNewModalWindow-toLoad-container {
	height: 96%;
	overflow: hidden;
}
</style>

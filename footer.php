<? 



// require 'functions_for_themes.php';
/////// библиотеку заменить другой или подумать над этим

function getAllTags()
{
    global $pdo;
    $statement = $pdo->prepare("select * from hash_tags");
    $statement->execute();
    $rows = $statement->fetchall(PDO::FETCH_ASSOC);
    return $rows;
}



?> 

<style>
    form.form-to-search {
        /* border: 2px solid white;
        border-radius: 19px; */
        font-family: 'Old Standard TT', serif;
    }

    form.form-to-search > fieldset > legend {
        color: #981f1f;
        text-align: center;
    }

    form.form-to-search > fieldset > input.to-write-request-keyword {
        border: 1px solid green ;
        display: block ;
        margin: 6px auto ;
        font-size: 1.4em ;
        width: 80% ;
        overflow: hidden ;
        text-align: center ;
    }

    form.form-to-search > fieldset > select {
        border: 1px solid green ;
        display: block ;
        margin: 6px auto ;
        font-size: 1.4em ;
        width: 80% ;
        overflow: hidden ;
        color:#28545b; 
        text-align: center ;
    }

    form.form-to-search > fieldset > select > option {
        text-align: center;
    }

    form.form-to-search > fieldset > input[type=submit] {
        /* background-color: red; */
        margin: 19px auto;
        display: block;
    }

</style>

<div id="footer" class="footer">
    <div class="footerCol fc_1">
        <div class="wrapper">
            <a class="soc-icon" target="_blank" href="http://egorsuh.livejournal.com">
                <img src="data/img/icons/121543.png" alt="">
                <!-- <span class="path">http://egorsuh.livejournal.com</span> -->
            </a>
            <a class="soc-icon" target="_blank" href="http://vk.com/id159037873">
                <i class="fab fa-vk fa-3x"></i>
                <!-- <span class="path">http://vk.com/id159037873</span> -->
            </a>
            <a class="soc-icon" target="_blank" href="https://twitter.com/suhachev75">
                <i class="fab fa-twitter fa-3x"></i>
                <!-- <span class="path">https://twitter.com/suhachev75</span> -->
            </a>
            <a class="soc-icon" target="_blank" href="https://www.youtube.com/channel/UC1circYuSBRzc8-ZJ6t3okw">
                <i class="fab fa-youtube fa-3x"></i>
                <!-- <span class="path">https://www.youtube.com/</span> -->
            </a>
            <a class="soc-icon" target="_blank" href="mailto:suhachevegor@gmail.com">
                <i class="fas fa-at fa-3x"></i>
                <!-- <span class="path">suhachevegor@gmail.com</span> -->
            </a>
            <a class="soc-icon" target="_blank" href="https://www.instagram.com/7930egor/">
                <i class="fab fa-instagram fa-3x"></i>
                <!-- <span class="path">@7930egor/</span> -->
            </a>
            <style>
                .fa-3x {
                   font-size: 30px;
                }
            </style>
        </div>
        <div class="mobile-phone-number">
            <span style="">+7 (967) 186-32-20</span>
            <span ><span style="">(</span><span style="">только для СМС</span><span style="">)</span></span>
        </div>

        <div class="qr-code-block" style="display: flex;column-gap: 9px;justify-content: flex-start;">
            <div style="width: 96px; display: flex;flex-direction: column;justify-content: center;row-gap: 9px;">
                <img style="width: 100%; object-fit:contain;height:auto;" src="http://egorsukhachev.com/data/img/system-qr-code_for_mobile_6.gif" alt="">
                <a href="http://m.egorsukhachev.com" style="display:block; width:100%; text-align: center; text-decoration:none; color:whitesmoke; margin: 0px auto; padding:6px 0;background-color:grey;font-size:1em;">мобильная <br>версия</a>
            </div>
            <div style="width: 96px; display: flex;flex-direction: column;justify-content: center;row-gap: 9px;">
                <img style="width: 100%; object-fit:contain;height:auto;" src="http://egorsukhachev.com/data/img/system-qr-code_for_desktop_6.gif" alt="">
                <a href="http://egorsukhachev.com" style="display:block; width:100%; text-align: center; text-decoration:none; color:whitesmoke; margin: 0px auto; padding:6px 0;background-color:grey;font-size:1em;">настольная <br>версия</a>
            </div>
        </div>

        <a class="usual-links-trigger" href="#">Ссылки</a>
        <?php 
        require 'modules/module_usual_links_modal_window.php' 
        ?>
            <script>
                let elem = document.querySelector("a.usual-links-trigger");
                let ulinkselem = document.querySelector("a.usual_links");
                elem.addEventListener('click' , function(event){
                    event.preventDefault();
                    $('#module_usual_links_modal_window').css({
                        display: 'flex' ,
                        zIndex: 1
                        
                    });

                });

                let closeButtonElem = document.querySelector('.u-l-m-w-close-button');
                closeButtonElem.addEventListener('click' , () => {
                    $('#module_usual_links_modal_window').css({
                        display: 'none' ,
                        zIndex: -1
                        
                    });
                });

                // alert();
                
            </script>
        <!-- </div> -->
    </div>
    <div class="footerCol fc_2">
        <a href="my_profile.php">
            <span class='where-i-am'>ГДЕ Я</span>
        </a>
        <div class="container form">
        <!-- <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad22e00f71b3806d94d1c178987dde8eeeb19ac66b029536343e17458173c22b8&amp;width=451&amp;height=360&amp;lang=ru_RU&amp;scroll=true"></script> -->
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad22e00f71b3806d94d1c178987dde8eeeb19ac66b029536343e17458173c22b8&amp;width=451&amp;height=360&amp;lang=ru_RU&amp;scroll=true"></script>
        <!-- <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac0c052a3464893be090ce8aefbe1f29e7548874e5e29b2d5ef4b2f56a557f831&amp;source=constructor" frameborder="0"></iframe> -->
        <!-- <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac0c052a3464893be090ce8aefbe1f29e7548874e5e29b2d5ef4b2f56a557f831&amp;source=constructor" frameborder="0"></iframe> -->
        <!-- <div class='protector'></div> -->
        </div>
        <div class='since-block'>
            <p>© 2020 -2021</p>
        </div>
        <div class='site-agreement'>
            <a href="useragree.php">Соглашение по использованию</a>
        </div>
    </div>
    <div class="footerCol fc_3">

        <?php include 'another_modules/module_calendar.php';?>
        
    </div>
    <div class='footerCol fc-4'>
    
    </div>
</div>

<!-- <div class="progress-bar"></div>  -->
<style>
    a {
        color: white ;
    }
</style>
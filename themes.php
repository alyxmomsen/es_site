<?php
require "functions_for_themes.php";

?>

<!doctype html>
<html>
    <head>
    <? require "meta.php"; ?>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- ========= -->
    <link rel="stylesheet" href="css/themes_v3.css?ver= <?= time(); ?>">
    </head>
    <body>
          
        <div class="superMain themes-page">
            <? require "head.php" ?>  
            <?php themePrinter(); ?>
            <ul class="letter_navigator">

                <?php
                    
                    $prev_monday_t = time() - (date('N') + 6) * 86400;
                    $prev_sunday_t = time() - date('N') * 86400;
                    // echo 60*60*24;
                    // echo date('Y-m-d H:i:s', $prev_monday_t ).'<br>'.date('Y-m-d H:i:s', $prev_sunday_t );
                    // echo date('D, d M Y H:i:s' , $prev_monday_t);
                    // echo date('D , d M Y');
                    // echo date('Y M d' , (date('N') + 6) * 86400);  
                    // echo date('D, d M Y H:i:s' , $prev_monday_t);
                    // echo date('Y');
                    $letters = array(
                        'А' , 'Б' , 'В' , 'Г' , 'Д' , 'Е', 'Ж', 'З' , 'И' , 
                        'К' , 'М' , 'Н' , 'О' , 'П' , 'P' , 'С' , 'Т' , 'У' , 'Ф', 'Х' , 'Ц', 'Ч' , 'Э', 'Я' , 'E' ,
                        'M'
                    );

                    for($letterInd = 0 ; $letterInd < count($letters) ; $letterInd++)
                    {
                         echo "<li><a href='$_SERVER[PHP_SELF]?themeLetter=$letters[$letterInd]'>$letters[$letterInd]</a></li>";
                         /*echo "<li><a href='$'>$letters[$letterInd]</a>" ;*/
                    }
                ?>

            </ul>
            <?php require "footer.php"; ?>
        </div>
        <?php require "modules/module_asidePanel.php"?>
        <script src="javaScript/arch.js"></script>
    </body>
</html>
<!-- <script src="javascript/snow-fall.js"></script> -->
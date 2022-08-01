<?php 

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
require_once "db_connect.php"; 
require 'db_connect.php'; 

?>

<?php 

?>

<!doctype html>
<html lang='ru'>
  <head>
    <?php require 'meta.php'; ?>
  </head>
  <body>
    <div class="main">
      <div class="banner"></div>
    </div>
  </body>
  <style>
    body {
      margin: 0 ;
    }

    div.main > div.banner {
      height: 100vh ;
      width: 100% ;
      background-color: black ;
      background-image: url('data/img/ellipse.png');
      background-repeat: no-repeat ;
      background-position: center center ;
      background-size: contain ;
    }
  </style>
</html>
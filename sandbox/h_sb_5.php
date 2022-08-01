<?php 


// echo json_encode('hello man');
// echo  json_encode($_FILES['file']) ;
// echo count($_POST) ;

$temp_name  = $_FILES['file']['name'];

$arr = explode('.' , $temp_name) ;
$ext = $arr[count($arr) - 1] ;

echo json_encode($ext) ;
 
move_uploaded_file($_FILES['file']['tmp_name'] , 'files/' . time() . '.' . $ext);





?>



<?php


echo '<pre>';
var_dump($_FILES) ; 
echo '</pre>';



if(!empty($_FILES['user_file']['tmp_name'])) {
    $nameArr = explode('.' , $_FILES['user_file']['name']) ;



    move_uploaded_file($_FILES['user_file']['tmp_name'] , 'files/' . time() . '.' . $nameArr[count($nameArr) - 1] );
}


?>

<form method="POST"  action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

    <input id='myFile' name="user_file" type='file'>

    <input type="submit" value="value">




</form>



<script>


    function addVideoIntoServer() {
        let elem = document.querySelector('#myFile');
        elem.addEventListener('change' , (e) => {
            console.log('done');
            console.log(e.target.files) ;


            let formData  = new FormData();
            formData.append('file' , e.target.files[0]);

            fetch('h_sb_5.php' , {
                method: 'POST' , 
                body : formData
            }).then(response => response.json()).then(data => {
                console.log(data);
            });
        });
    }

    addVideoIntoServer();


</script>
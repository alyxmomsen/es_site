<?php 

session_start() ;
// session_name("alexy") ;

// print_r($_SESSION) ; 
if(!isset($_SESSION['counter'])):
    $_SESSION['counter'] = 0 ;
endif;
$_SESSION['counter']++ ;

// print_r(session_id()) ;

?>
<div id='news-input-module'>

<form name="upload" action="addingItemsIntoTheDB.php" method="POST" ENCTYPE="multipart/form-data">
<fieldset>
    <legend>изображение</legend>
    <input type="file" name="userfile">
</fieldset>

<fieldset>
    <legend>Тема</legend>
    <input type="text" name="theme_name" id="theme_name" placeholder="название темы">
</fieldset>
<fieldset>
    <legend>тег</legend>
    <input type="text" name="tag" id="tag" placeholder="имя тега">
</fieldset>

<fieldset>
    <legend>основной контент</legend>
    <textarea name="paragraph" id="paragraph" cols="30" rows="2" placeholder="основной контент"></textarea>
</fieldset>

<fieldset>
    <legend>Видео</legend>
    <textarea name="video" id="video" cols="30" rows="2" placeholder="видео"></textarea>
    <input type="radio" name="video_source" id="video_source" value='ytb' checked>
    <input type="radio" name="video_source" id="video_source" value='local'>
</fieldset>

<fieldset>
    <legend>ссылки</legend>
    <textarea name="source" id="source" cols="30" rows="2" placeholder="ссылка на источник"></textarea>
</fieldset>

<fieldset>
    <legend>кнопочки</legend>
    <input type="submit" name="upload" value="upload">
    <input type="reset">
</fieldset>
<fieldset>
    <a href="adding_other_img_module.php" target="_blank" rel="noopener noreferrer">открыть окно добавления дополнительных изображений</a><br>
</fieldset>


</form>



</div>


<!-- <a href="http://" target="_blank" rel="noopener noreferrer">добавить ещё видео</a> -->

<!-- скрипт работает
нужно обновлять ftp
что бы увидеть полученые файлы -->

<script>
    
    let the_date = new Date();
    let par = document.createElement('p');
    let inputModule = document.querySelector('#news-input-module');
    
    // pElement.innerHtml = the_date.getTime();
    par.append(the_date.getTime());
    inputModule.append(par);
    // inputModule.append(par);
    // let formSel = document.querySelector('form');
    // formSel.append(pElement);
    // alert(the_date.getTime());
</script>

<style>



form {
	width: 60%;
	margin: 0 auto;
	background-color: whitesmoke;
	padding: 9px;
}

body {
	background-color: #7b7b7b;
}

</style>
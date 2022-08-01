<?php 






?>
<div id="linkTag-interface">
    <form action="addingTagByNewsID.php" method="POST" ENCTYPE="multipart/form-data">
        <fieldset>
            <legend>ID новости</legend>
            <input id="news_ID" name="news_ID" type="text">
        </fieldset>
        <fieldset>
        <legend>Имя тега</legend>
            <input id="tag_name" name="tag_name" type="text">
        </fieldset>

        <fieldset>
            <legend>кнопочки</legend>
            <input type="submit" name="upload" value="upload">
            <input type="reset">
        </fieldset>
    </form>
</div>

<style>

div#linkTag-interface {
	width: 444px;
	margin: 0 auto;
}


#linkTag-interface form {
    
}

#linkTag-interface {

}

</style>
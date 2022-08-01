<div id="adding_other_img_module">
    <form name="upload" action="adding_other_img_handler.php" method="POST" ENCTYPE="multipart/form-data">

        <fieldset>
            <legend>id публикации</legend>
            <input type="text" name="news-id" id="news-id" placeholder="id публикации"></input>
        </fieldset>

        <fieldset>
            <legend>изображение</legend>
            <input type="file" name="userfile">
        </fieldset>

        <fieldset>
            <legend>кнопочки</legend>
            <input type="submit" name="upload" value="upload">
            <input type="reset">
        </fieldset>

        <fieldset>
            <a href="expModule.php" target="_blank" rel="noopener noreferrer">открыть окно добавления публикаций</a><br>
        </fieldset>
    </form>

    
</div>

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
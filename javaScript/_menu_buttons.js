$(document).ready(function(){
    $("div.mainMenu > div.menuitem > a.about-button").click(function (e){
        e.preventDefault();
        // alert('huuuuuuuy');
        $("div#main_modal_window").css("display","flex");
        $("body").css("overflow","hidden");
        $.ajax({
            url: './main_modal_window.php',         /* Куда пойдет запрос */
            method: 'post',             /* Метод передачи (post или get) */
            data: {text: 'x'},     /* Параметры передаваемые в запросе. */
            success: function(data){/* функция которая будет выполнена после успешного запроса.  */
                // alert(data)            /* В переменной data содержится ответ от index.php. */
            }
        });
    });

    $("div#main_modal_window div.subcontainer > div.close-button").click(function(e){
        $("div#main_modal_window").css("display","none");
        $("body").css("overflow","auto");
    });

    $("div.mainMenu > div.menuitem:first-child").click(function () {
        $.ajax({
            url: './mail_handler.php',         /* Куда пойдет запрос */
            method: 'post',             /* Метод передачи (post или get) */
            data: {text: 'Текст'},     /* Параметры передаваемые в запросе. */
            success: function(data){/* функция которая будет выполнена после успешного запроса.  */
                alert(data)            /* В переменной data содержится ответ от index.php. */
            }
        });
    });
});



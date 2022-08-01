$(document).ready(function () {
    $("div#footer > div.footerCol").click(function (e) {
        // e.preventDefault();
        // var form_data = $(this).serialize(); // Собираем все данные из формы
        $.ajax({
            type: "POST", // Метод отправки
            url: "/practice_page.php", // Путь до php файла отправителя
            data: "text",
            success: function () {
                // Код в этом блоке выполняется при успешной отправке сообщения
                alert("Ваше сообщение отправлено!");
            }
        });
        // alert();
    });
});

/**/
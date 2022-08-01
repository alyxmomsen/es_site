function print_fails_content() {
    let str = "<h2>Зашквар</h2>";
    str += "<p>Мальчик к папе подошёл <br>Надо разобраться! <br>Жить, как ты, я пап хочу <br>Чтоб не напрягаться!</p>";
    str += "<p>Тут сынок совет простой <br>Главное жениться <br>И пойми, любовь - отстой  <br>Надо торопиться</p>";
    str += "<p>Выбери себе невесту <br>По примеру матери <br>Из богатой, модной знати <br>Этого нам хватит</p>";
    str += "<p>Ну а то, что до тебя <br>Сладко жить любила:  <br>И мужчин, и юношей <br>Ртом благодарила,</p>";
    str += "<p>Красота фальшивая <br>Ложью, ленью светится <br>Это мелочь, ерунда <br>Попривыкнешь, стерпится</p>";
    str += "<p>Дальше надо попотеть <br>Твой отец намаялся <br>У собак учись сынок,  <br>Лихо получается!</p>";
    str += "<p>Аккуратно вовремя <br>Ей места отхожие, <br>Ты сынок вылизывай, <br>Тыкаясь в них рожей</p>";
    str += "<p>Выгляди, как одуванчик <br>Посредине лета, <br>Страстно, яростно дыши <br>И читай куплеты! </p>";
    str += "<p>Вот такая брат наука, <br>Но зато навечно, <br>Жизнь в достатке, сытости <br>Будет обеспечена.</p>";
    str += "<style>div.my-profile-content-container {text-align:center; font-family:'Roboto', Arial, sans-serif;}div.my-profile-content-container > h2 {border-top: 2px solid #c7c7c7;border-bottom: 2px solid #c7c7c7;}</style>";
    return str;
}

document.getElementById("theme-item-4").addEventListener("click" , (event) => {

    event.preventDefault();

    let elem = document.getElementsByClassName('my-profile-content-container');
    // let str = "<h2>Политика</h2>" ;

    if(document.getElementById("my-profile-modal-window").style.display == "flex") {
        
        elem[0].innerHTML = print_fails_content();
    }
    else {
        
        elem[0].innerHTML = print_fails_content();
        // document.getElementById("carouselExampleCaptions").classList.toggle("blured");
        // document.querySelector(".content").classList.toggle("blured");
        document.getElementById("my-profile-modal-window").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden" ;
    }

    
    document.getElementById("theme-item-4").scrollIntoView();
    
    document.querySelector("div.close-button").addEventListener("click" , () => {
        document.getElementById("my-profile-modal-window").style.display = "none";
        // document.querySelector(".content").classList.remove("blured");
        // document.getElementById("carouselExampleCaptions").classList.remove("blured");
        document.querySelector("body").style.overflow = "auto" ;
    });    

    // let modWindow = document.getElementById("my_profile");
    // alert(window.innerHeight - modWindow.offsetHeight);
    // document.getElementById("my-profile-modal-window").innerHeight = window.innerHeight - modWindow.offsetHeight - 500;
    // alert(window.innerHeight - modWindow.offsetHeight);

});
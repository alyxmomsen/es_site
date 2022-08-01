
document.getElementById("theme-item-2").addEventListener("click" , (event) => {

    let elem = document.getElementsByClassName('my-profile-content-container');
    let str = "<h2>Досуг</h2>" ;

    if(document.getElementById("my-profile-modal-window").style.display == "flex") {
        str += "<p style='font-size:1.4em;'>Заниматься нужно полезным делом. Это - бег, единоборства, плавание, лыжи,  ";
        str += "метание ножей, велосипед, самокат, коньки, альпинизм, спортивное ориентирование, фихтование, езда под парусом и другое. ";
        str += "А, например, хоккей, футбол, волейбол, теннис, водное поло, баскетбол и т. д. - бесполезные игры</p>";
        elem[0].innerHTML = str ;
    }
    else {
        str += "<p style='font-size:1.4em;'>Заниматься нужно полезным делом. Это - бег, единоборства, плавание, лыжи,  ";
        str += "метание ножей, велосипед, самокат, коньки, альпинизм, спортивное ориентирование, фихтование, езда под парусом и другое. ";
        str += "А, например, хоккей, футбол, волейбол, теннис, водное поло, баскетбол и т. д. - бесполезные игры</p>";
        elem[0].innerHTML = str ;
        // document.getElementById("carouselExampleCaptions").classList.toggle("blured");
        // document.querySelector(".content").classList.toggle("blured");
        document.getElementById("my-profile-modal-window").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden" ;
    }
    event.preventDefault();
    document.getElementById("theme-item-2").scrollIntoView();
    
    document.querySelector("div.close-button").addEventListener("click" , () => {
        document.getElementById("my-profile-modal-window").style.display = "none";
        // document.querySelector(".content").classList.remove("blured");
        // document.getElementById("carouselExampleCaptions").classList.remove("blured");
        document.querySelector("body").style.overflow = "auto" ;
    });    
});
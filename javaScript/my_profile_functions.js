function open_my_diary() {
    
    // document.getElementById("my-profile-modal-window").style

    let url = "get_diary.php";
    let data_to_send = "rqst=full_diary";
    let the_request = new XMLHttpRequest();
    // new XMLHttpRequest();
    
    the_request.responseType = "json" ; 
    
    the_request.open("POST", url, true);
    the_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // request.setRequestHeader("Content-type", "application/json");
    the_request.addEventListener("readystatechange" , () => {
        if (the_request.readyState === 4 && the_request.status === 200) {
            alert('world');
            let elem = document.getElementsByClassName('my-profile-content-container');
            let str = "";
            let thedata = the_request.response;
            let current_date = "0";
            let formaten_current_date = "";
            
            var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            };
            // alert(JSON.stringify(thedata));
            // alert(thedata[0].body);
            for(key in thedata) {

                if(current_date < thedata[key].create_date)
                {
                    current_date = new Date(Date.parse(thedata[key].create_date)) ; 
                    formaten_current_date = current_date.toLocaleString("ru" , options);
                    str += formaten_current_date ;
                    current_date = thedata[key].create_date ;
                }

                str += "<p style='margin:19px auto; padding: 19px; border-radius:19px; background-color:#78a5a3;'><b>" + thedata[key].create_time + "</b><br><br><span style='font-size:22.4px;'>" + thedata[key].body + "</span></p>";
            }

            elem[0].innerHTML = str;

        }
        // alert(the_request.response);
    });
    
    the_request.send(data_to_send);
    // alert(the_request.response);
    return 0;
}

// ^^ the diary function ^^

document.getElementById("theme-item-3").addEventListener("click" , (event) => {
    if(document.getElementById("my-profile-modal-window").style.display == "flex") {
        
        open_my_diary();
        document.querySelector("body").style.overflow = "auto" ;
    }
    else {
        let main_container = document.querySelector('div#my-profile-modal-window div.my-profile-main-container');
        main_container.style.overflow = 'auto';
        open_my_diary();
        // document.getElementById("carouselExampleCaptions").classList.toggle("blured");
        // document.querySelector(".content").classList.toggle("blured");
        // alert();
        document.getElementById("my-profile-modal-window").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden" ;
    }
    alert('hello world');
    event.preventDefault();
    document.getElementById("theme-item-3").scrollIntoView();
    
    document.querySelector("div.close-button").addEventListener("click" , () => {
        // document.getElementById("my-profile-modal-window").style.display = "none";
        // document.querySelector(".content").classList.remove("blured");
        // document.getElementById("carouselExampleCaptions").classList.remove("blured");
        document.querySelector("body").style.overflow = "auto" ;
        let main_container = document.querySelector('div#my-profile-modal-window div.my-profile-main-container');
        main_container.style.overflow = 'hidden';
    });

});






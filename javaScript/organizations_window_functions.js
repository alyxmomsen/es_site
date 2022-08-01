
function open_organizations_data(){
    // document.getElementById("my-profile-modal-window").style
    // alert(); 
    let url = "get_organization.php";
    let data_to_send = "rqst=full_organiztions";
    let the_request = new XMLHttpRequest();
    
    the_request.responseType = "json" ;  
    
    the_request.open("POST", url, true);
    the_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // request.setRequestHeader("Content-type", "application/json");
    the_request.addEventListener("readystatechange" , () => {
        if (the_request.readyState === 4 && the_request.status === 200) {

            let elem = document.getElementsByClassName('my-profile-content-container');
            let str = "";
            let thedata = the_request.response;
            let current_date = "0";
            let formaten_current_date = "";

            // alert(JSON.stringify(thedata));
            // alert(thedata[0].body);
            for(key in thedata) {

                str += `<p style='margin:19px auto; border-radius:19px;font-size:22.4px;font-family:\"Old Standard TT\";'><a target='_blank' href='` + 
                thedata[key].src + "' style=''><span class='url'>" + 
                thedata[key].title + "</span><span style='color:#78a5a3' class='description'>";
                if(thedata[key].description != null) str += " - " + thedata[key].description;
                str += "</span></a></p>";
            }

            elem[0].innerHTML = str;

        }
        // alert(the_request.response);
    });

    the_request.send(data_to_send);
    // alert(the_request.response);

    return 0;
}

document.getElementById("theme-item-11").addEventListener("click" , (event) => {
    if(document.getElementById("my-profile-modal-window").style.display == "flex") {
        open_organizations_data(); 
    }
    else {
        open_organizations_data(); 
        // document.getElementById("carouselExampleCaptions").classList.toggle("blured");
        // document.querySelector(".content").classList.toggle("blured");
        document.getElementById("my-profile-modal-window").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden" ;
    }
    event.preventDefault();
    document.getElementById("theme-item-11").scrollIntoView();
    
    document.querySelector("div.close-button").addEventListener("click" , () => {
        document.getElementById("my-profile-modal-window").style.display = "none";
        // document.querySelector(".content").classList.remove("blured");
        // document.getElementById("carouselExampleCaptions").classList.remove("blured");
        document.querySelector("body").style.overflow = "auto" ;
    });    
});
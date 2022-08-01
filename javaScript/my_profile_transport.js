
function print_transport_content() {
    // alert();


    // var h2 = document.createElement('h2');
    let div_main = document.createElement('div');

    div_main.style.display = 'flex';
    div_main.style.justifyContent = 'space-around';
    div_main.className = 'my_transport_container';
    div_main.style.alignItems = 'stretch';


    let div_img_wrapper = document.createElement('div');
    div_img_wrapper.style.width = '25%';
    div_img_wrapper.style.position = 'relative';

    let img = document.createElement('img');
    img.style.display = 'inline-block';
    img.style.width = '100%';
    img.style.height = '100%';
    img.style.objectFit = 'cover';

    let span = document.createElement('span');
    span.style.position = 'absolute';
    span.style.bottom = '0';
    span.style.right = '0';
    span.style.color = 'white';
    span.style.paddingRight = '6px';


    let img_1 , img_2 , img_3;
    img_1 = img.cloneNode();
    img_1.src = 'data/img/mandelshtam_square.jpg';

    img_2 = img.cloneNode();
    img_2.src = 'data/img/busy.jpeg';
    
    img_3 = img.cloneNode();
    img_3.src = 'data/img/my_profile_my_transport_mercedes.jpeg';


    let caption_1 = span.cloneNode();
    caption_1.innerHTML = 'Весна, 2021 , сквер Мандельштама';

    let caption_2 = span.cloneNode();
    caption_2.innerHTML = 'Январь, 2021, парковка трц "Атриум"';

    let caption_3 = span.cloneNode();
    caption_3.innerHTML = 'Весна, 2021 , сквер Мандельштама';

    // --- assembling

    div_main.innerHTML = '';

    let img_wrapper_1 = div_img_wrapper.cloneNode();
    img_wrapper_1.append(img_1);
    img_wrapper_1.append(caption_1);

    let img_wrapper_2 = div_img_wrapper.cloneNode();
    img_wrapper_2.append(img_2);
    img_wrapper_2.append(caption_2);

    let img_wrapper_3 = div_img_wrapper.cloneNode();
    img_wrapper_3.append(img_3);
    img_wrapper_3.append(caption_3);

    div_main.append(img_wrapper_1);
    div_main.append(img_wrapper_2);
    div_main.append(img_wrapper_3);

    return div_main;
}


document.getElementById("theme-item-15").addEventListener("click" , (event) => {
    
    event.preventDefault();

    var h2 = document.createElement('h2');
    h2.style.textAlign = 'center';
    h2.innerHTML = 'Мои Авто';
    
    let elem = document.getElementsByClassName('my-profile-content-container');

    let my_profile_modal_window = document.querySelector('div#my-profile-modal-window');


    // let str = "<h2>Политика</h2>" ;


    if(document.getElementById("my-profile-modal-window").style.display == "flex") {

        elem[0].innerHTML = '';
        
        elem[0].append(h2);
        elem[0].append(print_transport_content());

        
    }
    else {

        elem[0].innerHTML = '';
        
        elem[0].append(h2);
        elem[0].append(print_transport_content());
        my_profile_modal_window.style.display = 'flex';
        // alert();

        // document.getElementById("carouselExamdpleCaptions").classList.toggle("blured");
        // document.querySelector(".content").classList.toggle("blured");
        // document.getElementById("my-profile-modal-window").style.display = "flex";
        document.querySelector("body").style.overflow = "hidden" ;
    }

    document.getElementById("theme-item-15").scrollIntoView();
    
    document.querySelector("div.close-button").addEventListener("click" , () => {
        document.getElementById("my-profile-modal-window").style.display = "none";
        // document.querySelector(".content").classList.remove("blured");
        // document.getElementById("carouselExampleCaptions").classList.remove("blured");
        document.querySelector("body").style.overflow = "auto" ;
    });   
    
    // let modWindow = document.getElementById("my_profile");
    // // alert(window.innerHeight - modWindow.offsetHeight);
    // document.getElementById("my-profile-modal-window").innerHeight = window.innerHeight - modWindow.offsetHeight;
    
});
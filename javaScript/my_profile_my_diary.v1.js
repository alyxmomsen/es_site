let my_diary_link = document.querySelector('span[id^="theme-item-3"] > a');
let my_profile_modal_window = document.querySelector('div#my-profile-modal-window');
let toLoadElement = document.querySelector('div.my-profile-main-container > div.my-profile-content-container');



my_diary_link.addEventListener('click' , (e) => {
    e.preventDefault();
    if(my_profile_modal_window.style.display === 'flex') {
        // alert('you already are the same');
    }
    

    let xhr = new XMLHttpRequest();
    let url = 'alyx_php_functions/about_me_page/about_me_php_functions.php';
    let dataToSend = "rqst=full_diary";

    xhr.open('POST' , url);

    xhr.responseType = 'json';

    xhr.addEventListener('readystatechange' , function(){
        if(xhr.readyState === 4 && xhr.status === 200) {

            // alert(xhr.responseText);

            my_profile_modal_window.style.display = 'flex';
            // console.log(result);
            // toLoadElement.innerHTML = xhr.responseText;
            // console.log(xhr);
            // xhr.foreach((elem) => {
            //     toLoadElement.append('hello world');
            // });
            // let c = 1;

            let r = xhr.response;

            // r.foreach(function(){
            //     toLoadElement.innerHTML = 'helloworld';
            // });
            let br = document.createElement('br');



            var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            };

            let newdate;

            for(let key in xhr.response){
                // toLoadElement.append(xhr.response[key]['cdt']);
                // toLoadElement.append(`<br>`);
                newdate =  new Date(Date.parse(xhr.response[key]['cdt']))
                // toLoadElement.append(newdate.toLocaleString('ru', options));
                // toLoadElement.append('   ');    
                // toLoadElement.append('<br>');
            }



            // xhr.response.foreach((elem) => {
            //     // toLoadElement.append(c);
            //     // c++;
            // });
            // console.log(xhr.response);

            // alert(xhr.response[0]['id']);

            // close_button.style.backgroundColor = 'blue';


            

            let close_button = document.querySelector('div.close-button');

            close_button.addEventListener('click' , () => {

                my_profile_modal_window.style.display = 'none';

                
            });



        }
    });

    xhr.send(dataToSend);

    //
    //

    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //

    //
    








    



});



function useful_things_button(){
    let bodySelector = document.querySelector('body');
    let diaryButton = document.querySelector('span[id="theme-item-2"] > a');
    let modalWindowSelector = '#my-profile-modal-window';
    let menuLineSelector = document.querySelector('div#my_profile');

    let contentContainerSelector = document.querySelector('#my-profile-modal-window > div.my-profile-main-container > div.my-profile-content-container'); 

    let closeButtonSelector = document.querySelector('#my-profile-modal-window div.close-button');

    diaryButton.addEventListener('click' , function(clickEvent){
        clickEvent.preventDefault();
        let modalWindow = document.querySelector(modalWindowSelector);

        

        modalWindow.style.display = 'block';

        //

        let xhr = new XMLHttpRequest();
        xhr.open('POST' , 'my_profile_php_handlers/my_profile_useful_things_handler.php');
        // xhr2.responseType = 'json';

        xhr.addEventListener('readystatechange' , function(){
            // alert();
            if(xhr.readyState === 4 && xhr.status === 200) {
                contentContainerSelector.innerHTML = '';
                // console.log(xhr2.response);
                // contentContainer.innerHTML = xhr.response;
                contentContainerSelector.innerHTML = xhr.responseText;
                contentContainerSelector.style.overflowY = 'scroll';
                bodySelector.style.overflow = 'hidden';
                menuLineSelector.scrollIntoView();
                // alert(xhr.responseText);
            }

            // alert();
        });

        // xhr2.onprogress = function(progressEvent){
            // console.log(progressEvent.loaded);
            // alert(progressEvent.loaded);
            // console.log(progressEvent.total);
        // }

        xhr.send();

        //


        //

        // modalWindow.append(contentContainer);

        // modalWindow.append(closeButton);

        // closeButton.addEventListener('click' , function() {
        //     let mw = document.querySelector('#about-me-page-modal-window');
        //     mw.innerHTML = '';
        //     mw.style.display = 'none';
        // });


        
        
        // return 0;

        closeButtonSelector.addEventListener('click' , function(){
            // alert();
            modalWindow.style.display = 'none';
            contentContainerSelector.style.overflowY = 'hidden';
            bodySelector.style.overflow = 'scroll';
        });
        
    });

    
}

useful_things_button();
{
    let someButtons = document.querySelectorAll('.theme-line-flex-item a:not(.empty)');
    
    
    someButtons.forEach((item , i , arr) => {
        /* fetch('http://egorsukhachev.com' , {

        }).then(); */


        item.onclick = () => {

            /* return 0 ; */
            
            if(item.innerText !== 'Эксклюзив') {
                return 0 ;
            }
            
            let modal = document.querySelector('#superDuperNewModalWindow');
            modal.style.display = 'block' ;

            let toLoad_mainContainer = document.querySelector('#superDuperNewModalWindow-toLoad-container');

            /* ---------------------------------------------------------- */
            
            let closeButton = document.querySelector('#superDuperNewModalWindow-closeButton');
            closeButton.onclick = () => {
                modal.style.display = 'none' ;
            }

            /* ---------------------------------------------------------- */
            
            fetch('http://egorsukhachev.com/page_the_my_profile/exclusive_TheSection/exclusive_theHandler.php' , {
                method: 'POST',
                headers: {
                // 'Content-Type': 'application/json;charset=utf-8'
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                } , 
                body: `x=y&y=x`
            }).then(resp => resp.text()).then((text) => {
                

                toLoad_mainContainer.innerHTML = text ;




            });

            
        } ;
        
        // alert();

    });
}
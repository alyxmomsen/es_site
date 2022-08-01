class myProfileWearButtonClick {

    _button;
    _modalWindow;
    _container;
    _elem_ID;
    _newScript;


    constructor() {

        this._button = document.querySelectorAll('.theme-line-flex-item');
        this._d_a = document.querySelectorAll('.theme-line-flex-item > a');
        this._modalWindow = document.querySelector('#module_myProile-modal');

        for (let elem of this._d_a) {
            elem.addEventListener('click', (e) => {
                e.preventDefault();
            });
        }

        for (let elem of this._button) {
            /* --------------------------------------------- */
            if(elem.childNodes[0].innerHTML === 'Эксклюзив') {
                continue;
            }

            if(elem.childNodes[0].innerHTML === 'Дневник') {
                continue;
            }

            /* --------------------------------------------- */

            elem.addEventListener('click' , (e) => {
                let ar = elem.id.split('-');
                // console.log(e.target);
                if(e.target.classList.contains('empty')) {
                    return 0;
                }
                // console.log(ar[2]);
                this._elem_ID = ar[2];
                this._modalWindow.style.display = 'block';
                this.getContent(this._elem_ID);
            });

            // console.log(elem.id);



            // ar.forEach((item , i , ar) => {
            //     console.log(ar[i]);
            // });



        }

    }

    getContent (el_ID) {
        let string = '../my_profile_php_handlers/handler_myProfile_content_' + el_ID +'.php';
        // alert(string);
        let xhr9 = new XMLHttpRequest();
        xhr9.open('POST' , '../my_profile_php_handlers/handler_myProfile_button' + el_ID +'.php');
        let that = this;
        xhr9.addEventListener('readystatechange' , function() {
            if (xhr9.readyState === 4 && xhr9.status === 200) {
                document.querySelector('#myProfile-container').innerHTML = xhr9.response;
                // console.log(xhr9.response);
                that.positionOnTheView () ;
                if(that._newScript) {
                    that._newScript.remove();
                }
                // создание нового элемента скрипт после загрузки контента
                that._newScript = document.createElement('script');
                that._newScript.src = 'http://egorsukhachev.com/javaScript/linkScript_' + el_ID + '.js?v=20210922_1910';
                document.querySelector('#scriptBlock').innerHTML = '';
                document.querySelector('#scriptBlock').append(that._newScript);

            }
        });
        xhr9.send();
        // alert();
    }

    positionOnTheView () {
        document.querySelector('body').style.overflow = 'hidden';
        document.querySelector('#my_profile').scrollIntoView();
    }


    click () {
        // alert();
    }
}

let mpwbc = new myProfileWearButtonClick();
// mpwbc.click();
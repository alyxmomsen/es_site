<div id="module_myProile-modal">
    <div class="button-myProfile-close"><span class="inner">X</span></div>
    <div id="myProfile-container">

    </div>
</div>

<style>

    @keyframes faiding {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes rotater {
        from {
            transform: rotateY(45deg);
        }

        to {
            transform: rotateY(0deg);
        }
        
    }

    #module_myProile-modal {
        display: none;
        position: absolute;
        top: 0;
        height: 96vh;
        left: 0;
        width: 100%;
        background-color: whitesmoke;
        z-index: 99;
        animation: faiding .2s ease-out;
        overflow: auto;
        padding: 19px;
        perspective: 500px;
    }

    #myProfile-container {
        /*width: 80%;*/
        height: 100%;
        overflow: auto;
        margin: 0 auto;
        scrollbar-color: black grey;
        scrollbar-width: thin;
        animation: rotater .2s ease-out forwards;
        transform-style: preserve-3d;
    }

    #module_myProile-modal .button-myProfile-close {
        position: absolute;
        top: 19px;
        right: 27px;
        width: 19px;
        height: 19px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
    }

    #module_myProile-modal .button-myProfile-close span.inner {
        transition: .2s ease-out;
    }


    #module_myProile-modal .button-myProfile-close span.inner:hover {
        transform: rotate(180deg);
        color: inherit;
    }

    



</style>

<script>
    class MyProfileModalWindowManager {
        _closeButton;

        constructor() {
            this._closeButton = document.querySelector('#module_myProile-modal .button-myProfile-close');
            this._closeButton.addEventListener('click' , () => {
                console.log('closeButton');
                document.querySelector('#myProfile-container').innerHTML = '';
                document.querySelector('#module_myProile-modal').style.display = 'none';
                document.querySelector('body').style.overflow = 'scroll';
            });


        }



    }

    let mwm = new MyProfileModalWindowManager();
    // mwm.positionOnTheView();
</script>

<!--<script src="http://egorsukhachev.com/javaScript/testScript.js?v=9879880000" ></script>-->
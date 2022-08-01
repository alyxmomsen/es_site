class HumorVideoManader {

    _item;

    constructor() {
        this._item = document.querySelectorAll('div.container-playlist div span');

        // for (const argumentsKey in this._item) {
        //     argumentsKey;
        // }


        this._item.forEach(function (item) {
            console.log(item.attributes[0].textContent);

            item.addEventListener('click' , () => {
                if(item.attributes[0].textContent === 'local') {
                    let displayElement = document.querySelector('#container-videoPlayer .container-display');
                    let videoNode = document.createElement('video');
                    // displayElement.innerHTML = item.attributes[1].textContent;
                    videoNode.src = item.attributes[1].textContent;
                    videoNode.setAttribute('width', '100%');
                    videoNode.setAttribute('height', '100%');
                    videoNode.setAttribute('object-fit', 'contain');
                    videoNode.setAttribute('controls', 'controls');
                    displayElement.innerHTML = '';
                    displayElement.append(videoNode);
                }
                else {
                    if(item.attributes[0].textContent === 'ytb') {
                        let displayElement = document.querySelector('#container-videoPlayer .container-display');
                        displayElement.innerHTML = item.attributes[1].textContent;
                        // displayElement.append(videoNode);
                    }
                }

            })
        });
        console.log(this._item);

    }


    displ () {
        // let
        console.log('displ')
    }
}

let someVar;

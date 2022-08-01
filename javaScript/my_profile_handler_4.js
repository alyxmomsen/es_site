class VideoPlayer {

    _elem;
    _button_prev;
    _button_next;

    constructor () {
        this._elem = document.querySelector('#video-player .video-display');
        this._button_prev = document.querySelector('#video-player .button-prev');
        this._button_next = document.querySelector('#video-player .button-next');
    }

    _currentVideoID = 0;

    _playlist = [
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/Q5MwLSLG03I" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/HE7mLZbPL94" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/tlX02nrka9Y"' +
        ' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315px" src="https://www.youtube.com/embed/FgdV_CyFqk0"' +
        ' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315px" src="https://www.youtube.com/embed/0JV9GxCSQOA"' +
        ' title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/VfybiIgyjYs" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' ,
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/WAFhBZKo110" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/kNglnWl2koo" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/IzqrmdaVkxg" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/8nYlEY4FPs8" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/A9sruPx053c" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
        '<iframe width="100%" height="315" src="https://www.youtube.com/embed/2wsLblbaj2I" ' +
        'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; ' +
        'clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
    ]

    getNextVideo () {

        let that = this;
        this._button_prev.addEventListener('click' , function () {
            if(that._currentVideoID <= 0) {
                that._currentVideoID = that._playlist.length - 1;
            }
            that._elem.innerHTML = that._playlist[--that._currentVideoID];

        });
        this._button_next.addEventListener('click' , function () {
            if(that._currentVideoID >= that._playlist.length - 1) {
                that._currentVideoID = 0;
            }
            that._elem.innerHTML = that._playlist[++that._currentVideoID];

        });


    }

}

let myVar;
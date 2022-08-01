$(document).ready(function () {
    var sliderRoot = $("div#theBlogSlider");
    var sliderCentral;// = $(sliderRoot).find("div.slider-tape-item.central");
    var leftElement = $(sliderCentral).prev();
    // $(leftElement).css("display","none");
    var rightElement;// = $(sliderCentral).next();
    // alert($(rightElement).innerHTML);


    $(sliderRoot).click(function () {
        // var sliderRoot = $("div#theBlogSlider");
        sliderCentral = $(sliderRoot).find("div.slider-tape-item.central");
        rightElement = $(sliderCentral).next();
        // alert($(rightElement).innerHTML);
        $(rightElement).css("right","-50%");
        $(sliderCentral).toggleClass("left-stack",true).toggleClass("central",false);
        $(rightElement).toggleClass("central",true).toggleClass("left-stack",false);
        alert();
    });
});
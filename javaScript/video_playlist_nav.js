$(document).ready(function (){

    $('div#video_page_container').delegate('a.flex_item','click',function(e){
        e.preventDefault();
        var this_object = $(this);
        var this_url = this_object.attr('href');
        $.ajax({
            type: "POST",
            url: './video_handler.php',
            data: {'url': this_url},
            success: function (data) {
                // alert();
                $('div#video-player').html(data);
                $video_elem = $('div#video-player > video');
                $video_elem[0].play();
            }
        });
    });

    $('div#video_page_container').delegate('div.flex_item','mouseleave',function(e){
        // $(this).html('leave');
    });
});
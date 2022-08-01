$(document).ready(function () {
    var obj = $('div#normal_size_photo_loader');

    $('div#landingMain').delegate('.click_img' , 'click' , function(){
        
        var src = $(this).attr('src');
        var element_object = $(this).parent().find('.tag.base');
        var base_tag;
        for(var i = 0 ; i < element_object.length ; i++)
        {
            
            if(element_object.attr('class') === 'tag base')
            {
                // alert(element_object.text());
                base_tag = element_object.text();
                break;
            }
        }
        var someData = {
            'base_tag': base_tag,
            'data': src,
            'type':'get_this'
        };
        obj.css('display','flex');
        $('body').css('overflow','hidden');
        $.ajax({
            type: "POST",
            url: "./some.php",
            data:someData,
            success: function(data){
                obj.children('div.container.flex-container').html(data);
            }
        });
    });

    // $(".click_img").on("click", function(){
    //     var src = $(this).attr('src');
    //     var someData = {
    //         'data': src,
    //         'type':'get_this'
    //     };
    //     obj.css('display','flex');
    //     $('body').css('overflow','hidden');
    //     $.ajax({
    //         type: "POST",
    //         url: "./some.php",
    //         data:someData,
    //         success: function(data){
    //             obj.children('div.container.flex-container').html(data);
    //         }
    //     });
    // });

    obj.delegate('div.close-button','click',function () {
       obj.css('display','none');
        $('body').css('overflow','auto');
    });

    obj.delegate('#img_viewer_right_arrow','click',function(){
        var src = $(this).parent().find('img').attr('src');
        // alert(src);
        $.ajax({
            type:"POST",
            url:'./some.php',
            data:{
                'data': src,
                'type':'next_right'
            },
            success: function (data) {
                obj.children('div.container.flex-container').html(data);
                // alert(data);
            }
        });
    });

    obj.delegate('#img_viewer_left_arrow','click',function(){
        alert('left');
    });

    $(document).ajaxSend(function(){
        $('#ajax').css('display','block');
    })
        .ajaxStop(function(){
            // $('#ajax').css('display','none');
        });

});
<?php



?>

<script>

    function q(){
        let vrbl = t;
        let dabaton = document.getElementById('the_button');
        dabaton.innerHTML = vrbl;
        clearInterval(vrbl);
    }


    var t = setInterval(() => { console.log(t)} , 2000);

    var t2 = setInterval(() => { console.log(t2)} , 500);



</script>

<button id='the_button' value="content" onclick="q();">
    content
</button>

<button id='the_button_2' value="content" onclick="q();">
    content
</button>
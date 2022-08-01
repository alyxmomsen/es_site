<div id="myProfile-myAuto">
    <div class="container">
        <div class="imgContainer">
            <img src="data/img/mandelshtam_square.jpg" alt="">
            <span class="caption">Весна, 2021 , сквер Мандельштама</span>
        </div>
        <div class="imgContainer">
            <img src="data/img/busy.jpeg" alt="">
            <span class="caption">Январь, 2021, парковка трц "Атриум"</span>
        </div>
        <div class="imgContainer">
            <img src="data/img/my_profile_my_transport_mercedes.jpeg" alt="">
            <span class="caption">Весна, 2021 , сквер Мандельштама</span>
        </div>
    </div>
</div>

<style>

    #myProfile-myAuto .container {
        display: flex;
        justify-content: center;
        gap: 9px;
    }

    #myProfile-myAuto .imgContainer {
        position: relative;
        flex: 1;
    }

    #myProfile-myAuto img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #myProfile-myAuto .caption {
        position: absolute;
        bottom: 0;
        right: 0;
        color: whitesmoke;
        text-shadow: 1px 1px 1px black;
        margin: 9px 9px;
        font-family: 'Oswald', sans-serif;
        /* font-family: 'Playfair Display', serif; */
    }

</style>
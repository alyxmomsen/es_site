<?php

require_once 'modules/class_get_all_tags.php';
?>


<div id='module_aside-panel'>
    <div class="container">
        <a href="themes.php#scroll-id-named-theme-lol">Темы</a>
        <a href="my_profile.php">Обо мне</a>
        <a href="#">Люди</a>
    </div>
    <div class="close-button"><span>X</span></div>
    <div class="hash-tag-svg">
        <svg width="48" height="48" fill="none" xmlns="">
            <path d="M44 25v-6l-6-6v6H6l6 6h32zm-2 12v-6l-6-6v6H4l6 6h32z" fill="#191919"/>
            <path d="M15 6h6l-6 32H9l6-32z" fill="#fff"/>
            <path d="M26 12l-5-6-6 32H9l5 6h6l6-32z" fill="#191919"/>
            <path d="M38 12l-5-6-6 32h-6l5 6h6l6-32z" fill="#191919"/>
            <path fill="#fff" d="M38 13v6H6v-6zm-2 12v6H4v-6z"/>
            <path d="M27 6h6l-6 32h-6l6-32z" fill="#fff"/>
        </svg>
        <div id="module_aside-panel-container-all-tags" class="all-tags">
            <?php
            global $pdo;

            $gat = new GetAllTags($pdo);
            $tags = $gat->getTags();
            $unique = [];
            $groups = [];

            foreach ($tags as $row) {
                $groups[] = $row['tags_group'];
            }

            $unique =  array_unique($groups);

            /*foreach ($unique as $row) {
                echo $row . "<br>" ;
            }*/


            foreach ($unique as $row) {
                echo "<div class='tag-group'>";
                foreach ($tags as $row2) {
                    if($row2['tags_group'] === $row) {
                        echo "<span>#$row2[name]</span>";
                    }
                }
                echo "</div>";
            }



            ?>

        </div>

    </div>

</div>


<style>
    div#module_aside-panel {
        /* display: none; */
        position: fixed;
        width: 33%;
        bottom: 0;
        right: 0;
        right: -100%;
        background-color: #191919;
        padding: 9px;
        top: 0;
        transition: .2s ease-out;
        font-family: 'Roboto', sans-serif;
        font-size: 19px;
        z-index: 9;
        display: flex;
        /*justify-content: ;*/
        flex-direction: column;
        justify-content: space-evenly;
        font-family: 'Oswald', sans-serif;
    }

    div#module_aside-panel .container {
        color: #ebecf4;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap:6px;
    }

    div#module_aside-panel .hash-tag-svg {
        display: flex;
        flex-direction: column;
        gap: 19px;
    }

    div#module_aside-panel .container a {
        text-decoration: none;
        padding-left: 0;
        transition: .2s ease-out;
        color: white;
    }


    div#module_aside-panel .container a:hover {
        text-decoration: none;
        color: inherit;
        padding-left: 9px;
    }
    /* #ce5a57 */

    #module_aside-panel-container-all-tags {
        color: #ccc;
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        align-items: flex-start;
        gap: 9px;
    }

    .tag-group {
        display: flex;
        gap: 6px;
        border: 1px solid;
        padding: 6px;
        flex-wrap: wrap;
    }

    div#module_aside-panel > .close-button {
        position: absolute;
        top: 9px;
        right: 9px;
        width: 19px;
        height: 19px;
        /* background-color: green; */
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        /* border: 1px solid black; */
        color: #ebecf4;
        transition: .2s ease-out;
    }

    div#module_aside-panel > .close-button:hover {
        transform: rotate(180deg);
        color: white;
    }


</style>


<script>
    function menu_button_click() {
        let button = document.querySelector('#module_menuButton');
        let asidePanel = document.querySelector('#module_aside-panel');
        // console.log(asidePanel);
        let handler = function () {
            
            console.log(asidePanel);
            asidePanel.style.right = '0';
        }

        button.addEventListener('click' , handler);
    }

    function aside_close_button_click () {
        let closeButton = document.querySelector('#module_aside-panel > div.close-button');
        let asidePanel = document.querySelector('#module_aside-panel');

        let handler = function () {
            
            console.log(asidePanel);
            asidePanel.style.right = '-100%';
        }

        closeButton.addEventListener('click' , handler);
    }

    menu_button_click();
    aside_close_button_click();
</script>


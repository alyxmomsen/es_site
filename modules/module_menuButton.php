<div id="module_menuButton">
    <div class="menu-button">
        <span class='inner'>Меню</span>
    </div>
</div>

<style>

#module_menuButton {
	position: absolute;
	bottom: 9px;
	right: 19px;
	--width: 99px;
	width: var(--width);
	margin: 0;
	padding: 0;
	height: auto;
    cursor: pointer;
}

#module_menuButton > div.menu-button {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    /* height: var(--width); */
    height: auto;
    background-color: grey;
    transition: background-color .1s linear;
    /* display: none; */
    /* visibility: hidden; */
    box-shadow: 0 0 9px grey;
    border-radius: 6%;
    font-size: 19px;
    color: #ebecf4;
    align-items: center;
    font-family: 'Oswald', sans-serif;
}

</style>



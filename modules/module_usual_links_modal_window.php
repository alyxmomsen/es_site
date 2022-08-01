<?php 

class usualLinksManager {

    protected $pdo ;
    public $links  = NULL;

    function __construct ($pdo) {
        $this->pdo = $pdo ;
    }

    function getLinks ($queryStr) {
        $queryStr = "SELECT * FROM usual_links" ;
        $statement = $this->pdo->prepare($queryStr) ;
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->links = $result ;
        return $result ;
    }
}


require_once 'db_connect.php' ;
global $pdo ;

// echo 'check' ;

$ulm = new usualLinksManager ($pdo) ;
$ulm->getLinks('');

?>
<div id='module_usual_links_modal_window'>
    <div class='u-l-m-w-close-button'>X</div>
    <div class='u-l-m-w-wrapper'>
        <div class='u-l-m-w-inner left'>
        <?php 
        
        // foreach ($ulm->links as $item) {
        //     echo '<br>' . $item['id'] ;
        // }


        // var_dump($ulm->links);


        for($i = 0 ; $i < count($ulm->links) ; $i++ ) {

            if(($i + 2) % 2 === 0 ) {
                echo "<a target='_blank' href='{$ulm->links[$i]['href']}'>{$ulm->links[$i]['toDisplay']}</a>" ;
            }
        }

        echo '</div>' ;
        echo '<div class="u-l-m-w-separator"></div>' ;
        echo '<div class="u-l-m-w-inner right">' ;

        for($i = 0 ; $i < count($ulm->links) ; $i++ ) {

            if(($i + 2) % 2 !== 0 ) {
                echo "<a target='_blank' href='{$ulm->links[$i]['href']}'>{$ulm->links[$i]['toDisplay']}</a>" ;
            }
        }
        
        ?>
        </div>
    </div>
</div>
<style>

div#module_usual_links_modal_window {
	background-color: #d2d2d2;
	color: black;
	/* display: none; */
	/* visibility: hidden; */
	position: absolute;
	top: 6%;
	left: 0;
	width: 100%;
	height: 79%;
	padding: 9px;
	display: flex;
    display: none ;
	flex-direction: column;
	justify-content: center;
}

div#module_usual_links_modal_window a {
	transition : .2s ease-out ;
}

div#module_usual_links_modal_window a:hover {
	color : inherit ;
}

.u-l-m-w-wrapper {
	display: flex;
	gap: 14px;
}

.u-l-m-w-inner {
	display: flex;
	flex-direction: column;
	/* border: 1px solid black; */
	flex: 1;
}

.u-l-m-w-inner.left {
	align-items: flex-end;
}

.u-l-m-w-inner.left a:hover {
	padding-right : 9px ;
}

.u-l-m-w-inner.right {
	align-items: flex-start;
}

.u-l-m-w-inner.right a:hover {
	padding-left : 9px ;
}

.u-l-m-w-separator {
	width: 2px;
	background-color: grey;
}

.u-l-m-w-close-button {
	position: absolute;
	width: 19px;
	height: 19px;
	/* background-color: black; */
	top: 9px;
	right: 9px;
	/* border: 1px solid; */
	display: flex;
	justify-content: center;
	align-items: center;
	cursor: pointer;
    transition : all .2s ease-out ;
}

.u-l-m-w-close-button:hover {
    transform : rotate(180deg);
}

</style>
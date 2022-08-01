<?php

require_once '../db_connect.php';
global $pdo;

class AboutMeContentOrganizationsManager {

    protected $statementString = "SELECT organization.* FROM organization ORDER BY description ASC";
    protected $pdo;
//    protected $result;


    function __construct ($pdo) {
        $this->pdo = $pdo;
    }

    function getOrganisations() {
        $statement = $this->pdo->prepare($this->statementString);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC); /* PDO::FETCH_ASSOC == 2 */
        return $result;
    }

}

$AMCOM = new AboutMeContentOrganizationsManager($pdo);

?>
<div id="aboutMe-content-organizations">
    <div class="container">
        <?php
        foreach ($AMCOM->getOrganisations() as $row) {
            echo "<div class='thisOrg-container'>";

            echo "<span>$row[title]</span><span> </span><span><a href='$row[src]' target='_blank'>$row[description]</a></span>";

            echo "</div>";
        }

        ?>
    </div>
</div>
<style>
    #aboutMe-content-organizations .container {
        /* display: none; */
        display: flex;
        flex-direction: column;
        width: 52%;
        align-content: stretch;
        font-size: 18px;
    }

    #aboutMe-content-organizations .thisOrg-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        transition-property: padding-left , padding-right;
        transition-duration: .2s , .2s ;
        transition-timing-function: ease-out , ease-out;
        padding: 6px 0;
        font-family: 'Playfair Display', serif;
    }

    #aboutMe-content-organizations .thisOrg-container a:hover {
        color: inherit;
    }

    #aboutMe-content-organizations .thisOrg-container:hover {
        /*border: 1px solid black;*/
        background-color: grey;
        color: whitesmoke;
        padding: 6px;
    }

</style>
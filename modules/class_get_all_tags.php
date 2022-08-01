<?php

require_once 'db_connect.php';

class GetAllTags {

    protected $pdo;

    protected $queryString = "SELECT * FROM `hash_tags` ORDER BY hash_tags.tags_group ASC";

    function __construct ($pdo) {
        $this->pdo = $pdo;
    }

    public function getTags () {
        $statement = $this->pdo->prepare($this->queryString);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}



?>


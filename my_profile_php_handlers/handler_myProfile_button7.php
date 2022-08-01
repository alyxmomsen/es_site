<div id='musician-module'>
<?php 

require_once '../db_connect.php';

?>

<?php 

global $pdo;

$musicans_statement = $pdo->prepare("SELECT * FROM `musicians`");

$musicans_statement->execute();

$result = $musicans_statement->fetchAll(PDO::FETCH_ASSOC);

$creatures_statement = $pdo->prepare("SELECT creatures.* FROM creatures where artist_id = ?");

$somedate = '';

foreach($result as $row) {

    echo "<div class='musician-item'>";

    // ахуительно работает нижеследующая функция
    // $date = "31 октября 1953";
    // print_r(date_parse_from_format("j.n.Y H:iP", $date));
    echo "<div class='left-column'>";
    
    echo "<div class='img-container'><img src='http://www.egorsukhachev.com/$row[img_path]' alt=''></div>" ;

    echo "</div>";

    echo "<div class='right-column'>";
    echo "<div class='fio-container'><span class='surname'>$row[fio]</span></div>" ;
    echo "<div class='about-container'><span class='about'>$row[about]</span></div>" ;

    if($row['kind'] === 'band'):
        echo "<div class='born-container'><span class='born'>дата создания: $row[born]</span>";
    else:
        echo "<div class='born-container'><span class='born'>родился: $row[born]</span>";
    endif;

    echo "</div>" ;

    if($row['died']) {
        if($row['kind'] === 'band'): 
            echo "<div class='died-container'><span class='died'>распалась: $row[died]</span></div>";
        else:
            echo "<div class='died-container'><span class='died'>умер: $row[died]</span></div>";
        endif;
    }
    
    $creatures_statement->execute([$row['id']]);
    $cretures_result = $creatures_statement->fetchAll(PDO::FETCH_ASSOC);

    if($cretures_result) {

        echo "<div class='music-container'><span class='mainTitle'>песни:</span><br>" ;
        echo "<div class='music-box'>";

        // $creatures_statement->execute([$row['id']]);

        // $cretures_result = $creatures_statement->fetchAll(PDO::FETCH_ASSOC);
        echo '<ul>';
        foreach($cretures_result as $rows) {
            echo "<li><a href='$rows[src]' target='_blank'>$rows[title]</a></li>" ;
        }

        echo '</ul>';
        echo "</div>" ;
        echo "</div>" ;
        echo "</div>";
        echo "</div>";
    }
}

?>
</div>
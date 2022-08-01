<?php
require 'db_connect.php';
global $pdo;
$request_data = $_POST['data'];
$base_tag = $_POST['base_tag'];
switch ($_POST['type'])
{
    case 'next_left':
        break;
    case 'next_right':
        break;
    case 'get_this':
        $resp = $pdo->prepare("select * from images where path=?");
        $row = $resp->execute([$request_data]);
        $item = $resp->fetchall(PDO::FETCH_ASSOC);
        // var_dump($item);
        echo "<img class='disapear' src='" . $item[0]['path'] . "'>";
        echo "<div class='right-site-flex-container right-flex-item'>";
        echo "<h3 class='egors-comment'>" . $item[0]['commentary'] . "</h3>";
        $foo = function($arr, $b_tag)
        {
            $hash_tag_result_arr = array();
            $ht_arr = explode(' ' , $arr);
            foreach($ht_arr as $value)
            {
                if($value === $b_tag) $hash_tag_result_arr[] = "<a class='tag base' href='landing.php?tag=$value'>#$value</a>";
                else $hash_tag_result_arr[] = "<a class='tag' href='landing.php?tag=$value'>#$value</a>";
            }
            return implode(' ' , $hash_tag_result_arr);
        };
        echo "<div class='hsh-tgs'>" . $foo($item[0]['hash_tags'] , explode('#', $base_tag)[1]) . "</div>";
        echo "</div>";
        echo "<div class='close-button'><div class='the-pic'>X</div></div>";
        $previous = $pdo->prepare("select path from images where (id < {$item[0]['id']}) and (hash_tags like '%" . explode('#', $base_tag)[1] . "%') order by id desc limit 1");
        $previous->execute();
        $result = $previous->fetch(PDO::FETCH_COLUMN);
        if($result) echo "<div src='" . $result . "' class='nav-arrow left click_img'><div class='arrow-object left'></div></div>";
        $previous = $pdo->prepare("select path from images where (id > {$item[0]['id']}) and (hash_tags like '%" . explode('#', $base_tag)[1] . "%') order by id limit 1");
        $previous->execute();
        $result = $previous->fetch(PDO::FETCH_COLUMN);
        if($result) echo "<div src='" . $result . "' class='nav-arrow right click_img'><div class='arrow-object right'></div></div>";
        break;  
}
//echo

/*echo '<pre>';
print_r($item[0][path]);
echo '<pre>';*/

?>
<?php
require_once 'db_connect.php';

function get_the_value($interval)
{
    $result = time()/$interval;
    settype($result,'int');
    return (int)rand(1,5);
}

function setQuotesIntoTheHeader($interval = 5)
{
  
    if(isset($GLOBALS['pdo']))
    {
        $pdo = $GLOBALS['pdo'];
        $query = 'select * from quotes';
        get_the_value($interval);
        $res = $pdo->query($query);
        $data = $res->fetchall(PDO::FETCH_ASSOC);
        // $this_item = rand(0 , count($data)-1);
        // $result_string = "<p class='quote ru'><span>".$data[$this_item]['content']."</span></p>";
        // $result_string .= "<p class='quote count'><span>" . ($this_item + 1) . "/" . count($data) . "</span></p>";
        
        $f = function($isTrue = 0)
        {
            if(!$isTrue)
            {
                return ' active';
            }
        };

        $the_str = "

            <div id='quotesSlider' class='carousel slide' data-ride='carousel'>
            
            <div class='carousel-inner'>

        ";

        


        for($ind = 0 ; $ind < count($data) ; $ind++)
        {
            $the_str .= 

            "

                <div class='carousel-item {$f($ind)}'>
                    <p class='quote ru'>{$data[$ind]['content']}</p>
                </div>
            
            ";

        }

            
        $the_str .= "
        
        </div>
        <ol class='carousel-indicators'>
            <li data-target='#quotesSlider' data-slide-to='0' class='active'></li>
            <li data-target='#quotesSlider' data-slide-to='1'></li>
            <li data-target='#quotesSlider' data-slide-to='2'></li>
        </ol>
        </div>
        
        ";


        return $the_str;


    }
    else
    {
        return "isnt";
    }
}



function insertQuote($data,$eng_data,$direct)
{
    if($GLOBALS['pdo']) echo 'global pdo var is exist';
    $pdo_insert_query_string = "insert ignore into quotes (content,content_eng,show_when) values (?,?,?)";
    $prepared_insert_query = $pdo->prepare($pdo_insert_query_string);
    $prepared_insert_query->execute([]);
}

// insertQuote();

// echo setQuotesIntoTheHeader();
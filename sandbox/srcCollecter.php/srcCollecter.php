<?php 

class SrcCollecter {

    protected $pdo = '' ;


    function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=ci18760_egor;cahrset=utf8", 'ci18760_egor', 'h3S3YW6y');
    }

    function getRows ($themeID) {
        $statement = $this->pdo->prepare("SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(news.source_from, '/', 3), '://', -1), '/', 1), '?', 1) AS domain from news , news_theme WHERE news.id = news_theme.news_id AND news_theme.theme_id = ?;");
        $statement->execute([$themeID]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result ;
    }



}

$sc = new SrcCollecter () ;
echo '<pre>' ;
$rows = $sc->getRows(22088) ;
echo '<pre>' ;

$domain = $_GET['t'];

foreach ($sc->getRows($domain) as $rws) {
    echo '<br>' . $rws['domain'] ;
}


?>
<div>
    
</div>

<!-- SELECT DISTINCT news.source_from from news , news_theme WHERE news.id = news_theme.news_id AND news_theme.theme_id = 22088; -->
<!-- SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(news.source_from, '/', 3), '://', -1), '/', 1), '?', 1) AS domain from news , news_theme WHERE news.id = news_theme.news_id AND news_theme.theme_id = 22088; -->
<!-- 

domain 	
r-19.ru
www.youtube.com
19rus.info
gazeta19.ru
abakan-news.ru
khakasia.info
xakac.info
tvrts.ru
zapad24.ru
newslab.ru
ctv7.ru

 -->
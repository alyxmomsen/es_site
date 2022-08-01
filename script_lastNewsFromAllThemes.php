<?php

class LastNewsByAllThemes {

    protected $pdo;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

//    function pdoHelperOne () {
//        $statement = $this->pdo->prepare("");
//        $statement->execute();
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//        return 0;
//    }


    function getActualThemes () {

        $statement = $this->pdo->prepare("SELECT themes.* FROM themes WHERE themes.reserve = '' AND themes.disabled = 'true' ");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    function getLastNewsByThemeID () {

        $lastNewsArr = [] ;

        $themes = $this->getActualThemes();

        foreach ($themes as $row) {
            $statement = $this->pdo->prepare("SELECT news.* , themes.* FROM news , themes , news_theme WHERE themes.id = $row[id] 
                                                AND news_theme.theme_id = themes.id 
                                                AND news_theme.news_id = news.id ORDER BY cdt DESC LIMIT 3  ");
            $statement->execute();
            $lastNewsArr[] = $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $lastNewsArr;

    }





}

require_once 'db_connect.php';
global $pdo;


$lnbat = new LastNewsByAllThemes($pdo);
$lastNews = $lnbat->getLastNewsByThemeID();

$tempArr = [];
$nowDate = 0;
$lastDate = 0;


foreach ($lastNews as $id => $row) {
    $tempArr[$row[0]['cdt']] = [$row[0]['cdt'] , $row[0]['theme_name']] ;


}

sort($tempArr) ;

$filter = [
    'Катастрофа в Крымске в 2012г' ,
    'Авиакатастрофа под Смоленском 2010г.' ,
    'Взрывы в России' ,
    'Булгария, теплоход' ,
    'Взрыв в ТЦ Охотный ряд' ,
    'Взрыв на Пушкинской площади в 2000г' ,
    'Взрыв на рок-фестивале в Тушино' ,
    'Болотное дело' ,
    'Басманный рынок, обрушение' ,
    'Трансвааль, обрушение' ,
    'Брэкзит (Brexit)' ,
    'Оружие' ,
    'Эвтаназия' ,
    'Ингушское дело' ,
    'Евросоюз' ,
    'НАТО' ,
    'Итальянская мафия' ,
    'Брестская крепость' ,
    'Мексика' ,
    'Эстония' ,
    'Приморские партизаны' ,
    'Тулун, наводнение' ,
    'Мьянма' ,
    'Будёновск, заложники' ,
    'Землетрясение в Нефтегорске' ,
    'США' ,
    'Взрыв в порту Бейрута' ,
    'Торговля детьми' ,
    'Оккупай Абай' ,
    'Арабская весна' ,
    'Бездомный полк' ,
    'Августовский путч 1991г' ,
    'Октябрьский переворот 1993г' ,
    'Подростки' ,
    'Хатанга' ,
    'Катастрофа  в Шереметьево' ,
    'Массовые убийства' ,
    'Жертвы режима' ,
    'Беслан' ,
    'Взрыв в УФСБ Архангельска' ,
    'Взрывы в Волгограде' ,
    'Взрыв в автобусе в Воронеже' ,
    'Финансовые пирамиды в России' ,
    'Преступления врачей' ,
    'МН17' ,
    'Взрыв в Ижевске' ,
    'Полиция' ,
    'Гибель 24 десантников' ,
    'Инструмент' ,
    'Авиакатастрофа под Ярославлем' ,
    'Взрывы в Московских домах на улицах Гурьянова и Каширское шоссе' ,
    'Авиакатастрофа под Иркутском' ,
    'Взрыв газа в Магнитогорске' ,
    'Индонезия' ,
    'Беларусское посольство в Москве' ,
    'Взрыв газа в Ногинске' ,
    'Шиес' ,
    'Фальшивомонетчики' ,
    'Россия за рубежом' ,
    'Гибель хора Александрова' ,
    'Война в Югославии' ,
    'Навальный' ,
    'Мемориал Б. Немцова' ,
    'Холокост' ,
    'Робот' ,
    'Протест' ,
    'СССР' ,
    'Суррогатное материнство' ,
    'Техника' ,
    'Шаман Габышев' ,
    'Путлерюгент' ,
    'Аварии АЭС' ,
    'Пожары в России' ,
    'Путинизм' ,
    'Афганистан' ,
    'Мир' ,
    'Дебилы' ,
    'Церковь' ,
    'Эксклюзив' ,
    'Главное за сегодня' ,
    'Казахстан',
    'Украина' ,
    'Беларусь' ,
    'Коронавирус, дети' ,
    'Россия' ,
    'Бразилия' ,
    'Коронавирус' ,
    'Куштау' ,
    'Алжир' ,
    'Годовщина' ,
    '' ,
//    '' ,
];



$isMatch = [];
$counter = 0;

echo "<pre>" ;
//print_r($tempArr) ;
foreach ($tempArr as $id => $row) {
    foreach ($filter as $filterTheme) {
        if($filterTheme === $row[1]) {
            $isMatch[] = 'match';
        }
    }

    if(!count($isMatch)) {
//        echo 'alert';
        if(date_parse($lastDate)['year'] < date_parse($row[0])['year'] || date_parse($lastDate)['month'] < date_parse($row[0])['month']) {
            echo date_parse($row[0])['year'] . "-" . date_parse($row[0])['month'] . "<br>";
        }
    }

    if(!count($isMatch)) {



        echo "{$row[0]} :  {$row[1]}<br>" ;
        $counter++ ;
    }

    $isMatch = array();
    $lastDate = $row[0];

}
//print_r($lastNews);
echo "<br>всего: $counter<br>" ;
echo "</pre>" ;


?>


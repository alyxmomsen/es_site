<?php


require_once 'db_connect.php';
global $pdo;

class MyCalendar {
    protected $pdo;

    protected $pdoRows;

    const FIRST_DAY_DATE_OF_THE_MONTH = 1;
    const A_WEEK_AMOUNT = 7;
    const OPEN_TO_ITERATION = true;
    const CLOSE_TO_ITERATION = false;
    protected $theNowDate = '';
    protected $theSomeDate = '';
    protected $ruStyleDaysNames = [1 => 'Пн' , 'Вт' , 'Ср' , 'Чт' , 'Пт' , 'Сб' , 'Вс'];
    protected $rusStyleMonthesNames = [
        1 => 'январь' , 'февраль' , 'март' , 'апрель' , 'май',
        'июнь' , 'июль' , 'август' , 'сентябрь' , 'октябрь' , 'ноябрь' , 'декабрь'
    ];
    function __construct($year = NULL , $month = NULL , $day = NULL , $pdo) {
        $this->pdo = $pdo;



        $this->theNowDate = new DateTime();
        $this->theSomeDate = new DateTime();

        if($year) {
            $this->theSomeDate->setDate($year , $month , $day);
//            $this->theNowDate->setDate($year , $month , $day);
        }

        $this->theSomeDate->setDate(
            $this->theSomeDate->format('Y') ,
            $this->theSomeDate->format('m') ,
            1
        );

    }

    function getRowsFromDB () {
        $theDate = new DateTime();



        $statement = $this->pdo->prepare("SELECT * FROM `news` WHERE cdt LIKE '%{$theDate->format('Y')}-{$theDate->format('m')}%'");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->pdoRows = $result;

        return $result;
    }

    function getDaysNames () {
        for($i = 0 ; $i < count($this->ruStyleDaysNames); $i++) {
            yield $this->ruStyleDaysNames[$i + 1];
        }
    }

    function getMonthByNumber($number) {
        return $this->rusStyleMonthesNames[$number];
    }


    function getNowDate() {
        return $this->theNowDate->format('d');
    }

    function fetcher( $local , $fromDB  = []) {

        foreach ($this->pdoRows as $row) {
            $dateTimeArr = explode(' ' , $row['cdt']);
            $dateArr = explode('-' , $dateTimeArr[0]);
            if($dateArr[2] == $local) {
                return true;
            }
        }

        return false;
    }

    function rowsIteratorManager () {
        $ar = array();

        $costyl = self::OPEN_TO_ITERATION;
        $temp = '';

        do {
            $ar = array();
            if($this->theSomeDate->format('N') > self::FIRST_DAY_DATE_OF_THE_MONTH && $costyl) {
                for ($i = 1 ; $i < $this->theSomeDate->format('N') ; $i++) {
                    $ar[] = ['' , NULL];
                }

                $thisNameDayCount = $this->theSomeDate->format('N');
                while ($thisNameDayCount < self::A_WEEK_AMOUNT + 1) {
                    if($this->theSomeDate->format('j') == $this->theNowDate->format('j')) {
                        $isSameDay = 'this-day';
                    }
                    else {
                        $isSameDay = '';
                    }
                    /*echo $isSameDay;*/
                    $ar[] = [$this->theSomeDate->format('j') , $isSameDay ,
                        [
                            'year' => $this->theSomeDate->format('Y') ,
                            'month' => $this->theSomeDate->format('n') ,
                            'day' => $this->theSomeDate->format('j')
                        ]] ;
                    $this->theSomeDate->setDate($this->theSomeDate->format('Y') , $this->theSomeDate->format('m') , $this->theSomeDate->format('d') + 1) ;
                    $thisNameDayCount++;
                }
                $costyl = self::CLOSE_TO_ITERATION;
            }
            else {

                $thisNameDayCount = $this->theSomeDate->format('N');
                while ($thisNameDayCount < self::A_WEEK_AMOUNT + 1) {

                    if($this->theSomeDate->format('m') == $this->theNowDate->format('m')) {
                        if($this->theSomeDate->format('j') == $this->theNowDate->format('j')) {
                            $isSameDay = 'this-day';
                        }
                        else {
                            $isSameDay = '';
                        }
                        $ar[] = [$this->theSomeDate->format('j') , $isSameDay ,
                            [
                                'year' => $this->theSomeDate->format('Y') ,
                                'month' => $this->theSomeDate->format('n') ,
                                'day' => $this->theSomeDate->format('j')
                            ]] ;
                        $this->theSomeDate->setDate($this->theSomeDate->format('Y'), $this->theSomeDate->format('m'), $this->theSomeDate->format('d') + 1);
                        $thisNameDayCount++;

                    }
                    else {
                        $ar[] = ['' , ''];
                        $this->theSomeDate->setDate($this->theSomeDate->format('Y'), $this->theSomeDate->format('m'), $this->theSomeDate->format('d') + 1);
                        $thisNameDayCount++;
                    }
                }

            }

            yield $ar;

        } while ($this->theSomeDate->format('d') > 1 && $this->theSomeDate->format('m') == $this->theNowDate->format('m'));

    }

    function getTheMonth () {
        return $this->theNowDate->format('n');
    }

    function getTheYear () {
        return $this->theNowDate->format('Y');
    }
}

$myCal = new MyCalendar(2022 , 1 , 10 , $pdo);
$myCal->getRowsFromDB();
//echo MyCalendar::FIRST_DAY_DATE_OF_THE_MONTH;
 
?>

<div id="module-calendar">
    <div id="module-calendar-cal-body">
        <div class="cal-body-row">
            <div class="month-year-selector month-selector" data-month="<?= $myCal->getTheMonth() - 1 ?>">
                <span class="arrow to-left">‹</span>
                <span class="month-display" data-month-value=""><?= $myCal->getMonthByNumber($myCal->getTheMonth())?></span>
                <span class="arrow to-right">›</span>
            </div>
            <div class="month-year-selector year-selector" data-year="<?= $myCal->getTheYear() ?>">
                <span class="arrow to-left">‹</span>
                <span class="year-display" data-year-value=""><?= $myCal->getTheYear() ?></span>
                <span class="arrow to-right">›</span>
            </div>
        </div>
        <div class="cal-body-row splitter">
            <div></div>
        </div>
        <div class="cal-body-row days-names">
            <?php

            foreach ($myCal->getDaysNames() as $row) {
                echo "<div class='day-name name'><span>$row</span></div>";
            }

            ?>
        </div>
        <div id="module-calendar-numbers">
            <?php

            foreach ($myCal->rowsIteratorManager() as $row) {
                echo "<div class='cal-body-row'>";
                foreach ($row as $item) {
//                    var_dump($item[2]);
                    echo "<a class='day-name date";
                    echo " {$item[1]}";
                    if($myCal->fetcher($item[0])) echo " fill'";
                    else echo "'";
//                    var_dump($item[2]);
                    if($myCal->fetcher($item[0])) echo "href='http://egorsukhachev.com/time_machine.php?year=" . $item[2]['year'] . "&month=" . $item[2]['month'] . "&day=" . $item[2]['day'] . "'";
                    echo "><span>$item[0]</span></a>";
//                    var_dump($item[2]['year']);
                }
                echo "</div>";
            }

            ?>
        </div>
    </div>
</div>

<style>
    div#module-calendar {
        box-sizing: border-box;
        padding: 9px;
        margin: 0 auto;
        /*max-width: 666px;*/
        width: 100%;
    }

    #module-calendar-cal-body {
        width: auto;
        display: flex;
        flex-direction: column;
        gap: 6px;
        background-color: black;
        padding: 18px 0;
    }

    div#module-calendar div.splitter {
        /* border: 1px solid #5b5b5b; */
        width: 91%;
        align-self: center;
        opacity: 0.4;
        margin: 16px 0;
        /* flex-basis: 30px; */
        position: relative;
        display: flex;

    }

    div#module-calendar div.splitter > div {
        /* display: ; */
        /* position: absolute; */
        /* top: 0; */
        /* left: 0; */
        border: 1px solid #5b5b5b;
        width: 87%;
    }

    #module-calendar-numbers {

        display: flex;
        flex-direction: column;
        gap: 6px;

    }

    div#module-calendar .arrow {
        cursor: pointer;
    }

    div#module-calendar > #module-calendar-cal-body .cal-body-row {
        display: flex;
        width: 100%;
        justify-content: space-around;
    }

    div#module-calendar .month-year-selector {
        /* border: 1px solid black; */
        /* width: 36px; */
        flex-basis: 130px;
        flex-grow: 1;
        flex-shrink: 0;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        padding: 6px 0;
        color: #d4d4d4;
    }

    div#module-calendar .day-name {
        /* border: 1px solid black; */
        /* width: 36px; */
        flex-basis: 36px;
        flex-grow: 0;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        /* padding: 16px 0; */
        /* display: none; */
        height: 36px;
    }

    div#module-calendar .day-name.date.this-day {
        background-color: #ce5a57;
        background-color: grey ;
    }

    div#module-calendar a.day-name.name {
        color: #5b5b5b;
    }

    div#module-calendar a.day-name.date {
        color: #d4d4d4;
    }


    div#module-calendar .day-name.date.fill {
        /* background-color: green; */
        border-right: 1px solid grey;
        border-bottom: 1px solid grey;
        cursor: pointer;
    }

</style>
<script>

    class myCalendar {

        _toDay;

        _theDay;
        _currentMonthCalendar;



        _monthes = [
            'январь' , 'февраль' , 'март' , 'апрель',
            'май' , 'июнь' , 'июль' , 'август' , 'сентябрь' ,
            'октябрь' , 'ноябрь' , 'декабрь'
        ];

        _targetContainer;

        _rightMonthButton;
        _leftMonthButton;
        _leftYearButton;
        _rightYearButton;

        _monthSelector;
        _yearSelector;



        constructor() {
            console.log('calendar constructor start');

            this._targetContainer = document.querySelector('#module-calendar-numbers');

            this._toDay = new Date();

            this._theDay = new Date();
            this._currentMonthCalendar = new Date();
            this._currentMonthCalendar.setDate(1);

            this._leftMonthButton = document.querySelector('div.month-year-selector.month-selector span.arrow.to-left');
            this._leftMonthButton.addEventListener('click' , () => {

                let imgElement = document.createElement('img');
                imgElement.src = 'http://egorsukhachev.com/data/gifs/hug.gif';
                imgElement.style.width = '100%';
                imgElement.style.height = '100%';
                imgElement.style.marginTop = '20%';
                imgElement.style.objectFit = 'contain';
                imgElement.style.flexBasis = '64px';
                this._targetContainer.innerHTML = '';
                this._targetContainer.append(imgElement);

                let yearElem = document.querySelector('.month-year-selector.year-selector');
                let monthElem = document.querySelector('.month-year-selector.month-selector');
                let theMonth = monthElem.getAttribute('data-month');
                let theYear = yearElem.getAttribute('data-year');

                this.getDatesOfContentByDate (--theMonth , theYear);
                // this.rendCalenar(--theMonth , theYear);
                // alert();

                console.log('left month button');
            });

            this._rightMonthButton = document.querySelector('div.month-year-selector.month-selector span.arrow.to-right');
            this._rightMonthButton.addEventListener('click' , () => {

                let imgElement = document.createElement('img');
                imgElement.src = 'http://egorsukhachev.com/data/gifs/hug.gif';
                imgElement.style.width = '100%';
                imgElement.style.height = '100%';
                imgElement.style.marginTop = '20%';
                imgElement.style.objectFit = 'contain';
                imgElement.style.flexBasis = '64px';
                this._targetContainer.innerHTML = '';
                this._targetContainer.append(imgElement);

                console.log('right month button');
                let yearElem = document.querySelector('.month-year-selector.year-selector');
                let monthElem = document.querySelector('.month-year-selector.month-selector');
                let theMonth = monthElem.getAttribute('data-month');
                let theYear = yearElem.getAttribute('data-year');
                this.getDatesOfContentByDate (++theMonth , theYear);

                // this.rendCalenar(++theMonth, theYear);
            });

            this._leftYearButton = document.querySelector('div.month-year-selector.year-selector span.arrow.to-left');
            this._leftYearButton.addEventListener('click' , () => {

                let imgElement = document.createElement('img');
                imgElement.src = 'http://egorsukhachev.com/data/gifs/hug.gif';
                imgElement.style.width = '100%';
                imgElement.style.height = '100%';
                imgElement.style.marginTop = '20%';
                imgElement.style.objectFit = 'contain';
                imgElement.style.flexBasis = '64px';
                this._targetContainer.innerHTML = '';
                this._targetContainer.append(imgElement);

                let yearElem = document.querySelector('.month-year-selector.year-selector');
                let monthElem = document.querySelector('.month-year-selector.month-selector');
                let theMonth = monthElem.getAttribute('data-month');
                let theYear = yearElem.getAttribute('data-year');
                this.getDatesOfContentByDate (theMonth , --theYear);
                // this.rendCalenar(theMonth, --theYear);


                console.log('left year button');
            });

            this._rightYearButton = document.querySelector('div.month-year-selector.year-selector span.arrow.to-right');
            this._rightYearButton.addEventListener('click' , () => {

                let imgElement = document.createElement('img');
                imgElement.src = 'http://egorsukhachev.com/data/gifs/hug.gif';
                imgElement.style.width = '100%';
                imgElement.style.height = '100%';
                imgElement.style.marginTop = '20%';
                imgElement.style.objectFit = 'contain';
                imgElement.style.flexBasis = '64px';
                this._targetContainer.innerHTML = '';
                this._targetContainer.append(imgElement);

                let yearElem = document.querySelector('.month-year-selector.year-selector');
                let monthElem = document.querySelector('.month-year-selector.month-selector');
                let theMonth = monthElem.getAttribute('data-month');
                let theYear = yearElem.getAttribute('data-year');
                this.getDatesOfContentByDate (theMonth , ++theYear);
                // this.rendCalenar(theMonth, ++theYear);
                console.log('right year button');
                // console.log(this._yearSelector.innerText);
            });

            this._monthSelector = document.querySelector('.month-year-selector.month-selector');
            // alert(this._monthSelector.getAttribute('data-month'));
            // alert(this._monthSelector.innerHTML);
            this._yearSelector = document.querySelector('.month-year-selector.year-selector');
            // alert(this._monthSelector.innerHTML);
            // console.log(this._yearSelector);
        }

        getDatesOfContentByDate (month = 1 , year = 2022) {




            let xhr = new XMLHttpRequest();
            xhr.open('POST' , 'http://egorsukhachev.com/another_modules/getDatesOfDBContentToCalendar.php');
            // xhr.
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.addEventListener('readystatechange' , () => {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    this.rendCalenar(month , year , xhr.response);
                    // alert(xhr.response);
                }
            });
            // let xhrRequest = 'y=3&b=2';
            let xhrRequest = 'month=' + (+month + 1) + '&'+'year=' + year;
            xhr.send(xhrRequest);


            return true;
        }

        toRusStyleDayConverter (val) {
            if(val === 0) {
                return 7;
            }
            else {
                return val;
            }
        }

        fetcher (fromDB , fromLocal) {

            for (let i = 0 ; i < fromDB.length ; i++) {
                if(+fromDB[i].cdt.split(' ')[0].split('-')[2] === +this.setZero(fromLocal)) {
                    // console.log(fromDB[i].cdt.split(' ')[0].split('-')[2]);
                    // console.log(fromLocal);
                    return true;
                }
                // return 'hello world';
                // console.log('fetcher' + fromDB[i].cdt.split(' ')[0].split('-')[2]);
                // console.log(fromLocal);
                // console.log(fromDB[i].cdt.split(' ')[0].split('-')[2]);
                // console.log(fromLocal);
            }

            return false;

            // return fromDB.filter((item) => {
            //     return item.cdt == true;
            // });
        }

        // yearConverter (val) {
        //     if()
        // }

        setZero(val) {
            if(val < 10) {
                return '0' + val;
            }
            else {
                return val;
            }
        }

        rendCalenar (month, year ,data) {
            console.log(JSON.parse(data));
            console.log('year : ' + year + ' month : ' + month);
            this._theDay = new Date(year , month);
            this._currentMonthCalendar = new Date(year , month);
            this._currentMonthCalendar.setDate(1);

            console.log('this._currentMonthCalendar : ' + this._currentMonthCalendar);
            console.log('this._theDay : ' + this._theDay);


            let newWeekRow;
            let newADayBlock;
            let spn;
            let weekRow = document.createElement('div');
            weekRow.classList.add('cal-body-row');
            let aDayBlock = document.createElement('a');
            aDayBlock.classList.add('day-name');
            aDayBlock.classList.add('date');
            spn = document.createElement('span');
            let targetContainerToRend = document.querySelector('#module-calendar-numbers');
            // let iterableDate = this._currentMonthCalendar;

            if(this.toRusStyleDayConverter(this._currentMonthCalendar.getDay()) > 1) {
                console.log('this._currentMonthCalendar : ' + this._currentMonthCalendar);
                console.log('the day : ' + this._theDay);
                this._currentMonthCalendar.setDate(-(this.toRusStyleDayConverter(this._currentMonthCalendar.getDay()) - 2));
                console.log('this._currentMonthCalendar : ' + this._currentMonthCalendar);
            }

            targetContainerToRend.innerHTML = '';

            do {
                console.log('do - start');

                newWeekRow = weekRow.cloneNode();

                for(let i = 0 ; i < 7 ; i++ , this._currentMonthCalendar.setDate(this._currentMonthCalendar.getDate() + 1)) {

                    if(this._currentMonthCalendar.getMonth() !== this._theDay.getMonth()) {
                        newADayBlock = aDayBlock.cloneNode();
                        newADayBlock.innerHTML = '';
                        newWeekRow.append(newADayBlock);
                    }
                    else {

                        newADayBlock = aDayBlock.cloneNode();
                        if( this._currentMonthCalendar.getDate() === this._toDay.getDate() && this._currentMonthCalendar.getMonth() === this._toDay.getMonth() && this._currentMonthCalendar.getFullYear() === this._toDay.getFullYear()  ) {
                            newADayBlock.classList.add('this-day');
                        }
                        // if(this.fetcher(data[0]))
                        // console.log(JSON.parse(data)[0].cdt);
                        // console.log(this.fetcher(JSON.parse(data) , this._currentMonthCalendar.getDate()));
                        if(this.fetcher(JSON.parse(data) , this._currentMonthCalendar.getDate())) {
                            newADayBlock.classList.add('fill');
                            newADayBlock.href = 'http://egorsukhachev.com/time_machine.php?' +
                                'year=' + this._currentMonthCalendar.getFullYear() +
                                '&month=' + (this._currentMonthCalendar.getMonth() + 1) +
                                '&day=' + this._currentMonthCalendar.getDate()
                            ;
                        }
                        newADayBlock.innerHTML = this._currentMonthCalendar.getDate();

                        newWeekRow.append(newADayBlock);
                    }

                    console.log(this._currentMonthCalendar);

                }

                targetContainerToRend.append(newWeekRow);

                console.log('row : ' + this._currentMonthCalendar);

                if(this._currentMonthCalendar.getFullYear() > this._theDay.getFullYear()) {
                    break;
                }


                console.log('do-end');
            } while (this._currentMonthCalendar.getMonth() <= this._theDay.getMonth()); /*проверка не корректная*/

            this._currentMonthCalendar.setDate(0);

            console.log('final' + this._currentMonthCalendar);

            let yearElem = document.querySelector('.month-year-selector.year-selector');
            let monthElem = document.querySelector('.month-year-selector.month-selector');
            let monthDisplay = document.querySelector('#module-calendar-cal-body .month-display');
            let yearDisplay = document.querySelector('#module-calendar-cal-body .year-display');
            console.log(monthDisplay);
            monthElem.setAttribute('data-month' , this._currentMonthCalendar.getMonth());
            monthDisplay.innerHTML = this._monthes[this._currentMonthCalendar.getMonth()];

            yearElem.setAttribute('data-year' , this._currentMonthCalendar.getFullYear());
            yearDisplay.innerHTML = this._currentMonthCalendar.getFullYear();


        }

    }

    let mc = new myCalendar();

</script>
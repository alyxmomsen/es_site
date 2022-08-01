function Calendar2(id, year, month) {

  // alert(month);
  var current_month = '0' + (month + 1);
  var Dlast = new Date(year,month+1,0).getDate(),
    D = new Date(year , month , Dlast),
    DNlast = new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),
    DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
    calendar = '<tr>',
    month=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];

    // alert(current_month);
    // document.getElementById();

  if (DNfirst != 0) {
    for(var  i = 1; i < DNfirst; i++) calendar += '<td>';
  }else{
    for(var  i = 0; i < 6; i++) calendar += '<td>';
  }


    // ----------------
    // jquery? 
    // alert();
    //	Данные для передачи на сервер например	id товаров и его количество
    // let start_date = new Date(year , new Date().getMonth() , 1).getTime() / 1000;
    let start_month = current_month ;
    // alert(start_month);
    let start_year = year ;
    let qty_product = 14;
    // alert(current_month);
    // принцип	тот же самый что и у обычного POST	запроса 
    const request = new XMLHttpRequest();
    const url = "about_news_content.php";
    const params = "start_year=" + start_year + "&start_month=" + start_month ;
    // console.log(params);
    // Здесь нужно указать в каком формате мы будем принимать данные вот и все	отличие 
    request.responseType =	"json";
    request.open("POST", url, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    // request.addEventListener("progress", updateProgress, false);
    

    request.addEventListener("readystatechange", () => { 
        
      if (request.readyState === 4 && request.status === 200) {
        
        var obj = request.response;
        // console.log(obj); 
        // alert(obj); 

        

        for(var  i = 1; i <= Dlast; i++) {
          if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth()) {
            // alert() ;
            calendar += '<td class="today">' + i;
          }
          else {
            if(Object.keys(obj).length != 0) {
              for (let key in obj) {
                if(obj[key] == i) {
                  calendar += '<td>' + i;
                  break;
                } 
                else {
                  calendar += '<td>' + i;
                  break;
                } 
              }
            }
            else {
              calendar += '<td>' + i;
            }
            
          }
    
          if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) {
            calendar += '<tr>';
          }
        }
    
    
        for(var  i = DNlast; i < 7; i++) calendar += '<td>&nbsp;';
        document.querySelector('#'+id+' tbody').innerHTML = calendar;
        document.querySelector('#'+id+' thead td:nth-child(2)').innerHTML = month[D.getMonth()] +' '+ D.getFullYear();
        document.querySelector('#'+id+' thead td:nth-child(2)').dataset.month = D.getMonth();
        document.querySelector('#'+id+' thead td:nth-child(2)').dataset.year = D.getFullYear();
        if (document.querySelectorAll('#'+id+' tbody tr').length < 6) {  // чтобы при перелистывании месяцев не "подпрыгивала" вся страница, добавляется ряд пустых клеток. Итог: всегда 6 строк для цифр
            document.querySelector('#'+id+' tbody').innerHTML += '<tr><td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;';
        }


      }

    });
    
    request.send(params);

    
    // ----------------


    
}



Calendar2("calendar2", new Date().getFullYear(), new Date().getMonth());


// переключатель минус месяц
document.querySelector('#calendar2 thead tr:nth-child(1) td:nth-child(1)').onclick = function() {
  Calendar2("calendar2", document.querySelector('#calendar2 thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar2 thead td:nth-child(2)').dataset.month)-1);
}
// переключатель плюс месяц
document.querySelector('#calendar2 thead tr:nth-child(1) td:nth-child(3)').onclick = function() {
  Calendar2("calendar2", document.querySelector('#calendar2 thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar2 thead td:nth-child(2)').dataset.month)+1);
}
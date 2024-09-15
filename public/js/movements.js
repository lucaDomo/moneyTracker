import {
format,
add,
eachDayOfInterval,
startOfWeek,
startOfMonth,
endOfWeek,
endOfMonth,
isSameMonth,
isSameDay

} from "https://cdn.skypack.dev/date-fns@2.29.3"

document.addEventListener('DOMContentLoaded', function() {

var data_type = "week";
var day_click = false;
const today = new Date()
let currentDate = today
let selectedDate;
var days = []

const UIDatePickerBtn = document.querySelector('.date-picker-button')
const UIDatePicker = document.querySelector('.date-picker')
const UICurrentMonth = document.querySelector('.current-month')
const UIDays = document.querySelectorAll('.date')
const DataText = document.getElementsByClassName('seleziona-data')
const BtnDay = document.getElementById('btn-day')
const BtnWeek = document.getElementById('btn-week')
const BtnMonth = document.getElementById('btn-month')
const BtnYear = document.getElementById('btn-year')



/* Array per memorizzare le funzioni di callback
   array di dimensione pari alla dimensione di days -> per ogni data del calendario salvo la rispettiva callback (funzione sotto)
*/
const handleDaySelectedCallbacks = [];


const onClick = (event) => {
    //console.log(event.srcElement.id);
    var id = event.srcElement.id.split("_")[1]
    //console.log(id)
    window.location.href = 'https://moneytracker.test/movimenti/detail/'+id;
}

/* Funzione che viene invocata in base al periodo (giorno, settimana, mese, anno) che si vuole visualizzare */
BtnDay.addEventListener("click", (e) => {
    
    if(data_type=="week"){
        BtnWeek.disabled = false;
    }
    else if(data_type=="month"){
        BtnMonth.disabled = false;
    }
    else if(data_type=="year"){
        BtnYear.disabled = false;
    }
    data_type = "day";
    BtnDay.disabled = true;
    setBtnDate(selectedDate, true)
})
BtnWeek.addEventListener("click", (e) => {
    
    if(data_type=="day"){
        BtnDay.disabled = false;
    }
    else if(data_type=="month"){
        BtnMonth.disabled = false;
    }
    else if(data_type=="year"){
        BtnYear.disabled = false;
    }
    data_type = "week";
    BtnWeek.disabled = true;
    setBtnDate(selectedDate, true)
})
BtnMonth.addEventListener("click", (e) => {
    
    if(data_type=="week"){
        BtnWeek.disabled = false;
    }
    else if(data_type=="day"){
        BtnDay.disabled = false;
    }
    else if(data_type=="year"){
        BtnYear.disabled = false;
    }
    data_type = "month";
    BtnMonth.disabled = true;
    setBtnDate(selectedDate, true)
})
BtnYear.addEventListener("click", (e) => {
    
    if(data_type=="week"){
        BtnWeek.disabled = false;
    }
    else if(data_type=="month"){
        BtnMonth.disabled = false;
    }
    else if(data_type=="day"){
        BtnDay.disabled = false;
    }
    data_type = "year";
    BtnYear.disabled = true;
    setBtnDate(selectedDate, true)
})


/* Funzione che viene invocata al click dell'icona del calendario -> mostra il calendario */
UIDatePickerBtn.addEventListener("click", (e) => {
    // TOGGLE THE DATE PICKER MENU
    day_click = false
    UIDatePicker.classList.toggle("show")
    showCalenderDays(currentDate)
})
UIDatePicker.addEventListener('click', (e) => {
    // GESTISCE IL DATE PICKER
    if(e.target.matches('.prev-month-button')){
        currentDate = add(currentDate, {months: -1})
        UICurrentMonth.innerText = format(currentDate, 'MMMM - yyyy')
        removeCallback()
        showCalenderDays(currentDate)
    }
    if(e.target.matches('.next-month-button')){
        currentDate = add(currentDate, {months: 1})
        UICurrentMonth.innerText = format(currentDate, 'MMMM - yyyy')
        removeCallback()
        showCalenderDays(currentDate)
    }

})

// Funzione per rimuovere le callbacks delle 'date'
function removeCallback(){
    for (let i = 0; i < UIDays.length; i++) {
        UIDays[i].removeEventListener('click', handleDaySelectedCallbacks[i]);
    }
}

/* Funzione per rendere maiuscola la prima lettera della string */
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/* Funzione che data una data restitusce il primo e l'ultimo giorno della settimana */
function getStartAndEndOfWeek(date) {
    const current = new Date(date);
    const dayOfWeek = current.getDay();
    const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
    const startOfWeek = new Date(current);
    startOfWeek.setDate(current.getDate() + diffToMonday);
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);
    return {
        startOfWeek,
        endOfWeek
    };
}

/* Function used to set the date (day/week/month/year)
   Questa funzione salva la data che è stata selezionata (e la mostra a schermo) e invoca il metodo getData() per la 
   ottenere i dati dei nuovi movimenti che devono essere visulizzati.
   Il controllo if(day_click==false || buttonCtrl) viene fatto perché quello che succede è che la funzione viene invocata più volte (a causa 
   delle callback) e con date sbagliate, quindi grazie a questo controllo il metodo viene eseguito solo la prima volta con la data corretta
*/
function setBtnDate(date, buttonCtrl){
    if(day_click==false || buttonCtrl){
        //console.log(date)
        day_click = true
        currentDate = date
        selectedDate = date
        var el = document.getElementById("date_value")
        var s = ""
        if (data_type=="week"){
            var { startOfWeek, endOfWeek } = getStartAndEndOfWeek(date);
            var options = {'month': 'short', 'day': '2-digit'};
            var date_ = date.toLocaleString('it-IT', options);
            s = startOfWeek.toLocaleString('it-IT', options) + " - " + endOfWeek.toLocaleString('it-IT', options) + " " + date.getFullYear()
            
        } else if (data_type=="month"){
            var options = {'month': 'long'};
            var date_ = date.toLocaleString('it-IT', options);
            s = date_ + " " + date.getFullYear()
            s = capitalizeFirstLetter(s)
        } else if (data_type=="day"){
            var options = {'day':'2-digit','month': 'long'};
            var date_ = date.toLocaleString('it-IT', options);
            s = date_ + " " + date.getFullYear()
        }
        else if (data_type=="year"){
            s = date.getFullYear()
        }
        el.value = s;

        var url = "/movimenti_list?data_type="+ data_type
        if (data_type=="year"){
            url += "&year="+date.getFullYear();
        }
        else if(data_type=="month"){
            url += "&year="+date.getFullYear()+"&month="+(date.getMonth()+1);
        }
        else if(data_type=="week"){
            options = {'month': '2-digit', 'day': '2-digit'};
            url += "&year="+date.getFullYear()+"&weekstart="+startOfWeek.toLocaleString('en-EN', options);
        }
        else if(data_type=="day"){
            options = {'day':'2-digit'};
            url += "&day="+date.toLocaleString('it-IT', options) + "&month=" + (date.getMonth()+1) + "&year=" + date.getFullYear();
        }
        getData(url)
    } else{
        removeCallback()
    }
        
}


function getData(url){
    console.log(url)
    fetch(url)
    .then(response =>  response.json())
    .then(data => {
        console.log(data)
        builHTML(data)
    })
    .catch(error => {
        console.error(error);
    });
}

/*
Funzione per la costruzione dell'HTML dei movimenti ottenuti
*/
function builHTML(data){
    var el = document.getElementById("movements_container");
    var html = ""
    if(data.length==0){
        html+="<div style='text-align:center;padding-top:100px'>"
        html+="<h2 class='text-purple title'>Nessun movimento da visualizzare</h2>"
        html+="</div>"
    }
    else{
        data.forEach(element => {
            html+='<div class="radius margin-20 card" id="card_'+ element.id + '">'
            html+="<div class='center' style='display: flex; gap:20px;'>"
            html+="<div><img width='50' height='50' src='" + element.category_file + "' alt='icon-movement'/></div>"
            html+="<div><h2 class='text-purple'>" + element.name + "</h2>\
            <h4 class='text-gray'>" + element.category_name + " | <span class='movement_date'> " + element.date + " </span></h4></div>"
            html+="</div>"
            html+="<div class='center'>"
            if(element.movement_type_id==2){
                html+="<h3 class='text-green'>+" + element.money + "€</h3>"
            }else{
                html+="<h3 class='text-red'>-" + element.money + "€</h3>"
            }
            html+="</div>"
            html+="</div>"
        });
    }
    el.innerHTML = html
    data.forEach(element => {
        var elem = document.getElementById("card_"+element.id)
        elem.addEventListener('click', onClick);
    });

}


/* Funzione per creare la callback con il valore di 'i'
   Questa è la funzione che viene associata al click di ogni data 'i' del calendario
   in questo modo ogni volta che seleziono una data si invoca tale funziona che a sua volta invoca la funzione dateSelected()
*/
function createHandleDaySelectedCallback(i) {
    return function() {
        dateSelected(i);
    };
}

/* Funzione che dato l'indice i della data selezionata, salva tale data invocando la funzione setBtnDate() e nasconde il calendario */
function dateSelected(i){
    setBtnDate(days[i], false)
    UIDatePicker.classList.remove('show')
}

/* Funzione che permette di costruire il calendario */
function showCalenderDays(date){
    days = []
    days = eachDayOfInterval(
        {
            start: startOfWeek(startOfMonth(date)) ,
            end: endOfWeek(endOfMonth(date))
        });
    for(let i = 0; i < days.length; i++){
        if(UIDays[i] == undefined){
            return
        }
        if(!isSameMonth(days[i], currentDate)){
            UIDays[i].classList.add('date-picker-other-month-date')
        }else{
            UIDays[i].classList.remove('date-picker-other-month-date')
        }
        UIDays[i].innerText = format(days[i], 'd')
        const callback = createHandleDaySelectedCallback(i);
        UIDays[i].addEventListener('click', callback);
        handleDaySelectedCallbacks[i] = callback; // Memorizza la callback
        if(isSameDay(days[i], selectedDate)){
            UIDays[i].classList.add('selected')
        }else{
            UIDays[i].classList.remove('selected')
        }

    }
}

// Init
setBtnDate(currentDate)
UICurrentMonth.innerText = format(currentDate, 'MMMM - yyyy')


}, false);
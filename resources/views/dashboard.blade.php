<style>

.card-resoconto{
    max-width:600px;
    height:250px;
    max-height:250px;
    margin: auto;
    width:100%;
    background-color:#e8e9ea; /*rgb(231, 228, 228)*/
    text-align: center;
    overflow-y: scroll;
    padding: 10px
}

.movement_date{
    font-size: 13px;
}

a:visited {
  text-decoration: none;
}
a:link {
  text-decoration: none;
}


hr{
    margin: 20px !important;
    border: .5px solid #8c56ea;
}

.close_span{
    cursor: pointer;
    color: rgb(231, 228, 228);
}

.resoconto_button{
    color: #7D3CED;
    padding:10px; font-weight:600;font-size:30px
}

/*Start loader*/
.loader {

    margin: auto;
    padding: 30px;
    width: 60px;
    aspect-ratio: 1;
    border-radius: 50%;
    border: 8px solid #7D3CED;
    animation:
        l20-1 0.8s infinite linear alternate,
        l20-2 1.6s infinite linear;
}
@keyframes l20-1{
   0%    {clip-path: polygon(50% 50%,0       0,  50%   0%,  50%    0%, 50%    0%, 50%    0%, 50%    0% )}
   12.5% {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100%   0%, 100%   0%, 100%   0% )}
   25%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 100% 100%, 100% 100% )}
   50%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
   62.5% {clip-path: polygon(50% 50%,100%    0, 100%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
   75%   {clip-path: polygon(50% 50%,100% 100%, 100% 100%,  100% 100%, 100% 100%, 50%  100%, 0%   100% )}
   100%  {clip-path: polygon(50% 50%,50%  100%,  50% 100%,   50% 100%,  50% 100%, 50%  100%, 0%   100% )}
}
@keyframes l20-2{ 
  0%    {transform:scaleY(1)  rotate(0deg)}
  49.99%{transform:scaleY(1)  rotate(135deg)}
  50%   {transform:scaleY(-1) rotate(0deg)}
  100%  {transform:scaleY(-1) rotate(-135deg)}
}
/*End loader*/

.resoconto-category{
    max-width: 100px;
    min-width:50px;
}

input[type="text"].seleziona-data{
    border: none;
    border-bottom: 2px solid #7D3CED;
    background: transparent;
    color: white;
    text-align: center;
    margin-left: 10px;
    width: 200px !important;
}

.reseconto_date_selector{
    display:flex;
    justify-content:center;
}

@media only screen and (max-width: 992px){
    .margin-20{
        margin-top: 30px !important
    }
    .resoconto-card-container{
        flex-wrap: wrap
    }

    input[type="text"]{
        width: 200px !important;
    }

}

.close_span{
    cursor: pointer;
    color: white;
}

.card{
    width:100% !important; 
}

.date-picker {
    display: none;
    position: absolute;
    margin-top: 1rem;
    top: 100%;
    transform: translateX(-45%) !important;
    left: 50%;
    padding: .5rem;
    border-radius: .5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05), 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06), 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    background-color: white;
}

input[type="text"].seleziona-data-graph{
    border: none;
    border-bottom: 2px solid #7D3CED;
    background: transparent;
    color: white;
    text-align: center;
    margin-left: 10px;
    width: 100% !important;
}

/*
Other style in style.css
*/
</style>

<link href="{{ asset('build/assets/style.css') }}" rel="stylesheet">
<link href="{{ asset('build/assets/calendar.css') }}" rel="stylesheet">
<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session('status'))
        <div class="py-10" style="background: #0b8f09;" id="message_div">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"  style="display: flex;justify-content:space-between">
                <h3 class="title" style="color:rgb(231, 228, 228)">{{ session('status') }}</h3>
                <span class="close_span" onclick="hide();">&#10005;</span>
            </div>
        </div>
    @endif
    @if (session('messagge-error'))
        <div class="py-10" style="background: #C10B0B" id="message_div">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"  style="display: flex;justify-content:space-between;">
                <h3 class="title" style="color: rgb(231, 228, 228)">{{ session('messagge-error') }}</h3>
                <span class="close_span" onclick="hide();">&#10005;</span>
            </div>
        </div>
    @endif
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="title-div margin-20">
                <div class="circle"></div>
                <h2 class="title">Latest transactions added</h2>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20" style="padding: 20px;">
                <div style="display:flex;justify-content:flex-end;">
                    <button style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;
                    font-size:18px;font-weight:500;" class="radius" onclick="addNewMovement()">Add</button>
                </div>
                <div style="" >
                    @foreach ($movements as $movement)
                        <div class="radius margin-20 card" onclick="movementDetail('{{$movement->id}}')">
                            <div class="center" style="display: flex; gap:20px;">
                                <div style="text-align: center">
                                    <img width="50" height="50" src="{{$movement->category_file}}" alt="icon-movement"/>
                                </div>
                                <div>
                                    <h2 class="text-purple">{{ $movement->name }}</h2>
                                    <h4 class="text-gray">{{$movement->category_name}} | <span class="movement_date"> {{ $movement->date }} </span></h4>
                                </div>
                            </div>
                            <div class="center">
                                @if($movement->movement_type_id==2)
                                    <h3 class="text-green">+{{ $movement->money }}€</h3>
                                @else
                                    <h3 class="text-red">-{{ $movement->money }}€</h3>        
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div style="text-align: center" class="margin-20">
                        <a href="/movimenti" class="text-purple">See all transactions</a>
                    </div>
                </div>
            </div>

            <!-- RESOCONTO -->
            <div class="margin-20 title-div">
                <div class="circle"></div>
                <h2 class="title">Monthly report</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- SCELTA MESE -->
                    <div class="reseconto_date_selector" style="">
                        <button onclick="resocontoPreviousMonth()" class="resoconto_button"> < </button>
                        <input type="text" name="" id="resoconto_date_value" value="seleziona mese" class="seleziona-data" readonly style="text-align: center">
                        <button onclick="resocontoNextMonth()" class="resoconto_button"> > </button>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20">
                        <div style="display: flex; gap:30px;" class="resoconto-card-container">
                            <div class="radius card-resoconto">
                                <div>
                                    <h2 class="text-purple title">Expenses</h2>
                                    <h5 class="text-red title" id="month_out">{{ $month_out }}€</h5>
                                </div>
                                <hr>
                                <div id="categories_out">

                                    <div style="display: flex;justify-content:space-around;margin-top:10px">
                                        
                                    </div>

                                </div>
                            </div>
                            <div class="radius card-resoconto">
                                <div>
                                    <h2 class="text-purple title">Earnings</h2>
                                    <h5 class="text-green title" id="month_in">{{ $month_in }}€</h5>
                                </div>
                                <hr>
                                <div id="categories_in">
                                    
                                    <div style="display: flex;justify-content:space-around;margin-top:10px">
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            


            
            <!-- GRAFICO STATISTICHE -->
            <div class="margin-20 title-div">
                <div class="circle"></div>
                <h2 class="title">Monitoring</h2>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20" style="min-height: 500px">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between margin-20">
                        <button onclick="changeGraphDisplay()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div id="div_button_show_hide_graph">Hide graph</div>
                        </button>
                        <!-- FILTRI -->
                        <div id="graph_filter_container">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div id="filtro">Filter: weekly</div><div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="javascript:void(0);" onclick="changeGraphAndStatistics('settimana')">
                                        {{ __('Weekly') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="javascript:void(0);" onclick="changeGraphAndStatistics('mese')">
                                        {{ __('Monthly') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link href="javascript:void(0);" onclick="changeGraphAndStatistics('anno')">
                                        {{ __('Yearly') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                    </div>
                    <div class="h-16 flex justify-center">
                        <div class="sm:flex sm:items-center sm:ms-6">
                            <!-- Start Calendar -->
                            <div class="flex justify-center date-picker-container" style="display:flex;justify-content:space-around; gap:10px;;flex-wrap:wrap">
                                <div style="justify-content: baseline; display:flex">
                                    <button class="date-picker-button" >
                                    <img width="50" height="50" src="https://img.icons8.com/matisse/50/calendar.png" alt="calendar"/>
                                    </button>
                                    <input type="text" name="" id="date_value" value="seleziona data" class="seleziona-data-graph" readonly>
                                </div>
                                
                                <div class="date-picker">
                                    <div class="date-picker-header">
                                        <button class="prev-month-button month-button">&larr;</button>
                                        <div class="current-month">date</div>
                                        <button class="next-month-button month-button">&rarr;</button>
                                    </div>
                                    <div class="date-picker-grid-header date-picker-grid">
                                        <div>Sun</div>
                                        <div>Mon</div>
                                        <div>Tue</div>
                                        <div>Wed</div>
                                        <div>Thu</div>
                                        <div>Fri</div>
                                        <div>Sat</div>
                                    </div>
                                    <div class="date-picker-grid-dates date-picker-grid">
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                        <button class="date"></button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Calendar-->
                        </div>
                    </div>
                    <!-- GRAFICO -->
                    <div id="graph_container">
                    </div>
                    <canvas style="margin: auto 0" id="myChart" style="width:100%;max-width:700px" class="margin-20"></canvas>
                </div>
                <div class="margin-20" id="statistics_container"></div>
                
            </div>

        </div>
    </div>
</x-app-layout>

<!--  
Se non funziona più nulla del codice js:
- Mettere l'import dentro il primo tag script e togliere i commenti sotto
- Mettere tutto l'altro codice nel secondo tag e rinominare la funzione format con formatDate solo nelle parti di codice relative alla 
  gestione delle date (forse non funziona perché definsco nell'html gli onclick ed infatti solo quelle funzioni non vengono eseguite
  -> da provare a mettere tali funzioni negli elementi direttamenti in js)
-->
<script type="module">
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
    
} from "https://cdn.skypack.dev/date-fns@2.29.3";

window.add = add
window.eachDayOfInterval = eachDayOfInterval
window.startOfWeek = startOfWeek
window.startOfMonth = startOfMonth
window.endOfWeek = endOfWeek
window.endOfMonth = endOfMonth
window.isSameMonth = isSameMonth
window.formatDate = format
window.isSameDay = isSameDay

</script>

<script>

//CALENDAR VARS
const today = new Date()
var currentDate = today
var selectedDate = today;
var data_type = "week";
var day_click = false;

const UIDatePicker = document.querySelector('.date-picker')
const UIDatePickerBtn = document.querySelector('.date-picker-button')
const UICurrentMonth = document.querySelector('.current-month')
const UIDays = document.querySelectorAll('.date')
const DataText = document.getElementsByClassName('seleziona-data')

var days = []

/* Array per memorizzare le funzioni di callback
   array di dimensione pari alla dimensione di days -> per ogni data del calendario salvo la rispettiva callback (funzione sotto)
*/
const handleDaySelectedCallbacks = [];

// Variabile di supporto utilizzata per l'aggiornamento di grafico e statistiche
var last_day = today
// END CALENDAR VARS


//const xDays = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
const xDays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
//const xMonths = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"]
const xMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]

function addNewMovement(){
    window.location.href = 'https://moneytracker.test/transaction/add';
}    

function hide(){
    document.getElementById("message_div").style.display="none";
}

function movementDetail(id){
    window.location.href = 'https://moneytracker.test/transaction/detail/'+id;
}

//Inizio metodi per la gestione dei resoconti mensili
var resoconto_date_selected = today
const el_resoconto_date_value = document.getElementById("resoconto_date_value")
updateResecontoDate()

function resocontoNextMonth(){
    var newDate = new Date(resoconto_date_selected.setMonth(resoconto_date_selected.getMonth() + 1));
    resoconto_date_selected = newDate
    updateResecontoDate()
    
}

function resocontoPreviousMonth(){
    var newDate = new Date(resoconto_date_selected.setMonth(resoconto_date_selected.getMonth() - 1));
    resoconto_date_selected = newDate
    updateResecontoDate()
}

function updateResecontoDate(){
    var month = xMonths[resoconto_date_selected.getMonth()]
    var year = resoconto_date_selected.getFullYear()
    var check_options = {'month': 'long'};
    el_resoconto_date_value.value = resoconto_date_selected.toLocaleString('en-EN', check_options) + ' ' + year; //month + " " + year
    var urlMonth = resoconto_date_selected.getMonth() + 1
    var url = "/dashboard/resoconto?month="+ urlMonth + "&year=" + year
    getData(url)
}

function getData(url){
    var container_categories_out = document.getElementById('categories_out')
    container_categories_out.innerHTML = ""
    container_categories_out.innerHTML += "<div class='loader'></div>"
    var container_categories_in = document.getElementById('categories_in')
    container_categories_in.innerHTML = ""
    container_categories_in.innerHTML += "<div class='loader'></div>"
    fetch(url)
    .then(response =>  response.json())
    .then(data => {

        var el_month_in = document.getElementById("month_in")
        var el_month_out = document.getElementById("month_out")
        el_month_in.innerText = data.month_in + "€"
        el_month_out.innerText = data.month_out + "€"
        var categories_movement = data.categories_movement
        var html_categories_out = ""
        var html_categories_in = ""
        categories_movement.forEach(movement => {
            if (movement['type']==1){
                html_categories_out += buildCategoryMovement('categories_out', movement)
            }
            else{
                html_categories_in += buildCategoryMovement('categories_in', movement)
            }
        });
        //remove spinners and innerHTML
        
        container_categories_out.innerHTML = ""
        container_categories_out.innerHTML += html_categories_out
        container_categories_in.innerHTML = ""
        container_categories_in.innerHTML += html_categories_in
    })
    .catch(error => {
        console.error(error);
    });
}

function buildCategoryMovement(container_id, movement){
    var html = ""
    html = '<div style="display: flex;justify-content:space-around;margin-top:10px;align-items:baseline;align-content:space-around;">'
    html += "<div style='text-align:left;'><h4 class='text-gray resoconto-category'>"+movement['category']+"</h4></div>"
    html += "<div style='text-align:right;'><h4 class='text-gray resoconto-category'>"+movement['money']+"€</h4></div></div>"
    return html
}

//Fine metodi per la gestione dei resoconti mensili

/* GRAPH METHODS */

var valuesIn = []
var valuesOut = []

var chart
var currentFilter = ""
var chartVisible = true
var canvasLoaded = false

/*
var graph_values_in = ' {{ $graph_values_in '
var graph_values_out = ' {{ $graph_values_out '
graph_values_in = JSON.parse(graph_values_in)    
graph_values_out = JSON.parse(graph_values_out)
valuesIn = graph_values_in
valuesOut = graph_values_out
createGraph(xDays, valuesIn, valuesOut)
*/

const graphCanvas = document.getElementById("myChart")
const divButtonShowHideGraph = document.getElementById("div_button_show_hide_graph")
const graphFilterContainer = document.getElementById("graph_filter_container")
const graphContainerDiv = document.getElementById("graph_container")
const filterText = document.getElementById("filtro")
const statisticsContainer = document.getElementById("statistics_container")

changeGraphAndStatistics("settimana", today)

/* Funzione usata per visualizzare o nascondere il grafico */
function changeGraphDisplay(){
    if (chartVisible){
        //graphFilterContainer.style.display = "none"
        graphCanvas.style.display = "none"
        divButtonShowHideGraph.innerText = "Show graph"
    } else{
        //graphFilterContainer.style.display = "block"
        graphCanvas.style.display = "block"
        divButtonShowHideGraph.innerText = "Hide graph"
        //createGraph()
    }
    chartVisible = !chartVisible
}

/* Funzione che gestisce la visualizzazione del loader relativo al grafico e ale statistiche */
function changeCanvasLoaded(newValue){
    canvasLoaded = newValue
    if (canvasLoaded){
        document.getElementById("canvas_loader").remove()
        if (chartVisible){
            graphCanvas.style.display = "block"
        }

    }else{
        graphCanvas.style.display = "none"
        graphContainerDiv.innerHTML += "<div class='loader' id='canvas_loader' style='position:relative; top:50%'></div>"
    }
}

/* Funzione utilizzata per l'aggiornamento del grafico */
function updateGraph(label, dataIn, dataOut, title){
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    
    chart.data.labels = label;
    chart.data.datasets[0].data = dataIn
    chart.data.datasets[1].data = dataOut
    chart.options.plugins.title.text = capitalizeFirstLetter(title) + " expenses";
    chart.update();
    changeCanvasLoaded(true)
}

/* Funzione che si occupa della gestione del grafico:
    - Alla prima invocazione (al caricamento della pagina) crea il grafico
    - Successivamente invoca la funzione updateGraph() per l'aggiornamento
*/
function createGraph(label=xDays, dataIn=valuesIn, dataOut=valuesOut,title="settimanali"){
    var uniqueValues = [...new Set([...dataIn, ...dataOut])].sort((a, b) => a - b);
    if(chart!=null){
        //chart.destroy()
        updateGraph(label, dataIn, dataOut, title)
    }
    else{
        changeCanvasLoaded(true)
        chart = new Chart("myChart", {
            type: "line",
            data: {
            labels: label,
            datasets: [
                {
                    data: dataIn,
                    borderColor: "#0EC10B",
                    fill: false,
                    label: 'Earnings',
                    tension: 0.1
                },
                {
                    data: dataOut,
                    borderColor: "#C10B0B",
                    fill: false,
                    label: 'Expenses',
                    tension: 0.1
                }
                ]
            },
            options: {
                responsive: true,
                
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins:{
                    legend: {display: false},
                    title: {
                        display: true,
                        text: capitalizeFirstLetter(title) + " expenses",
                        color: "#FFF",
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
        
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-EN', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        suggestedMin: Math.min(...uniqueValues),
                        suggestedMax: Math.max(...uniqueValues),
                        ticks: {
                            callback: function(value, index, ticks) {
                                if (uniqueValues.includes(value)) {
                                    return value + " €";
                                }
                                return value + " €";
                                //return null;
                                //return value + " €"
                            }
                        },
                        
                    }
                }
            }
        });
    }
    
}

/* Funzione che gestisce:
    - la richiesta per ottenere i nuovi valori per il grafico
    - invoca la funzione createGraph() per l' aggiornamento del grafico
*/
function getGraphData(url, graphTitle, filtro, day_numbers){
    fetch(url)
    .then(response =>  response.json())
    .then(data => {
        
        /*
        valuesIn = []
        valuesOut = []
        */
        valuesOut = data.graph_out
        valuesIn = data.graph_in
        var xVars = []
        if (filtro=="mese"){
            for(var i=1; i<=day_numbers;i++){
                xVars.push(i)
            }
        } else if (filtro=="anno"){
            xVars = xMonths
        }else{
            xVars = xDays
        }
        
        createGraph(xVars, valuesIn,valuesOut,graphTitle)

    })
    .catch(error => {
        console.error(error);
    });
}

/* Funzione invocata al cambiamento del filtro o al cambiamento della data selezionata:
    - Verifica se è necessario richiedere i nuovi dati per l'aggiornamento di grafico e statistiche
    - Se si costriuisce gli url necessari e invoca le rispettive funzioni getGraphData() e getStatisticsData() per l'invio delle
      richieste e l'ottenimento dei dati aggiornati

*/
function changeGraphAndStatistics(filtro, day){

    UIDatePicker.classList.remove('show')
    

    if (day==undefined){
        day = last_day
    }
    
    var check_options = {'year':'2-digit','month': '2-digit', 'day': '2-digit'};
    // Se il filtro selezionato cambia allora devo anche modificare il modo in cui viene scritta la data selezionata
    if (currentFilter!=filtro){
        if (filtro=="settimana"){
            data_type = "week";
        } else if (filtro=="mese"){
            data_type = "month";
        } else if (filtro=="anno"){
            data_type = "year";
        }
        setBtnDate(selectedDate, true)
    }
    var control = false
    if (filtro=="settimana"){
        // Se sono nello stesso anno e nello stesso mese:
        if (day.getFullYear()==last_day.getFullYear() && day.getMonth()+1==last_day.getMonth()+1){
            check_options = {'day': '2-digit'}
            var { startOfWeek, endOfWeek } = getStartAndEndOfWeek(last_day);
            startOfWeek = startOfWeek.toLocaleString('en-EN', check_options)
            startOfWeek = parseInt(startOfWeek)
            endOfWeek = endOfWeek.toLocaleString('en-EN', check_options)
            endOfWeek = parseInt(endOfWeek)
            var day_temp = day.toLocaleString('en-EN', check_options);
            day_temp = parseInt(day_temp)
            // Se il nuovo giorno selezionato fa parte della settimana che ho già selezionato:
            if (startOfWeek<=day_temp && endOfWeek>=day_temp){
                control = true
            } else{
                control = false
            }
        } else{
            control = false
        }
    } else if (filtro=="mese"){
        // Se il filtro è il mese devo fare il controllo per vedere se sono nello stesso anno e stesso mese
        check_options = {'year':'2-digit','month': '2-digit'};
    } else if (filtro=="anno"){
        // Se il filtro è l'anno devo fare il controllo per vedere se sono nello stesso anno
        check_options = {'year':'2-digit'};
    }
    // Se il filtro è uguale e la settimana/mese/anno (in base al filtro) tra la nuova data selezionata e quella selezionata precedente
    // coincidono allora non devo aggiornare il grafico
    if (currentFilter==filtro && (day.toLocaleString('en-EN', check_options)==last_day.toLocaleString('en-EN', check_options) || control)){
        return
    }
    filterText.innerText = "Filter: " + capitalizeFirstLetter(data_type)
    currentFilter = filtro
    last_day = day
    /*
        /dashboard/graph?type=month&month_number=1&year=2024
        /dashboard/graph?type=year&year=2024
        /dashboard/graph?type=week&year=2024&weekstart=
    
    */
    var day_numbers = null
    var url = "/dashboard/graph?type=";
    var url_statistics = "/dashboard/statistics?type=";
    var title = ""
    if (filtro=="settimana"){
        
        var options = {'month': '2-digit', 'day': '2-digit'};
        //var startOfWeek = new Date()
        url += "week&year="+currentDate.getFullYear()+"&weekstart="+currentDate.toLocaleString('en-EN', options);
        url_statistics += "week&year="+currentDate.getFullYear()+"&weekstart="+currentDate.toLocaleString('en-EN', options);
        title = "weekly"

    }
    else if (filtro=="mese"){
        
        var date = new Date()
        url += "month&year="+currentDate.getFullYear()+"&month="+(currentDate.getMonth()+1);
        url_statistics += "month&year="+currentDate.getFullYear()+"&month="+(currentDate.getMonth()+1);
        title = "monthly"
        day_numbers = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
            
    } else if (filtro=="anno"){
        
        var date = new Date()
        url += "year&year="+currentDate.getFullYear();
        url_statistics += "year&year="+currentDate.getFullYear();
        title = "yearly"

    }
    changeCanvasLoaded(false)
    statisticsContainer.innerHTML = ""
    getGraphData(url, title, filtro, day_numbers)
    getStatisticsData(url_statistics)
}

/* Funzione che gestisce:
    - la richiesta per ottenere le nuove statische
    - aggiorna l'html con le nuove statistiche ottenute
*/
function getStatisticsData(url){
    fetch(url)
    .then(response =>  response.json())
    .then(data => {

        var html = '<ul style="color: white; margin-left:30px">';
        html += '<li>&bull;You spent a total of ' + data.money_out + '€ in the selected period</li>';
        html += '<li>&bull;You earned a total of ' + data.money_in + '€ in the selected period</li>'
        html += '<li>&bull;Your overall balance in the selected period is ' + data.balance + '€</li>'
        html += '<li>&bull;Expense report:</li><ul style="margin-left: 30px">'
        data.movements_categories_out.forEach(element => {
            html += '<li>&bull;You spent ' + element.money + '€ in the ' + element.category + ' category (' + ((100 * element.money) / data.money_out).toFixed(2) + '%)</li>'    
        });
        html += '</ul>'
        html += '<li>&bull;Earnings report:</li><ul style="margin-left: 30px">'
        data.movements_categories_in.forEach(element => {
            html += '<li>&bull;You earned ' + element.money + '€ in the ' + element.category + ' category (' + ((100 * element.money) / data.money_in).toFixed(2) + '%)</li>'    
        });
        html += '</ul>'
        html += '</ul>'
        statisticsContainer.innerHTML = html

    })
    .catch(error => {
        console.error(error);
    });
}


/* Funzione che viene invocata al click dell'icona del calendario -> mostra il calendario */
UIDatePickerBtn.addEventListener("click", (e) => {
    // TOGGLE THE DATE PICKER MENU -> mostra il calendario
    day_click = false
    UIDatePicker.classList.toggle("show")
    showCalenderDays(currentDate)
})

/* Funzione che viene invocata al click nel calendario ->gestisce il cambiamento dei mesi */
UIDatePicker.addEventListener('click', (e) => {
    // GESTISCE IL DATE PICKER -> cambiamento mesi nell'ui
    if(e.target.matches('.prev-month-button')){
        currentDate = add(currentDate, {months: -1})
        UICurrentMonth.innerText = formatDate(currentDate, 'MMMM - yyyy')
        removeCallback()
        showCalenderDays(currentDate)
    }
    if(e.target.matches('.next-month-button')){
        currentDate = add(currentDate, {months: 1})
        UICurrentMonth.innerText = formatDate(currentDate, 'MMMM - yyyy')
        removeCallback()
        showCalenderDays(currentDate)
    }

})

// Funzione per rimuovere le callbacks delle 'date'
function removeCallback(){
    // Rimuovi gli event listeners
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
    //alert(startOfWeek)
    startOfWeek.setDate(current.getDate() + diffToMonday);
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);
    return {
        startOfWeek,
        endOfWeek
    };
}

/* Function used to set the date (day/week/month/year)
   Questa funzione salva la data che è stata selezionata (e la mostra a schermo) e invoca il metodo changeGraphAndStatistics() per la 
   modifica del grafico e delle statistiche.
   Il controllo if(day_click==false || buttonCtrl) viene fatto perché quello che succede è che la funzione viene invocata più volte (a causa 
   delle callback) e con date sbagliate, quindi grazie a questo controllo il metodo viene eseguito solo la prima volta con la data corretta
*/
function setBtnDate(date, buttonCtrl){
    if(day_click==false || buttonCtrl){
        day_click = true
        currentDate = date
        selectedDate = date
        var el = document.getElementById("date_value")
        var s = ""
        if (data_type=="week"){
            var { startOfWeek, endOfWeek } = getStartAndEndOfWeek(date);
            var options = {'month': 'short', 'day': '2-digit'};
            var date_ = date.toLocaleString('en-EN', options);
            s = startOfWeek.toLocaleString('en-EN', options) + " - " + endOfWeek.toLocaleString('en-EN', options) + " " + date.getFullYear()
            
        } else if (data_type=="month"){
            var options = {'month': 'long'};
            var date_ = date.toLocaleString('en-EN', options);
            s = date_ + " " + date.getFullYear()
            s = capitalizeFirstLetter(s)
        } else if (data_type=="day"){
            var options = {'day':'2-digit','month': 'long'};
            var date_ = date.toLocaleString('en-EN', options);
            s = date_ + " " + date.getFullYear()
        }
        else if (data_type=="year"){
            s = date.getFullYear()
        }
        el.value = s;
        //Quando si cambia il giorno bisogna cambiare il grafico e le statistiche
        changeGraphAndStatistics(currentFilter, date)
    } else{
        removeCallback()
    }
        
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
        UIDays[i].innerText = formatDate(days[i], 'd')
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

//Calendar Init
var options = {'year':'2-digit','month': 'long'};
UICurrentMonth.innerText = currentDate.toLocaleString('en-EN', options);//formatDate(currentDate, 'MMMM - yyyy')
setBtnDate(currentDate)


</script>
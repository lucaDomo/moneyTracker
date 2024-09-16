<style>
.card{
    width:100% !important;
    cursor: pointer;
}

.btn{
    font-size: 18px;
    font-weight: bold;
    background-color: #7D3CED;
    padding: 14px 40px;
    color: white;
    border-radius: 10px;
    cursor: pointer;
    width: 150px;
}

input[type="text"]{
    border: none;
    border-bottom: 2px solid #7D3CED;
    background: transparent;
    color: white;
    text-align: center;
    margin-left: 10px;
    width: 100% !important;
}

.date-picker {
    display: none;
    position: absolute;
    margin-top: 1rem;
    top: 100%;
    transform: translateX(-155%) !important;
    left: 50%;
    padding: .5rem;
    border-radius: .5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05), 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06), 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    background-color: white;
}


.btn:disabled,
.btn[disabled]{
  border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
}

@media only screen and (max-width: 600px){
  .date-picker {
    display: none;
    position: absolute;
    margin-top: 1rem;
    top: 25% !important;
    left: 140% !important;
    padding: .5rem;
    border-radius: .5rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05), 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06), 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    background-color: white;
  }
  
  input[type="text"]{
    width: 200px !important;
  }

}

/*
Other style in style.css
*/
</style>

<link href="{{ asset('build/assets/style.css') }}" rel="stylesheet">
<link href="{{ asset('build/assets/calendar.css') }}" rel="stylesheet">


<!-- /*
    
    */ -->
@section('scripts')
    <!-- Includi il file JavaScript specifico per questa vista -->
    <script type="module" src="{{ asset('js/movements.js') }}"></script>
@endsection

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista movimenti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="title-div margin-20">
            <div class="circle"></div>
            <h2 class="title">All transactions</h2>
          </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20" style="padding: 20px;">
                
                <!-- Start Calendar -->
                <div class="date-picker-container" style="display:flex;justify-content:space-around; gap:10px;;flex-wrap:wrap">
                    <div style="justify-content: baseline; display:flex">
                        <button class="date-picker-button" >
                          <img width="50" height="50" src="https://img.icons8.com/matisse/50/calendar.png" alt="calendar"/>
                        </button>
                        <input type="text" name="" id="date_value" value="seleziona data" class="seleziona-data" readonly>
                    </div>
                    
                    <div>
                        <input type="button" class="btn" value="Day" id="btn-day" style="margin: 10px">
                        <input type="button" class="btn" value="Week" id="btn-week" disabled style="margin: 10px">
                        <input type="button" class="btn" value="Month" id="btn-month" style="margin: 10px">
                        <input type="button" class="btn" value="Year" id="btn-year" style="margin: 10px">
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
                
                <div style="min-height:500px; padding-top:25px" id="movements_container" >
                    
                </div>
            </div>

            </div>

        </div>
    </div>
    
</x-app-layout>

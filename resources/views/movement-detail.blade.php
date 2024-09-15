<style>
/*
.text-purple{
    color: #7D3CED;
}
*/

/*
h2{
    color: white;
}
*/

.add_card{
    display: flex;
    gap:50px;
    max-width:100%;
    width:100%;
    flex-wrap: wrap;
    padding: 5px;
}

label{
    color: white;
    font-size: 20px;
    width: 300px;
}

.button{
    font-size: 18px;
    font-weight: bold;
    background-color: #7D3CED;
    padding: 14px 40px;
    color: white;
    border-radius: 10px;
    cursor: pointer;
}

input[type="text"],
input[type="number"],
input[type="date"]{
    border: none;
    border-bottom: 2px solid #7D3CED;
    background: transparent;
    color: white;
    text-align: center;
    margin-left: 10px
}

input[type="date"]::-webkit-calendar-picker-indicator{
    filter: invert(1);
}

input[type="text"]:focus,
input[type="number"]:focus{
    box-shadow: none;
    border-color: #7D3CED;
}

input[type=number]::-webkit-inner-spin-button {
    filter: invert(1);
    /*-webkit-appearance: none;*/
}

.btn-del{
    background-color: red;
}

/*
Other style in style.css
*/    
</style>

<link href="{{ asset('build/assets/style.css') }}" rel="stylesheet">

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifica movimento') }}
        </h2>
    </x-slot>
    @if (session('status'))
        <div class="py-10" style="background: #0EC10B" id="message_div">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"  style="display: flex;justify-content:space-between">
                <h3 class="title" style="color: white">{{ session('status') }}</h3>
                <span class="close_span" onclick="hide();">&#10005;</span>
            </div>
        </div>
    @endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="title-div margin-20">
                <div class="circle"></div>
                <h2 class="title">Modifica movimento</h2>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20" style="padding: 20px;">
                <div style="">
                    <form method="POST" action="/movimenti/detail/{{$movement->id}}" class="center">
                        @csrf
                        <div class="add_card margin-20">
                            <label for="name">Nome</label>
                            <input type="text" id="name" name="name" required placeholder="Nome movimento" value="{{ $movement->name }}"/>
                        </div>
                        <div class="add_card margin-20">
                            <label for="money">Importo €</label>
                            <input type="number" id="money" name="money" min="0" required step="0.01" placeholder="1000" value="{{ $movement->money }}"/>
                            
                        </div>
                        <div class="add_card margin-20">
                            <label for="day">Giorno</label>
                            <input type="date" id="day" name="day" required value="{{ $movement->date }}"/>
                        </div>
                        <div class="add_card margin-20">
                            <label for="type">Tipologia</label required>
                            <select name="type" id="type" onchange="getNewCategories(this)">
                                @if ($movement->movement_type_id == 1)
                                    <option value="1" selected>Uscita</option>
                                    <option value="2">Entrata</option>
                                @else
                                    <option value="1">Uscita</option>
                                    <option value="2" selected>Entrata</option>
                                @endif
                              </select>
                        </div>
                        <div class="add_card margin-20">
                            <label for="category">Categoria</label>
                            <select name="category" id="category" required>
                                @foreach ($categories as $category)
                                    @if ($category->id == $movement->category_id)
                                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                              </select>
                        </div>
                        <div class="add_card margin-20">
                            <label for="file">File (solo .png o .jpeg)</label>
                            <input style="color: white" type="file" id="file" name="file" accept="image/png, image/jpeg" />
                        </div>
                        <div class="margin-20" style="display: flex; justify-content:center; gap:30px;">
                            <div style="text-align: center">
                                <input type="submit" value="Salva" class="button btn-save" name="action" >
                            </div>
                            <div style="text-align: center">
                                <input type="submit" name="action"  value="Elimina" class="button btn-del">
                            </div>
                        </div>
                        
                        
                    </form>
                    
                </div>
            </div>


            

        </div>
    </div>
    
</x-app-layout>
<script>

function getNewCategories(typeSelected) {
    var value = typeSelected.value; 
    var url = "/common/categories_by/movement_type_id?movement_type_id="+ value
    getData(url)
    
    }

    function getData(url){
        fetch(url)
        .then(response =>  response.json())
        .then(data => {
            var categories_select = document.getElementById("category");
            var length = categories_select.options.length;
            for (i = length-1; i >= 0;i--) {
                categories_select.remove(i);
            }
            var categories_array = data.categories
            categories_array.forEach(element => {
                var opt = document.createElement('option');
                opt.value = element["id"];
                opt.innerHTML = element["name"];
                categories_select.appendChild(opt);
            });
        })
        .catch(error => {
            console.error(error);
        });
    }
   
</script>
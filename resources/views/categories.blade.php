<style>



/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #000000;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: white;
  text-decoration: none;
  cursor: pointer;
}

@media only screen and (max-width: 992px){
    .margin-20{
        margin-top: 30px !important
    }

    .card{
        width: 100%;
    }

}

/*
Other style in style.css
*/    
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('build/assets/style.css') }}" rel="stylesheet">
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="title-div margin-20">
                <div class="circle"></div>
                <h2 class="title">Manage categories</h2>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg margin-20" style="padding: 20px;min-height:300px">
                <div style="display:flex;justify-content:flex-end;">
                    <button style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;
                    font-size:18px;font-weight:500;" class="radius" onclick="addNewCategory()">Add</button>
                </div>
                <div style="display: flex; justify-content:space-around; margin-top:30px;flex-wrap:wrap">
                    <div style="text-align:center; width:500px">
                        <h2 class="title">Categories for expenses</h2>
                        <div id="categories_out_container">
                            @foreach ($categories_out as $category)
                            <div class="radius margin-20 card center" style="text-align: center; align-items:center" id="category_{{$category->id}}">
                                <div style="display:flex; align-items:center; gap:10px">
                                    <img width="40" height="40" src="{{$category->file}}" alt="icon-movement"/>
                                    <h2 class="text-purple">{{ $category->name }}</h2>
                                </div>
                                <div >
                                    <button class="radius" onclick="editCategory('{{$category->id}}', '{{$category->file}}', '{{$category->name}}',1)" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;
                        font-size:18px;font-weight:500;">Edit</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="width:500px; text-align:center">
                        <h2 class="title">Categories for earnings</h2>
                        <div id="categories_in_container">
                            @foreach ($categories_in as $category)
                            <div class="radius margin-20 card center" style="text-align: center; align-items:center" id="category_{{$category->id}}">
                                <div style="display:flex; align-items:center; gap:10px">
                                    <img width="40" height="40" src="{{$category->file}}" alt="icon-movement"/>
                                    <h2 class="text-purple">{{ $category->name }}</h2>
                                </div>
                                <div >
                                    <button class="radius" onclick="editCategory('{{$category->id}}', '{{$category->file}}', '{{$category->name}}',2)" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;
                        font-size:18px;font-weight:500;">Edit</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <span class="close" id="closeModal" onclick="closeModalView()">&times;</span>
            <div class="margin-20" style="display:flex; gap: 30px;">
                <span style="color: aliceblue; width:200px;">Category icon (from icons8 - 50pixel)</span>
                <input type="text" name="" id="categoryLink" placeholder="https://img.icons8.com/ios/50/discord-logo--v1.png">
            </div>
            <div class="margin-20" style="display:flex; gap: 30px;">
                <span style="color: aliceblue; width:200px;">Name</span>
                <input type="text" name="" id="categoryName" placeholder="Name" style="">
            </div>
            <div class="margin-20" style="display:flex; gap: 30px;">
                <span style="color: aliceblue; width:200px;">Type</span>
                <select name="type" id="categoryType">
                    <option value="1" selected="selected">Expenses</option>
                    <option value="2">Earnings</option>
                </select>
            </div>
            <div style="display:flex; gap: 30px; justify-content:center;margin-top:30px">
                <button id="btn_delete_cancel_categories" class="radius" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#C10B0B;
                    font-size:18px;font-weight:500;">Delete</button>
                <button class="radius" onclick="saveCategory()" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;
                    font-size:18px;font-weight:500;">Save</button>
            </div>
        </div>
  
    </div>
    
</x-app-layout>

<script>

const modal = document.getElementById("myModal");
const closeModal = document.getElementById("closeModal");
const categoryLink = document.getElementById("categoryLink");
const categoryName = document.getElementById("categoryName");
const categoryType = document.getElementById("categoryType");
const btnDeleteCancelCategories = document.getElementById("btn_delete_cancel_categories");
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const categoriesInContainer = document.getElementById("categories_in_container");
const categoriesOutContainer = document.getElementById("categories_out_container");

var category_id = -1

function resetModalValues(){
    categoryLink.value = "";
    categoryName.value = "";
    categoryType.selectedIndex = 0;
}

function closeModalView(){
  modal.style.display = "none";
  resetModalValues();
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    resetModalValues();
  }
}

function editCategory(id, fileLink, name, type){
    //type==2 -> entrata
    categoryLink.value = fileLink;
    categoryName.value = name;
    categoryType.selectedIndex = type-1;
    category_id = id;
    btnDeleteCancelCategories.setAttribute("onclick", "deleteCategory()");
    btnDeleteCancelCategories.innerText = "Delete"
    modal.style.display = "block";
}

function addNewCategory(){

    category_id = -1
    btnDeleteCancelCategories.innerText = "Cancel"
    btnDeleteCancelCategories.setAttribute("onclick", "cancelCategorySave()");
    modal.style.display = "block";
}

function saveCategory(){
    url = "/categories";
    categoryLink.value = categoryLink.value.trim()
    categoryName.value = categoryName.value.trim()
    if (categoryLink.value == "" || categoryName.value == ""){
        alert("Unable to save category: One or more items are null")
        return
    }
    fetch(url, {
    method: "POST",
    body: JSON.stringify({
        link: categoryLink.value,
        name: categoryName.value,
        type: categoryType.value,
        id: category_id
    }),
    headers: {
        "Content-type": "application/json; charset=UTF-8",
        "X-CSRF-TOKEN": csrfToken // Includi il token CSRF
    }
    })
    .then((response) => response.json())
    .then((data) => {
        alert(2)
        console.log(data);
        
        var category = data.category;
        if (category_id==-1){
            buildNewCategory(category.id, category.name, category.file, category.movement_type_id)
        } else{
            buildUpdatedCategory(category.name, category.file, category.movement_type_id)
        }
        closeModalView()
    })
    .catch((error) => console.error('Error:', error));
}

function buildNewCategory(id, name, file, movement_type){
    var element = null
    if(movement_type==1){
        element = categoriesOutContainer
    } else if(movement_type==2){
        element = categoriesInContainer
    }
    
    html = ""
    html += '<div class="radius margin-20 card center" style="text-align: center; align-items:center" id="category_' + id + '">'
    html += '<div style="display:flex; align-items:center; gap:10px">'
    html += '<img width="40" height="40" src="' + file + '" alt="icon-movement"/>'
    html += '<h2 class="text-purple">' + name + '</h2>'
    html += '</div><div >'
    var args = "'" + id + "', '" + file + "', '" + name + "','" + movement_type + "'";
    html += '<button class="radius" onclick="editCategory(' + args + ')" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;font-size:18px;font-weight:500;">Modifica</button>'
    html += ' </div></div>'

    element.innerHTML += html
}

function buildUpdatedCategory(name, file, movement_type){
    var element = null
    if(movement_type==1){
        element = categoriesOutContainer
    } else if(movement_type==2){
        element = categoriesInContainer
    }

    document.getElementById("category_" + category_id).remove()
    
    html = ""
    html += '<div class="radius margin-20 card center" style="text-align: center; align-items:center" id="category_' + category_id + '">'
    html += '<div style="display:flex; align-items:center; gap:10px">'
    html += '<img width="40" height="40" src="' + file + '" alt="icon-movement"/>'
    html += '<h2 class="text-purple">' + name + '</h2>'
    html += '</div><div >'
    var args = "'" + category_id + "', '" + file + "', '" + name + "','" + movement_type + "'"; //+ category_id + ', "' + file + '", "' + name + '",' + movement_type + 
    //alert(args)
    html += '<button class="radius" onclick="editCategory(' + args + ')" style="width:120px;height:50px;color:rgb(231, 228, 228);background-color:#7D3CED;font-size:18px;font-weight:500;">Modifica</button>'
    html += ' </div></div>'

    element.innerHTML += html
}

function deleteCategory(){

    url = "/categories";
    fetch(url, {
    method: "DELETE",
    body: JSON.stringify({
        id: category_id
    }),
    headers: {
        "Content-type": "application/json; charset=UTF-8",
        "X-CSRF-TOKEN": csrfToken // Includi il token CSRF
    }
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success){
            deleteCategoryView()
            closeModalView()
        } else{
            alert(data.messagge)
        }
        
    })
    .catch((error) => console.error('Error:', error));
}

function deleteCategoryView(){
    document.getElementById("category_" + category_id).remove()
}

function cancelCategorySave(){
    closeModalView()
}

</script>
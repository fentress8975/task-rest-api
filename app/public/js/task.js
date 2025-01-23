const taskName = document.getElementById('search_task');


const edit_name = document.getElementById('edit_name');
const edit_description = document.getElementById('edit_desc');
const edit_dueDate = document.getElementById('edit_due_date');
const edit_createdAt = document.getElementById('edit_created_at');
const edit_status = document.getElementById('search_task');
const edit_priority = document.getElementById('edit_priority');
const edit_category = document.getElementById('edit_category');

let task = {
    name:'',
    description:'',
    dueDate:'',
    createdAt:'',
    status:'',
    priority:'',
    category:'',
}

async function task_get_all(){
    const response = await fetch("http://localhost/api/v1/task/read");
    const data = await response.json();
    console.log(data);
}

async function task_search() {
    const response = await fetch("http://localhost/search/?" + new URLSearchParams({
        name: taskName.value,
    }).toString());
    const data = await response.json();
}

function edit_task() {

}

function create_task() {

}

function delete_task() {

}



async function searchInDB() {
    const searchInput = document.getElementById("search");
    const response = await fetch("http://localhost/search/?" + new URLSearchParams({
        sortColumn: searchInput.value,
    }).toString());
    const data = await response.json();
    generateTable(data);
};
<?php
function createTask()
{
    $database = new Database();
    $db = $database->getConnection();

    $task = new Task($db);
    return $task;
}

function setPOSTHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

function setGETHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");
}

function checkRequiredFields(mixed $data): bool
{
    return !empty($data['name']) &&
        !empty($data['due_date']) &&
        !empty($data['priority']) &&
        !empty($data['category']);
}

function setFields(mixed $data, Task $task): void
{
    if (!empty($data['id'])) {
        $task->id = $data['id'];
    }
    $task->name = $data['name'];
    if (!empty($data['description'])) {
        $task->description = $data['description'];
    }
    $task->due_date = $data['due_date'];
    if (!empty($data['created_at'])) {
        $task->created_at = $data['created_at'];
    }
    if (!empty($data['status'])) {
        $task->status = $data['status'];
    }
    $task->priority = $data['priority'];
    $task->category = $data['category'];
}

function createJsonListOfTasks($stmt)
{
    $tasksList = array();
    $tasksList["tasks"] = array();

    while ($row = $stmt->fetch_assoc()) {
        extract($row);
        $task = array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "due_date" => $due_date,
            "created_at" => $created_at,
            "status" => $status,
            "priority" => $priority,
            "category" => $category,
        );
        $tasksList["tasks"][] = $task;
    }
    return $tasksList;
}

function setSortParams(Task $task)
{
    $task->sortColumnName = $_GET["sortColumnName"] ?? '';
    $task->sortColumnParam = $_GET["sortColumnParam"] ?? '';
    $task->page = $_GET["page"] ?? 1;
    $task->itemsPerPage = $_GET["itemsPerPage"] ?? 20;
}

function setID($task)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $task->id = $data['id'];
    }
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $task->id = $_GET["id"] ?? null;
    }
}
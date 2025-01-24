<?php
/**
 * Create Task object with db connection
 * @return Task
 */
function createTask()
{
    $database = new Database();
    $db = $database->getConnection();

    $task = new Task($db);
    return $task;
}

/**
 * Set basic POST headers
 * @return void
 */
function setPOSTHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

/**
 * Set base GET headers
 * @return void
 */
function setGETHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");
}

function setDeleteHeaders(){
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

/**
 * Check array for all needed columns for create
 * @param mixed $data
 * @return bool
 */
function checkRequiredFields(mixed $data): bool
{
    return !empty($data['name']) &&
        !empty($data['due_date']) &&
        !empty($data['priority']) &&
        !empty($data['category']);
}

/**
 * Set given values for rows in Task object
 * @param Task $task object where values setup
 * @param $data array with associated values
 * @return void
 */
function setFields(Task $task, $data = null): void
{
    if (!isset($data)) {
        $data = json_decode(file_get_contents('php://input'), true);
    }

    if (!empty($data['id'])) {
        $task->id = $data['id'];
    }
    if (!empty($data['name'])) {
        $task->name = $data['name'];
    }
    if (!empty($data['description'])) {
        $task->description = $data['description'];
    }
    if (!empty($data['due_date'])) {
        $task->due_date = $data['due_date'];
    }
    if (!empty($data['created_at'])) {
        $task->created_at = $data['created_at'];
    }
    if (!empty($data['status'])) {
        $task->status = $data['status'];
    }
    if (!empty($data['priority'])) {
        $task->priority = $data['priority'];
    }
    if (!empty($data['category'])) {
        $task->category = $data['category'];
    }
    if (!empty($data['deleted'])) {
        $task->deleted = $data['deleted'];
    }
}

/**
 * Generate json array to front
 * @param $stmt
 * @return array
 */
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

/**
 * Set gived sorted params inside Task object
 * @param Task $task
 * @return void
 */
function setSortParams(Task $task)
{
    $task->sortColumnName = $_GET["sortColumnName"] ?? '';
    $task->sortColumnParam = $_GET["sortColumnParam"] ?? '';
    $task->page = $_GET["page"] ?? 1;
    $task->itemsPerPage = $_GET["itemsPerPage"] ?? 20;
}

/**
 * Set given id in Task object. Search id in body or request_uri
 * @param $task
 * @return void
 */
function setID($task)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $task->id = $data['id'];
    } else {
        $id = explode('/', $_SERVER['REQUEST_URI']);
        $id = intval(array_pop($id));
        if ($id) {
            $task->id = $id;
        } else {
            $task->id = -1;
        }

    }
}
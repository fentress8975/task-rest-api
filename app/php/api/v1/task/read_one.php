<?php
include_once "base.php";
setGETHeaders();

include_once PHP_DIR . "database/database.php";
include_once API_DIR . "v1/objects/task.php";

$task = createTask();

$task->id = getID();
$task->readOne();

if ($task->id != null) {
    $tasks_arr = array(
        "id" => $task->id,
        "description" => $task->description,
        "due_date" => $task->due_date,
        "created_at" => $task->created_at,
        "status" => $task->status,
        "priority" => $task->priority,
        "category" => $task->category,
    );

    http_response_code(200);

    echo json_encode($tasks_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Такой задачи нет"));
}

function getID()
{
    $id = explode('/',$_SERVER["REQUEST_URI"]);
    return end($id);
}
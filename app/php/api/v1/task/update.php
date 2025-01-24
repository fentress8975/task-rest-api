<?php
include_once "base.php";
setPOSTHeaders();

include_once PHP_DIR . "database/database.php";
include_once API_DIR . "v1/objects/task.php";

$task = createTask();

$data = json_decode(file_get_contents('php://input'), true);

setFields($task);

if ($task->update()) {
    http_response_code(200);

    echo json_encode(array("message" => "Задача обновлена"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Невозможно обновить задачу"));
}
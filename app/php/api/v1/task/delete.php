<?php
include_once "base.php";
setPOSTHeaders();

include_once PHP_DIR . "database/database.php";
include_once API_DIR . "v1/objects/task.php";

$task = createTask();

$data = json_decode(file_get_contents('php://input'), true);

$task->name = $data['name'];

if ($task->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Пользователь был удалён"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Не удалось удалить пользователя"));
}
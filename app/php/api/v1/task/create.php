<?php
include_once "base.php";
setPOSTHeaders();

include_once PHP_DIR . "database/database.php";
include_once API_DIR . "v1/objects/task.php";

$task = createTask();

$data = json_decode(file_get_contents('php://input'), true);

if (
    checkRequiredFields($data)
) {
    setFields($data, $task);

    if ($task->create()) {
        http_response_code(201);

        echo json_encode(array("message" => "Задача создана"));
    } else {
        http_response_code(503);

        echo json_encode(array("message" => "Невозможно создать задачу"));
    }
} else {
    http_response_code(400);

    echo json_encode(array("message" => "Невозможно создать задачу. Нету необходимых данных"));
}

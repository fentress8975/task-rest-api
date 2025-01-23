<?php
include_once "base.php";
setGETHeaders();

include_once PHP_DIR . "database/database.php";
include_once API_DIR . "v1/objects/task.php";

$task = createTask();

$task->read();

$stmt = $task->read()->get_result();
$num = $stmt->num_rows;

if ($num > 0) {
    $tasksList = createJsonListOfTasks($stmt);

    http_response_code(200);

    echo json_encode($tasksList);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Задачи не найдены"));
}
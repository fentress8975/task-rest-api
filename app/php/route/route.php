<?php
const API_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR;
const PHP_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

if (!($_SERVER["REQUEST_URI"])) {
    http_response_code(400);
    echo "Пустой запрос";
    die();
}

$arg = explode("/", $_SERVER["REQUEST_URI"]);

if ($arg[1] === "api") {

    $version = $arg[2];

    switch ($arg[3]) {
        case 'task':
            executeTaskMethod($arg[4]);
            break;

        default:
            http_response_code(400);
            echo "Неверный запрос {$_SERVER["REQUEST_URI"]}";
            die();
            break;
    }
} else if ($arg[1] === "edit") {

}

function executeTaskMethod($arg)
{
    $arg = explode("?", $arg);
    switch ($arg[0]) {
        case 'create':
            include_once API_DIR . "v1/task/create.php";
            break;
        case 'read':
            include_once API_DIR . "v1/task/read.php";
            break;
        case 'read_one':
            include_once API_DIR . "v1/task/read_one.php";
            break;
        case 'update':
            include_once API_DIR . "v1/task/update.php";
            break;
        case 'delete':
            include_once API_DIR . "v1/task/delete.php";
            break;
        default:
            http_response_code(400);
            echo "Такого метода не существует $arg[0]";
            break;
    }
    die();
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <script src="js/task.js" type="text/javascript" defer></script>
</head>
<body>
<main>
    <?php
    echo __DIR__;
    ?>
    <!--    Блок Поиск задачи-->
    <div>
        <label for="search_task">Найти задачу</label>
        <input type="text" name="search_task" id="search_task" minlength="3" value="laudanti" required>
        <button onclick="task_search()">Найти</button>
        <button onclick="task_get_all()">Dct</button>
    </div>

    <!--    Конец блока Поиск задачи-->
    <br>
    <!--    Блок для создания задачи-->
    <!--    <div> -->
    <!--        <label for="create_task">Создать задачу</label>-->
    <!--        <input type="text" name="create_task" id="create_task" minlength="3" value="laudanti" required>-->
    <!--        <button onclick="create_task()">Найти</button>-->
    <!--    </div> -->
    <!--    Конец Блок для создания задачи-->


</main>
</body>
</html>
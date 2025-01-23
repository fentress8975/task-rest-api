<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!--    Блок для редактирования задачи-->
<div>
    <label for="edit-form">Изменить/Создать задачу</label>
    <form name="edit-form">

    </form>
    <label for="edit_name">Название</label>
    <input type="text" name="edit_name" id="edit_name" minlength="1" maxlength="255" value="" required>

    <label for="edit_desc">Описание</label>
    <input type="text" name="edit_desc" id="edit_desc" value="">

    <label for="edit_due_date">Срок выполнения</label>
    <input type="text" name="edit_due_date" id="edit_due_date" minlength="3" value="" required>

    <label for="edit_created_at">Дата создания</label>
    <input type="text" name="edit_created_at" id="edit_created_at" minlength="3" value="" required>

    <label for="edit_status">Статус</label>
    <input type="text" name="edit_status" id="edit_status" minlength="3" value="" required>

    <label for="edit_priority">Приоритет</label>
    <input type="text" name="edit_priority" id="edit_priority" minlength="3" value="" required>

    <label for="edit_category">Категория</label>
    <input type="text" name="edit_category" id="edit_category" minlength="3" value="" required>

    <button onclick="edit_task()">Изменить</button>
    <button onclick="create_task()">Создать</button>
    <button onclick="delete_task()">Удалить</button>
</div>
<div>
    <button onclick="edit_task()">Вернуться</button>
</div>
<!--    Конец Блок для редактирования задачи-->
</body>
</html>

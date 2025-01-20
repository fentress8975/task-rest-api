<?php
//Получение списка задач
//GET /api/tasks
//Описание: Возвращает список задач с возможностью поиска и сортировки.
//Параметры запроса (опционально):
//
//search: поиск по названию.
//sort: due_date, created_at.
//Пример запроса:
///api/tasks?search=Задача1&sort=due_date
//
//    Ответ:
//
//[ { "id": 1, "title": "Задача1", "description": "Задача1 описание", "due_date": "2025-01-20T15:00:00", "create_date": "2025-01-20T15:00:00", "status": "pending", "priority": "высокий", "category": "Работа", "status": "не выполнена" } ]
echo 'user read' . PHP_EOL;
<?php
//Получение конкретной задачи
//GET /api/tasks/{id}
//Описание: Возвращает задачу по её ID.
//Ответ:
//
//{ "id": 1, "title": "Задача1", "description": "Задача1 описание", "due_date": "2025-01-20T15:00:00", "create_date": "2025-01-20T15:00:00", "status": "pending", "priority": "высокий", "category": "Работа", "status": "не выполнена" }
echo 'user read' . PHP_EOL;
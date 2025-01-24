Разработать REST API для управления списком задач .
Функционал приложения:
    
Создание задачи: Задача должна включать следующие поля:
    Название (строка, обязательно, до 255 символов).
    Описание (текст, опционально, без ограничений).
    Срок выполнения (дата и время).
    Дата создания (дата и время).
    Статус (выполнена/не выполнена).
    Приоритет (низкий, средний, высокий).
    Категория (например, "Работа", "Дом", "Личное").

Просмотр списка задач:
    Возможность поиска по названию .
    Сортировка по дате выполнения .

Редактирование задачи: возможность изменить любое из полей.

Удаление задачи.


    Работа с задачами
    
    Создание задачи
    POST /api/v1/tasks/create
    Описание: Создает новую задачу.
    Обязательные данные: name, description, due_date, priority('low','medium','high'),category
    Тело запроса:

    { "name": "Задача1", "description": "Задача1 описание", "due_date": "2025-01-20T15:00:00", "create_date": "2025-01-20T15:00:00", "priority": "high", "category": "Работа", "status": "не выполнена" }

    Ответ:

    { "id": 1, "message": "Задача создана }

    Получение списка задач
    GET /api/v1/tasks
    Описание: Возвращает список задач с возможностью поиска и сортировки.
    Параметры запроса (опционально):
    page:страница.
    itemsPerPage:кол-во элементов на странице
    sortColumnName: сортировка по имени столбца.
    sortColumnParam: сортировка по ASC DESC

    Пример запроса:
    api/v1/task/read?page=2&itemsPerPage=5&sortColumnName=name&sortColumnParam=ASC

    Ответ:

    {
    "tasks": [
        {
            "id": 27,
            "name": "at turpis donec posuere metus vitae ipsum aliquam non mauris morbi non lectus aliquam sit amet diam in magna",
            "description": "Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.",
            "due_date": "2024-01-31 00:00:00",
            "created_at": "2025-01-23 18:09:58",
            "status": 0,
            "priority": "high",
            "category": "morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra"
        }]

    Получение одной задачи по id
    GET api/v1/task/read_one/{id}
    Описание: Возвращает задачу по её ID.

    Пример запроса:
    api/v1/task/read_one/5
    Ответ:

    {
    "id": 5,
    "description": "Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.\n\nDuis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.",
    "due_date": "2024-03-10 00:00:00",
    "created_at": "2025-01-23 18:09:58",
    "status": true,
    "priority": "high",
    "category": "in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque arcu libero rutrum"
    }

    Обновление задачи
    POST /api/v1/task/update
    Описание: Обновляет информацию о задаче.
    Тело запроса:

    { "name": "Задача1", "description": "Задача1 описание", "due_date": "2025-01-20T15:00:00", "create_date": "2025-01-20T15:00:00", "priority": "high", "category": "Работа", "status": "0=1" }

    Ответ:

    { "message": "Задача обновлена" }

    Удаление задачи
    DELETE /api/v1/task/delete/{id}
    Описание: Удаляет задачу по её ID.
    Ответ:

    { "message": "Задача была удалена" }

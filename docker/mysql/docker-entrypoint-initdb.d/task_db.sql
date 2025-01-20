CREATE DATABASE tasks;

CREATE TABLE `tasks`.`tasks`
(
    `name`        VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `due_date`    DATETIME     NOT NULL,
    `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status`      BOOLEAN      NOT NULL DEFAULT FALSE,
    `priority` SET('low','medium','high') NOT NULL,
    `category`    TEXT         NOT NULL
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;


CREATE USER 'task_user'@'%' IDENTIFIED BY 'task_user';
GRANT SELECT, INSERT, UPDATE, DELETE ON tasks.* TO 'task_user'@'%';
flush privileges;
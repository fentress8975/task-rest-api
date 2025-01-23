<?php

class Database
{
    private $host     = 'mysql';
    private $dbname   = 'tasks';
    private $user     = 'task_user';
    private $password = 'task_user';
    private $port     = 3306;
    private $charset  = 'utf8mb4';

    public $db;

    public function getConnection()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->db = new mysqli($this->host, $this->user, $this->password, $this->dbname, $this->port);
            $this->db->set_charset($this->charset);
            $this->db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
            return $this->db;
        } catch (\Throwable $th) {
            echo "Ошибка подключения к БД: ". PHP_EOL;
            echo $th->getMessage();
            die();
        }
    }

    function __destruct()
    {
        //echo 'DB connection died' . PHP_EOL;
    }
}
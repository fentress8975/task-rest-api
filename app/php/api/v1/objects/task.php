<?php

class Task
{

    private mysqli $db;
    private $table_name = 'tasks';

    public $id;
    public $name;
    public $description;
    public $due_date;
    public $created_at;
    public $status;
    public $priority;
    public $category;
    public $deleted;

    public int $page;
    public int $pageCount;
    public int $offset;
    public int $itemsPerPage;
    public int $insertedId;


    public string $sortColumnParam = 'ASC';
    public string $sortColumnName = 'id';

    function __construct($db)
    {
        $this->db = $db;
    }

    function read($sortColumnParam = '', $sortColumnName = '')
    {
        $this->prepareSQLParams();
        $sql = "SELECT id, name, description, due_date, created_at, status, priority, category 
                FROM $this->table_name 
                WHERE deleted = 0 
                ORDER BY $this->sortColumnName $this->sortColumnParam
                LIMIT $this->itemsPerPage OFFSET $this->offset";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function readOne()
    {
        $sql = "SELECT name, description, due_date, created_at, status, priority, category FROM $this->table_name WHERE id = ? AND deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);
        $row = $stmt->get_result()->fetch_assoc();

        if (!isset($row)) {
            $this->id = null;
        } else {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->due_date = $row['due_date'];
            $this->created_at = $row['created_at'];
            $this->status = $row['status'];
            $this->priority = $row['priority'];
            $this->category = $row['category'];
        }
    }

    function create()
    {
        $sql = '';
        $values = array();
        $this->prepareSQLCreateQuery($sql, $values);
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($values)) {
            $this->insertedId = $stmt->insert_id;
            return true;
        }

        return false;
    }

    function prepareSQLCreateQuery(&$sql, &$values)
    {
        $sql = "INSERT INTO $this->table_name(name,due_date,priority,category";
        $values = [$this->name, $this->due_date, $this->priority, $this->category];
        if (isset($this->description)) {
            $sql .= ",description";
            $values[] = $this->description;
        }
        if (isset($this->created_at)) {
            $sql .= ",created_at";
            $values[] = $this->created_at;
        }
        if (isset($this->status)) {
            $sql .= ",status";
            $values[] = $this->status;
        }
        $sql .= ") VALUES (";
        $sql .= str_repeat("?,", count($values));
        $sql = rtrim($sql, ",");
        $sql .= ")";
    }

    function delete()
    {
        $sql = "UPDATE {$this->table_name} SET deleted = 1 WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$this->id])) {
            return true;
        } else {
            return false;
        }
    }

    function update()
    {
        $sql = '';
        $values = array();
        $this->prepareSQLUpdateQuery($sql, $values);

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($values)) {
            return true;
        }

        return false;
    }

    function prepareSQLUpdateQuery(&$sql, &$args)
    {
        $sql = "UPDATE {$this->table_name} SET ";
        if (!empty($this->name)) {
            $sql .= "name = ?,";
            $args[] = $this->name;
        }
        if (!empty($this->description)) {
            $sql .= "description = ?,";
            $args[] = $this->description;
        }
        if (!empty($this->due_date)) {
            $sql .= "due_date = ?,";
            $args[] = $this->due_date;
        }
        if (!empty($this->created_at)) {
            $sql .= "created_at = ?,";
            $args[] = $this->created_at;
        }
        if (!empty($this->status)) {
            $sql .= "status = ?,";
            $args[] = $this->status;
        }
        if (!empty($this->priority)) {
            $sql .= "priority = ?,";
            $args[] = $this->priority;
        }
        if (!empty($this->category)) {
            $sql .= "category = ?,";
            $args[] = $this->category;
        }
        $sql = rtrim($sql, ",");
        $sql .= " WHERE id = ?";
        $args[] = $this->id;
    }

    private function prepareSQLParams()
    {
        $this->preparePagination();
        $this->getPageCount();
        $this->getSortOrder();
        $this->getSortColumn();
    }

    private function preparePagination()
    {
        $this->pageCount = $this->getPageCount();
        $this->offset = ($this->page - 1) * $this->itemsPerPage;
    }

    private function getPageCount()
    {
        $sql = "SELECT COUNT(*) AS cnt FROM $this->table_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ceil($result["cnt"] / $this->itemsPerPage);
    }

    private function getSortOrder()
    {
        $this->sortColumnParam = match (strtoupper($this->sortColumnParam)) {
            'DESC' => "DESC",
            default => "ASC",
        };
    }

    private function getSortColumn()
    {
        $sql = "SELECT * FROM $this->table_name WHERE deleted = 0 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $columns = array_keys($result->fetch_assoc());

        if (!in_array($this->sortColumnName, $columns)) {
            $this->sortColumnName = $columns[0];
        }
    }
}
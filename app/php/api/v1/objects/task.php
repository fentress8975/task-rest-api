<?php

class Task
{

    private mysqli $db;
    private string $table_name = 'tasks';

    public int $id;
    public string $name;
    public string $description;
    public string $due_date;
    public string $created_at;
    public bool $status;
    public string $priority;
    public string $category;
    public bool $deleted;

    /**
     * @var int current page in pagination
     */
    public int $page;
    /**
     * @var int max page count by given value of $itemsPerPage and rows in table
     */
    public int $pageCount;
    public int $offset;
    public int $itemsPerPage;
    /**
     * @var int stored id of created row
     */
    public int $insertedId;


    public string $sortColumnParam = 'ASC';
    public string $sortColumnName = 'id';

    /**
     * Init object with working connection
     *
     */
    function __construct($db)
    {
        $this->db = $db;
    }


    /**
     * select all rows and columns(exclude deleted) from table in var $table_name
     * @return false|mysqli_stmt - stmt object for manipulating data
     */
    function read(): false|mysqli_stmt
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

    /**
     * read only one row by given id in var $id. Store all data inside object vars.
     * @return void
     */
    function readOne(): void
    {
        $sql = "SELECT name, description, due_date, created_at, status, priority, category FROM $this->table_name WHERE id = ? AND deleted = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);
        $row = $stmt->get_result()->fetch_assoc();

        if (!isset($row)) {
            $this->id = -1;
        } else {
            $this->name = $row['name'];
            $this->description = $row['description']??'';
            $this->due_date = $row['due_date'];
            $this->created_at = $row['created_at'];
            $this->status = $row['status'];
            $this->priority = $row['priority'];
            $this->category = $row['category'];
        }
    }

    /**
     * Create new row in table by given required variables(name,due_date,priority,category), Non required have default value.
     * Store id of new row in $insertedId
     * @return bool
     */
    function create(): bool
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

    /**
     * Generate param query for given columns
     * @param $sql
     * @param $values
     * @return void
     */
    private function prepareSQLCreateQuery(&$sql, &$values): void
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

    /**
     * Set colum deleted to True for given row by id.
     * @return bool
     */
    function delete(): bool
    {
        $sql = "UPDATE $this->table_name SET deleted = 1 WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);
        if ($stmt->affected_rows === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * update row by id. use given values. Values for columns stored inside class vars
     * @return bool
     */
    function update(): bool
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

    /**
     * Generate param query for given columns
     * @param $sql
     * @param $args
     * @return void
     */
    function prepareSQLUpdateQuery(&$sql, &$args): void
    {
        $sql = "UPDATE $this->table_name SET ";
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

    private function prepareSQLParams(): void
    {
        $this->preparePagination();
        $this->getSortOrder();
        $this->getSortColumn();
    }

    private function preparePagination(): void
    {
        $this->pageCount = $this->getPageCount();
        $this->offset = ($this->page - 1) * $this->itemsPerPage;
    }

    /**
     * Calculate pages for given $itemsPerPage
     * @return int
     */
    private function getPageCount(): int
    {
        $sql = "SELECT COUNT(*) AS cnt FROM $this->table_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ceil($result["cnt"] / $this->itemsPerPage);
    }

    /**
     * Check for given sort Order given by user, Use default if given incorrect.
     * @return void
     */
    private function getSortOrder(): void
    {
        $this->sortColumnParam = match (strtoupper($this->sortColumnParam)) {
            'DESC' => "DESC",
            default => "ASC",
        };
    }

    /**
     * Check for given sort column Name given by user, Use default if given incorrect.
     * @return void
     */
    private function getSortColumn(): void
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
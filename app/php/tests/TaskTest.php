<?php

use PHPUnit\Framework\TestCase;

const PHP_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

include_once PHP_DIR . "database/database.php";
include_once PHP_DIR . "api/v1/objects/task.php";
include_once PHP_DIR . "api/v1/task/base.php";

class TaskTest extends TestCase
{
    private $task;

    public static function deleteDataProvider()
    {
        return array(
            array(15, -1),
            array(20, -1),
            array(25, -1)
        );
    }

    public static function readOneDataProvider()
    {
        return array(
            array(1, -1),
            array(5, 5),
            array(10, 10)
        );
    }

    public static function updateDataProvider()
    {
        return array(
            array(30, 'test1'),
            array(35, 'test2'),
            array(40, 'test3')
        );
    }

    public static function createDataProvider()
    {
        return array(
            array('name', 'desc', '2024-03-10 00:00:00', true, 'high', 'categor'),
        );
    }


    protected function setUp(): void
    {
        $this->task = createTask();
    }

    protected function tearDown(): void
    {
        $this->task = NULL;
    }



    /**
     * @dataProvider readOneDataProvider
     */
    public function testReadOne($id, $expected)
    {
        $this->task->id = $id;
        $this->task->readOne();
        $this->assertEquals($this->task->id, $expected);
    }

    /**
     * @dataProvider deleteDataProvider
     */
    public function testDelete($id, $expected)
    {
        $this->task->id = $id;
        $this->task->delete();

        $this->task->readOne();
        $this->assertEquals($this->task->id, $expected);
    }


    /**
     * @dataProvider updateDataProvider
     */
    public function testUpdate($id, $expected)
    {
        $this->task->id = $id;
        $this->task->name = $expected;
        $this->task->update();

        unset($this->task->name);

        $this->task->readOne();
        $this->assertEquals($this->task->name, $expected);
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreate($name, $desc, $due_date, $status, $priority, $category)
    {
        $data = array();
        $data['name'] = $name;
        $data['description'] = $desc;
        $data['due_date'] = $due_date;
        $data['status'] = $status;
        $data['priority'] = $priority;
        $data['category'] = $category;
        setFields($this->task,$data);
        $this->task->create();
        $id = $this->task->insertedId;

        $this->tearDown();
        $this->setUp();

        $this->task->id = $id;
        $this->task->readOne();
        $this->assertEquals($this->task->name, $name);
        $this->assertEquals($this->task->description, $desc);
        $this->assertEquals($this->task->due_date, $due_date);
        $this->assertEquals($this->task->status, $status);
        $this->assertEquals($this->task->priority, $priority);
        $this->assertEquals($this->task->category, $category);
    }
//
//    public function testRead()
//    {
//
//    }
}

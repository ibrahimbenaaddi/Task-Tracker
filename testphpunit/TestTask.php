<?php

use App\Model\Task;
use PHPUnit\Framework\TestCase;

class TestTask extends TestCase
{
    public function testInfoTask()
    {
        $id = 15;
        $description = "test class Task";
        $taskObj = new Task($id,$description);
        $task = $taskObj->infoTask();
        
        $expected =  [
            "id" => $id,
            "description" => $description,
            "status" => "todo",
            "createdAt" => date("Y-m-d H:i:s"),
            "updatedAt" => date("Y-m-d H:i:s")
        ];
        $this->assertSame($expected,$task);
    }
}

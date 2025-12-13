<?php

use PHPUnit\Framework\Attributes\DataProvider;
use App\Model\Task;
use PHPUnit\Framework\TestCase;

class TestTask extends TestCase
{
    public static function  taskProvider(): array
    {
        return [
            [15, "test taks 1"],
            [16, "test taks 2"],
            [17, "test taks 3"],
            [18, "test taks 4"],
        ];
    }

    #[DataProvider('taskProvider')]
    public function testInfoTask(int $id, string $description)
    {
        $taskObj = new Task($id, $description);
        $task = $taskObj->infoTask();

        $this->assertSame($id, $task['id']);
        $this->assertSame($description, $task['description']);

    }

}

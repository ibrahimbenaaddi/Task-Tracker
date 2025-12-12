<?php
namespace App\Controller;

require_once " ../Model/task.php";
require_once " ../View/view.php";
require_once " ../Service/dataService.php";


use App\Model\Task;
use App\View\View;
use App\Service\Data;
use Exception;

class TaskController
{
    use Data, View;

    public function index(): void
    {
        try {
            $tasks = self::getData();
            $this->showTasks($tasks);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }

    public function showByStatus(string $filter): void
    {
        try {
            $tasks = self::getData();
            $tasksFiltered  = array_filter($tasks, fn($task) => $task['status'] === $filter);
            $this->showTasks($tasksFiltered);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }

    public function showByID(int $id): void
    {
        try {
            $tasks = self::getData();
            $task  = current(array_filter($tasks, fn($task) => $task['id'] === $id)) ?? null;
            if (!$task) {
                throw new Exception("Your task that have ID : $id ,is Not Found");
            }
            $this->finTasks($task);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }
}

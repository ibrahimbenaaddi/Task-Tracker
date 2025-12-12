<?php

namespace App\Controller;

require_once __DIR__ . "/../View/view.php";
require_once __DIR__ . "/../Service/dataService.php";


use App\View\View;
use App\Service\Data;
use Exception;

class TaskController
{
    use Data, View;

    public static function index(): void
    {
        try {
            $tasks = self::getData();
            self::showTasks($tasks);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }

    public static function showByStatus(string $filter): void
    {
        try {
            $tasks = self::getData();
            $tasksFiltered  = array_filter($tasks, fn($task) => $task['status'] === $filter);
            self::showTasks($tasksFiltered);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }

    public static function showByID(int $id): void
    {
        try {
            $tasks = self::getData();
            $task  = current(array_filter($tasks, fn($task) => $task['id'] === $id)) ?? null;
            if (!$task) {
                throw new Exception("Your task that have ID : $id ,is Not Found");
            }
            self::findTasks($task);
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }
}
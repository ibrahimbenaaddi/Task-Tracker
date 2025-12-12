<?php

namespace App\Service;

require_once __DIR__ . "/../Model/task.php";
require_once __DIR__ . "/../Service/TaskService.php";

use App\Model\Task;
use App\Service\TaskService;
use Exception;
use JsonException;

trait Data
{
    use TaskService;

    private const PathDB  = __DIR__  . "/database.json";
    public const PathLog = __DIR__  . "/../Log/log.txt";

    public static function errorLog(string $message)
    {
        file_put_contents(self::PathLog, "the Error is : $message\n", FILE_APPEND);
    }

    public static function getData()
    {

        $data = json_decode(file_get_contents(self::PathDB), true);
        if (empty($data)) {
            throw new Exception("No data Found, plz Add Some Tasks");
        }
        return $data;
    }

    private static function saveInDB(array $tasks, string $description): array
    {
        $id = self::getLastId($tasks);
        $objTask = new Task($id, $description);
        $task = $objTask->infoTask();
        $tasks[] = $task;
        file_put_contents(self::PathDB, json_encode($tasks, JSON_PRETTY_PRINT));
        return $task;
    }
    public static function storeTask(string $description)
    {
        try {
            $tasks = self::getData();
            $task = self::saveInDB($tasks, $description);
            return $task;
        } catch (Exception) {
            $task = self::saveInDB([], $description);
            return $task;
        }
    }
    public static function deleteAll(){
        file_put_contents(self::PathDB,'');
    }
}

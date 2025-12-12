<?php

namespace App\Service;

trait TaskService
{

    public static function getLastID(array $tasks): int
    {
        $lastId = 0;
        foreach ($tasks as $task) {
            if ($task['id'] > $lastId) {
                $lastId = $task['id'];
            }
        }
        return ++$lastId;
    }
}

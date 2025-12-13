<?php

namespace App\Controller;

use App\View\View;
use App\Service\DataService;
use Exception;

class TaskController
{
    use DataService, View;

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

    public static function update(int $id)
    {
        $range = 4;

        echo "\nPlz choose a number to update\n";
        echo "1->Update Task\n";
        echo "2->Start the Task (statud = in-progress)\n";
        echo "3->Update status to done\n";
        echo "4->Exit\n";

        $choice = self::askTheUser($range);

        switch ($choice) {
            case $choice === 1:
                while (true) {
                    echo "\nEnter the new Task : ";
                    $description = trim(fgets(STDIN));
                    if (!empty($description)) {
                        self::updateTask($id, $description);
                        return;
                    }
                    echo ("Plz insert a task to Add");
                }
            case $choice === 2:
                self::updateTask($id, null, "in-progress");
                return;
            case $choice === 3:
                self::updateTask($id, null, "done");
                return;
            case $choice === 4:
                return;
        }
    }

    public static function delete(int $id)
    {
        $range = 2;

        echo "\nPlz choose a number from Option :\n";
        echo "1->Delete Task that have ID : $id \n";
        echo "2->Exit\n";

        $choice = self::askTheUser($range);

        switch ($choice) {
            case $choice === 1:
                while (true) {
                    echo "\nAre you sure Want to delete your Task The ID : $id yes/no : ";
                    $answer = trim(fgets(STDIN));
                    if (strtolower($answer) === "yes") {
                        self::deleteByID($id);
                        return;
                    }

                    if (strtolower($answer) === "no") {
                        return;
                    }
                    echo "\nAnswer By yes/no\n\n";
                }
            case $choice === 2:
                return;
        }
    }
}

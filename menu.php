<?php
if (!file_exists("./App/Service/database.json")) {
    touch("./App/Service/database.json");
}

require_once "./App/handler.php";
require_once "./App/Controller/TaskController.php";

use App\Handler;
use App\Controller\TaskController;

class Menu extends TaskController
{
    use Handler;

    private static function handleChoice(int $choice)
    {
        switch ($choice) {
            case $choice === 1:
                self::filterTask();
                return;
            case $choice === 2:
                while (true) {
                    try {
                        echo "\nPlz enter the ID of task : ";
                        $id = trim(fgets(STDIN));
                        $id = self::isNumber($id);
                        self::showByID($id);
                        return;
                    } catch (Exception $err) {
                        self::errorLog($err->getMessage());
                        echo "\n" . $err->getMessage() . "\n\n";
                    }
                }
            case $choice === 3:
                while (true) {
                    try {
                        echo "\nNow you can Add your task : ";
                        $description = trim(fgets(STDIN));
                        if (empty($description)) throw new Exception("Plz insert a task to Add");
                        $task = self::storeTask($description);
                        self::showByID($task['id']);
                        return;
                    } catch (Exception $err) {
                        self::errorLog($err->getMessage());
                        echo "\n" . $err->getMessage() . "\n\n";
                    }
                }
            case $choice === 4:
                while (true) {
                    try {
                        self::Hint();
                        $id = trim(fgets(STDIN));
                        $id = self::isNumber($id);
                        self::update($id);
                        return;
                    } catch (Exception $err) {
                        self::errorLog($err->getMessage());
                        echo "\n" . $err->getMessage() . "\n\n";
                    }
                }
            case $choice === 5:
                while (true) {
                    try {
                        self::Hint();
                        $id = trim(fgets(STDIN));
                        $id = self::isNumber($id);
                        self::delete($id);
                        return;
                    } catch (Exception $err) {
                        self::errorLog($err->getMessage());
                        echo "\n" . $err->getMessage() . "\n\n";
                    }
                }
            case $choice === 6:
                while (true) {
                    echo "\nAre you sure Want to delete All your Task yes/no : ";
                    $answer = trim(fgets(STDIN));
                    if (strtolower($answer) === "yes") {
                        self::deleteAll();
                        return;
                    }

                    if (strtolower($answer) === "no") {
                        return;
                    }
                    echo "\nAnswer By yes/no\n\n";
                }
        }
    }
    public static function main(): void
    {
        $range = 7;
        while (true) {
            echo "*************************************\n";
            echo "*****Welcome*To*Task*Tracker*CLI*****\n";
            echo "*************************************\n";
            echo "1->Read All your tasks\n"; // we can select all tasks in-progress and after apply filte / mark task 
            echo "2->Find the task by ID\n";
            echo "3->Add new task\n";
            echo "4->Update task by id\n"; //first find task and then show it for check
            echo "5->Delete task by id\n"; //first find task and then show it for check 
            echo "6->Delete all tasks\n";
            echo "7->Exit\n";

            $choice = self::askTheUser($range);

            if ($choice === $range) {
                break;
            }

            self::handleChoice($choice);
        }
    }
}

Menu::main();

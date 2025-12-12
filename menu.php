<?php
if (!file_exists("./database.json")) {
    file_put_contents("database.json", json_encode([]));
}

require_once "./App/handler.php";
require_once "./App/Controller/TaskController.php";

use App\Handler;
use App\Controller\TaskController;

class Menu extends TaskController
{
    use Handler;

    private static function askTheUser(int $range): int
    {
        while (true) {
            echo "\nplz enter your choice 1~>$range : ";
            $choice = trim(fgets(STDIN));
            $choice = self::handleInput($choice, $range);
            if ($choice) {
                return $choice;
            }
        };
    }

    private static function filterTask()
    {
        $range = 4;

        echo "\nPlz choose a number to apply the filter\n";
        echo "1->All the list\n";
        echo "2->todo\n";
        echo "3->in-progress\n";
        echo "4->done\n";

        $mode = self::askTheUser($range);

        switch ($mode) {
            case $mode === 1:
                self::index();
                break;
            case $mode === 2:
                self::showByStatus("todo");
                break;
            case $mode === 3:
                self::showByStatus("in-progress");
                break;
            case $mode === 4:
                self::showByStatus("done");
                break;
        }
    }
    private static function handleChoice(int $choice)
    {
        switch ($choice) {
            case $choice === 1:
                self::filterTask();
                break;
            case $choice === 2:
                while (true) {
                    try {
                        echo "Plz enter the ID of task : ";
                        $id = trim(fgets(STDIN));
                        $id = self::isNumber($id);
                        self::showByID($id);
                        break;
                    } catch (Exception $err) {
                        echo "\n" . $err->getMessage() . "\n\n";
                    }
                }
                break;    
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

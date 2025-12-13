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

    private static function Hint()
    {
        echo "\nHint : use Read all option in menu to see the right Task\n";
        echo "--------------------------------------------------------";
        echo "\nPlz enter the ID of the task : ";
    }
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
                return;
            case $mode === 2:
                self::showByStatus("todo");
                return;
            case $mode === 3:
                self::showByStatus("in-progress");
                return;
            case $mode === 4:
                self::showByStatus("done");
                return;
        }
    }

    private static function update(int $id)
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

    private static function delete(int $id)
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

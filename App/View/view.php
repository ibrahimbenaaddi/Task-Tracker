<?php

namespace App\View;

use App\Handler;

trait View
{

    use Handler;

    private const Thead = " ___________________________________________________________________________________________\n|  id  |       descritpion       |    status    |       createdAt     |       updatedAt     |\n|------|-------------------------|--------------|---------------------|---------------------|\n";

    private const Tfooter = "|______|_________________________|______________|_____________________|_____________________|\n\n";

    // we use customeString function to make description same size for view

    private static function customeString(string $string, int $length): string
    {
        return $length <= 20 ? $string : substr($string, 0, - ($length - 20)) . "...";
    }

    // Show Tasks
    public static function showTasks(array $tasks): void
    {
        echo self::Thead;
        foreach ($tasks as $task) {
            printf(
                "| %-4s | %-23s | %-12s | %-18s | %-18s |\n",
                $task['id'],
                self::customeString($task['description'], strlen($task['description'])),
                $task['status'],
                $task['createdAt'],
                $task['updatedAt']
            );
        }
        echo self::Tfooter;
    }

    //find task by id
    public static function findTasks(array $task): void
    {
        echo "\nID : {$task['id']},\nDescription : {$task['description']},\nStatus : {$task['status']},\nCreatedAt : {$task['createdAt']},\nUpdatedAt : {$task['updatedAt']}\n\n";
    }
    
    public static function Hint()
    {
        echo "\nHint : use Read all option in menu to see the right Task\n";
        echo "--------------------------------------------------------";
        echo "\nPlz enter the ID of the task : ";
    }

    public static function askTheUser(int $range): int
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

    public static function filterTask()
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
}

<?php
namespace App\View;


trait View
{
    private const Thead = " ___________________________________________________________________________________________\n|  id  |       descritpion       |    status    |       createdAt     |       updatedAt     |\n|------|-------------------------|--------------|---------------------|---------------------|\n";

    private const Tfooter = "|______|_________________________|______________|_____________________|_____________________|\n\n";

    // we use customeString function to make description same size for view

    private static function customeString(string $string, int $length): string
    {
        return $length <= 20 ? $string . "..." : substr($string, 0, - ($length - 20)) . "...";
    }

    // Show Tasks
    public function showTasks(array $tasks): void
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
    public function finTasks(array $task): void
    {
        echo "\nID : {$task['id']},\nDescription : {$task['description']},\nStatus : {$task['status']},\nCreatedAt : {$task['createdAt']},\nUpdatedAt : {$task['updatedAt']}\n\n";
    }
}

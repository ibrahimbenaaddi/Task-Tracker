<?php
/* 
    1-list all task
    2 -filter by todo / in-progress / done 
*/
require_once "task.php";

use App\task;

$data = json_decode(file_get_contents("../database.json"), true);

function costumeString(string $string, int $length): string
{
    return $length < 20 ? $string . "..." : substr($string, 0, - ($length - 20)) . "...";
}


function listTasks(array $tasks, ?string $filterMode = null): void
{

    echo " ___________________________________________________________________________________________\n";
    echo "|  id  |       descritpion       |    status    |       createdAt     |       updatedAt     |\n";
    echo "|------|-------------------------|--------------|---------------------|---------------------|\n";
    // check if the param $filteMode ara Passed
    if (is_null($filterMode)) {
        foreach ($tasks as $task) {
            printf(
                "| %-4s | %-23s | %-12s | %-18s | %-18s |\n",
                $task['id'],
                costumeString($task['description'], strlen($task['description'])),
                $task['status'],
                $task['createdAt'],
                $task['updatedAt']
            );
        }
    } else {
        foreach ($tasks as $task) {
            if ($task['status'] == $filterMode) {
                printf(
                    "| %-4s | %-23s | %-12s | %-18s | %-18s |\n",
                    $task['id'],
                    costumeString($task['description'], strlen($task['description'])),
                    $task['status'],
                    $task['createdAt'],
                    $task['updatedAt']
                );
            }
        }
    }
    echo "|______|_________________________|______________|_____________________|_____________________|\n";
}
function filterBytodo(array $tasks): void
{
    echo "The tasks filtred by todo\n";
    listTasks($tasks,"todo");
}
filterBytodo($data);

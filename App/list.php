<?php
/* 
    1-list all task
    2 -filter by todo / in-progress / done
*/
// we use customeString function to make description same size for view
function customeString(string $string, int $length): string
{
    return $length <= 20 ? $string . "..." : substr($string, 0, - ($length - 20)) . "...";
}

function listTasks(array $tasks, ?string $filter = null): void
{

    echo " ___________________________________________________________________________________________\n";
    echo "|  id  |       descritpion       |    status    |       createdAt     |       updatedAt     |\n";
    echo "|------|-------------------------|--------------|---------------------|---------------------|\n";
    // check if the param $filteMode ara Passed
    if (is_null($filter)) {
        foreach ($tasks as $task) {
            printf(
                "| %-4s | %-23s | %-12s | %-18s | %-18s |\n",
                $task['id'],
                customeString($task['description'], strlen($task['description'])),
                $task['status'],
                $task['createdAt'],
                $task['updatedAt']
            );
        }
    } else {
        foreach ($tasks as $task) {
            if ($task['status'] == $filter) {
                printf(
                    "| %-4s | %-23s | %-12s | %-18s | %-18s |\n",
                    $task['id'],
                    customeString($task['description'], strlen($task['description'])),
                    $task['status'],
                    $task['createdAt'],
                    $task['updatedAt']
                );
            }
        }
    }
    echo "|______|_________________________|______________|_____________________|_____________________|\n\n";
}

function mainlist(?string $filterMode = null): void
{
    try {
        $path = __DIR__  . "/../database.json";
        $data = json_decode(file_get_contents($path), true);
        if (empty($data)) {
            throw new Exception("No data Found");
        }
        listTasks($data,$filterMode);
    } catch (Exception $err) {
        echo $err->getMessage();
    }
}

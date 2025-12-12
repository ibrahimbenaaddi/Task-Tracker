<?php
/* 
    1-list all task
    2 -filter by todo / in-progress / done
*/

require_once "./App/search.php";

// we use customeString function to make description same size for view
function customeString(string $string, int $length): string
{
    return $length <= 20 ? $string . "..." : substr($string, 0, - ($length - 20)) . "...";
}

function listTasks(array $tasks, ?string $filter = null, ?int $id = null): void
{
    $thead = " ___________________________________________________________________________________________\n|  id  |       descritpion       |    status    |       createdAt     |       updatedAt     |\n|------|-------------------------|--------------|---------------------|---------------------|\n";
    $tfooter = "|______|_________________________|______________|_____________________|_____________________|\n\n" ;
    // check if the param $filteMode ara Passed
    if (is_null($filter) && is_null($id)) {
        echo $thead;
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
        echo $tfooter;
        return;
    }
    if($filter){
        echo $thead;
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
        echo $tfooter;
        return;
    }
    if($id){
        if(!search($tasks,$id)){
            echo "\nYour task that have ID : $id ,is Not Found\n\n";
            return;
        }
        foreach ($tasks as $task) {
            if ($task['id'] == $id) {
                echo"\nID : {$task['id']},\nDescription : {$task['description']},\nStatus : {$task['status']},\nCreatedAt : {$task['createdAt']},\nUpdatedAt : {$task['updatedAt']}\n\n";
                break;       
            }
        }
    }
}

function mainlist(?string $filterMode = null ,?int $id = null): void
{
    try {
        $path = __DIR__  . "/../database.json";
        $data = json_decode(file_get_contents($path), true);
        if (empty($data)) {
            throw new Exception("No data Found");
        }
        listTasks($data,$filterMode,$id);
    } catch (Exception $err) {
        echo "\n\n" . $err->getMessage() . "\n\n";
    }
}

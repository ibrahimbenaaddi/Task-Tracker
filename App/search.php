<?php
//this Function search by ID must be used for listing , updating and Deleting

function search(array $tasks, int $value): bool
{
    $found = false;
    foreach ($tasks as $task) {
        if ($task['id'] == $value) {
            $found = true;
        }
    }
    return $found;
}

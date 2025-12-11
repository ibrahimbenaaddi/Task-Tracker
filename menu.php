<?php
require_once "./App/list.php";

// build functions for handleinput and user choices
// i use the range for more dynamic for update in future
function handleInput(string $value, int $range)
{
    try {
        if (empty($value)) {
            throw new Exception('Plz choise from the menu 1~>6');
        }
        if (!is_numeric($value)) {
            throw new Exception('Plz enter an integer');
        }
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            throw new Exception('Plz enter an integer');
        }
        $value = (int) $value;
        if ($value < 1 || $value > $range) {
            throw new Exception("Plz choise from the range 1~>$range");
        }
        return $value;
    } catch (Exception $err) {
        echo $err->getMessage() . "\n";
        return false;
    }
}

function askTheUser(int $range): int
{
    while (true) {
        echo "\nplz enter your choise 1~>$range : ";
        $choice = trim(fgets(STDIN));
        $choice = handleInput($choice, $range);
        if ($choice) {
            return $choice;
        }
    };
}

function filterTask()
{
    $range = 4;
    echo "\nPlz choose a number to apply the filter\n";
    echo "1->All the list\n";
    echo "2->todo\n";
    echo "3->in-progress\n";
    echo "4->done\n";

    $mode = askTheUser($range);

    if ($mode === 1) {
        return null;
    }
    if ($mode === 2) {
        return "todo";
    }
    if ($mode === 3) {
        return "in-progress";
    }
    if ($mode === 4) {
        return "done";
    }
}

function handleChoice(int $choice)
{
    if ($choice === 1) {
        mainlist(filterTask());
        return;
    }

}

function main(): void
{
    $range = 7;
    while (true) {
        if (!file_exists("./database.json")) {
            file_put_contents("database.json", json_encode([]));
        }

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

        $choice = askTheUser($range);

        if ($choice === 6) {
            break;
        }
        handleChoice($choice);
    }
}

main();

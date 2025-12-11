<?php
require_once "./App/list.php";

// build functions for handleinput of user

function handleInput(string $value)
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
        settype($value, "int");
        if ($value < 1 || $value > 6) {
            throw new Exception('Plz choise from the range 1~>6');
        }
        return $value;
    } catch (Exception $err) {
        echo $err->getMessage() . "\n";
        return false;
    }
}

function handleChoice(int $choice)
{
    if ($choice === 1) {
        mainlist();
        return;
    }

}

function main(): void
{
    while (true) {
        if (!file_exists("./database.json")) {
            file_put_contents("database.json", json_encode([]));
        }

        echo "*************************************\n";
        echo "*****Welcome*To*Task*Tracker*CLI*****\n";
        echo "*************************************\n";
        echo "1->Read All your tasks\n"; // we can select all tasks in-progress and after apply filte / mark task 
        echo "2->Add new task\n";
        echo "3->Update task by id\n"; //first find task and then show it for check
        echo "4->Delete task by id\n"; //first find task and then show it for check 
        echo "5->Delete all tasks\n";
        echo "6->Exit\n";

        while (true) {
            echo "plz enter your choise 1~>6 : ";
            $choice = trim(fgets(STDIN));
            $choice = handleInput($choice);
            if ($choice) {
                break;
            }
        };

        if ($choice === 6) {
            break;
        }
        handleChoice($choice);
    }
}

main();

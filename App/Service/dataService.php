<?php

namespace App\Service;

use Exception;

trait Data
{

    private const PathDB  = __DIR__  . "/database.json";
    public const PathLog = __DIR__  . "/../Log/log.txt";

    public static function errorLog(string $message)
    {
        file_put_contents(self::PathLog, "the Error is : $message\n", FILE_APPEND);
    }

    public static function getData()
    {
        try {

            $data = json_decode(file_get_contents(self::PathDB), true);
            if (empty($data)) {
                throw new Exception("No data Found");
            }
            return $data;
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n\n";
        }
    }
}
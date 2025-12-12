<?php

namespace App;

use Exception;

trait Handler
{
    public static function isNumber(mixed $value)
    {
            if (!filter_var($value, FILTER_VALIDATE_INT)) {
                throw new Exception('Plz enter an integer');
            }
            $value = (int) $value;
            return $value;
    }

    public static function handleInput(string $value, int $range)
    {
        try {
            if (empty($value)) {
                throw new Exception("Plz choice from the menu 1~>$range");
            }
            
            $number = self::isNumber($value);

            if ($number < 1 || $number > $range) {
                throw new Exception("Plz choice from the range 1~>$range");
            }
            return $number;
        } catch (Exception $err) {
            self::errorLog($err->getMessage());
            echo "\n" . $err->getMessage() . "\n";
        }
    }
}

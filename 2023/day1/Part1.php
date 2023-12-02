<?php

$input = file(__DIR__ . '/input.txt');

$sum = 0;
foreach ($input as $line) {
    $firstDigit = $lastDigit = null;
    foreach (str_split($line) as $char) {
        if (is_numeric($char)) {
            if (!$firstDigit) {
                $firstDigit = $char;
            }
            $lastDigit = $char;
        }
    }
    $sum += intval($firstDigit . $lastDigit);
}
echo $sum . PHP_EOL;

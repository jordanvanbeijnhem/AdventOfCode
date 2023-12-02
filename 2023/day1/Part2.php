<?php

$input = file(__DIR__ . '/input.txt');

$sum = 0;
foreach ($input as $line) {
    $firstDigit = $lastDigit = null;
    foreach (str_split($line) as $index => $char) {
        if (is_numeric($char)) {
            if (!$firstDigit) {
                $firstDigit = $char;
            }
            $lastDigit = $char;
        } else {
            $textualDigit = findTextualDigit($line, $index);
            if ($textualDigit) {
                if (!$firstDigit) {
                    $firstDigit = $textualDigit;
                }
                $lastDigit = $textualDigit;
            }
        }
    }
    $sum += intval($firstDigit . $lastDigit);
}
echo $sum . PHP_EOL;

function findTextualDigit($line, $index): ?string
{
    $substr = substr($line, $index, 5);
    if (str_starts_with($substr, 'one')) {
        return '1';
    } else if (str_starts_with($substr, 'two')) {
        return '2';
    } else if (str_starts_with($substr, 'three')) {
        return '3';
    } else if (str_starts_with($substr, 'four')) {
        return '4';
    } else if (str_starts_with($substr, 'five')) {
        return '5';
    } else if (str_starts_with($substr, 'six')) {
        return '6';
    } else if (str_starts_with($substr, 'seven')) {
        return '7';
    } else if (str_starts_with($substr, 'eight')) {
        return '8';
    } else if (str_starts_with($substr, 'nine')) {
        return '9';
    }

    return null;
}

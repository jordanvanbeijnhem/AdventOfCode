<?php

$lines = file(__DIR__ . '/input.txt');

$totalPoints = 0;
foreach ($lines as $line) {
    $card = explode(' | ', explode(': ', $line)[1]);
    $winningNumbers = array_filter(explode(' ', $card[0]));
    $ourNumbers = array_filter(explode(' ', $card[1]));
    $matches = 0;
    foreach ($winningNumbers as $winningNumber) {
        if (in_array($winningNumber, $ourNumbers)) $matches++;
    }
    if ($matches > 0) $totalPoints += pow(2, $matches - 1);
}

echo $totalPoints . PHP_EOL;

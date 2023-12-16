<?php

$lines = file(__DIR__ . "/input.txt");

$nextValSum = 0;
foreach ($lines as $line) {
    $history = [
        array_map(function ($item) {
            return intval($item);
        }, (explode(' ', rtrim($line))))
    ];

    $depth = 0;
    $allZeros = false;
    while (!$allZeros) {
        $prev = [];
        $allZeros = true;
        for ($i = 0; $i < count($history[$depth]) - 1; $i++) {
            $diff = $history[$depth][$i + 1] - $history[$depth][$i];
            if ($diff !== 0) $allZeros = false;
            $prev[] = $diff;
        }
        $history[] = $prev;
        $depth++;
    }

    $nextVal = 0;
    for ($i = count($history) - 2; $i >= 0; $i--) {
        $nextVal = $nextVal + $history[$i][count($history[$i]) - 1];
    }
    $nextValSum += $nextVal;
}

echo $nextValSum . PHP_EOL;

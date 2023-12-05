<?php

$lines = file(__DIR__ . '/input.txt');

$maps = [];

$seeds = explode(' ', explode('seeds: ', rtrim($lines[0]))[1]);

$currentMap = '';
foreach (array_splice($lines, 2) as $line) {
    $line = rtrim($line);
    if (empty($line)) {
        continue;
    }

    if (strpos($line, "map") !== false) {
        $currentMap = explode(' ', $line)[0];
        $maps[$currentMap] = [];
        continue;
    }

    $values = explode(' ', $line);
    $maps[$currentMap][] = [
        "sourceStart" => intval($values[1]),
        "destinationStart" => intval($values[0]),
        "length" => intval($values[2]),
    ];
}

$lowest = null;
foreach ($seeds as $seed) {
    $currentValue = intval($seed);
    foreach ($maps as $map) {
        foreach ($map as $mapItem) {
            if ($currentValue >= $mapItem['sourceStart'] && $currentValue < $mapItem['sourceStart'] + $mapItem['length']) {
                $currentValue = $mapItem['destinationStart'] + ($currentValue - $mapItem['sourceStart']);
                break;
            }
        }
    }
    if ($lowest === null || $currentValue < $lowest) {
        $lowest = $currentValue;
    }
}

echo $lowest . PHP_EOL;

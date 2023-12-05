<?php

$lines = file(__DIR__ . '/input.txt');

$maps = [];

$seedNumbers = explode(' ', explode('seeds: ', rtrim($lines[0]))[1]);
$seeds = [];
foreach ($seedNumbers as $index => $seed) {
    if ($index % 2 === 0) {
        $seeds[] = [
            'start' => intval($seed),
            'length' => intval($seedNumbers[$index + 1]),
        ];
    }
}

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

$maps = array_reverse($maps);

$currentLocation = 0;
while ($currentLocation < 100000000000) {
    $currentValue = $currentLocation;
    foreach ($maps as $map) {
        foreach ($map as $mapItem) {
            if ($currentValue >= $mapItem['destinationStart'] && $currentValue < $mapItem['destinationStart'] + $mapItem['length']) {
                $currentValue = $mapItem['sourceStart'] + ($currentValue - $mapItem['destinationStart']);
                break;
            }
        }
    }

    $foundSeed = false;
    foreach ($seeds as $seed) {
        if ($currentValue >= $seed['start'] && $currentValue < $seed['start'] + $seed['length']) {
            $foundSeed = true;
            break;
        }
    }

    if ($foundSeed) {
        break;
    }
    $currentLocation++;
}

echo $currentLocation . PHP_EOL;

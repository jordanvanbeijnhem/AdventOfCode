<?php

$lines = file(__DIR__ . '/input.txt');

$times = array_values(array_filter(explode(' ', explode('Time:', $lines[0])[1])));
$distances = array_values(array_filter(explode(' ', explode('Distance:', $lines[1])[1])));

$winMultiplier = 1;
for ($i = 0; $i < count($times); $i++) {
    $time = intval($times[$i]);
    $distance = intval($distances[$i]);

    $winCounter = 0;
    for ($speedBuild = 1; $speedBuild < $time; $speedBuild++) {
        $traveledDistance = ($time - $speedBuild) * $speedBuild;
        if ($traveledDistance > $distance) {
            $winCounter++;
        }
    }
    $winMultiplier *= $winCounter;
}

echo $winMultiplier . PHP_EOL;

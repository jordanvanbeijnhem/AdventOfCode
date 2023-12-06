<?php

$lines = file(__DIR__ . '/exampleInput.txt');

$times = array_filter(explode(' ', explode('Time:', $lines[0])[1]));
$totalTime = intval(join('', $times));
$distances = array_filter(explode(' ', explode('Distance:', $lines[1])[1]));
$totalDistance = intval(join('', $distances));

$winCounter = 0;
for ($speedBuild = 1; $speedBuild < $totalTime; $speedBuild++) {
    $traveledDistance = ($totalTime - $speedBuild) * $speedBuild;
    if ($traveledDistance > $totalDistance) {
        $winCounter++;
    }
}

echo $winCounter . PHP_EOL;

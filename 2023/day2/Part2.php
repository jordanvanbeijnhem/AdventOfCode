<?php

$input = file(__DIR__ . '/input.txt');

$gamePowerSum = 0;
foreach ($input as $index => $game) {
    $minColorsNeeded = [
        'red' => 0,
        'green' => 0,
        'blue' => 0,
    ];
    $shownSets = explode(': ', $game)[1];
    foreach (explode('; ', $shownSets) as $shownSet) {
        foreach (explode(', ', trim($shownSet)) as $shownObject) {
            $shownObject = explode(' ', $shownObject);
            $amount = intval($shownObject[0]);
            $objectColor = $shownObject[1];
            if ($amount > $minColorsNeeded[$objectColor]) {
                $minColorsNeeded[$objectColor] = $amount;
            }
        }
    }

    $gamePowerSum += $minColorsNeeded['red'] * $minColorsNeeded['green'] * $minColorsNeeded['blue'];
}

echo $gamePowerSum . PHP_EOL;

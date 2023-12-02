<?php

$input = file(__DIR__ . '/input.txt');

$maxPerColor = [
    'red' => 12,
    'green' => 13,
    'blue' => 14,
];

$validGameSum = 0;
foreach ($input as $index => $game) {
    $gameValid = true;
    $shownSets = explode(': ', $game)[1];
    foreach (explode('; ', $shownSets) as $shownSet) {
        foreach (explode(', ', trim($shownSet)) as $shownObject) {
            $shownObject = explode(' ', $shownObject);
            $amount = intval($shownObject[0]);
            $objectColor = $shownObject[1];
            if ($amount > $maxPerColor[$objectColor]) {
                $gameValid = false;
                break;
            }
        }
        if (!$gameValid) {
            break;
        }
    }
    if ($gameValid) {
        $validGameSum += $index + 1;
    }
}

echo $validGameSum . PHP_EOL;

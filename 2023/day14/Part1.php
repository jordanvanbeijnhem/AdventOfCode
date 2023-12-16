<?php

$visualMode = false;
$lines = file(__DIR__ . "/input.txt");

$grid = [];
foreach ($lines as $line) {
    $grid[] = str_split(trim($line));
}

for ($x = 0; $x < count($grid[0]); $x++) {
    $lastSolidYPosition = -1;
    for ($y = 0; $y < count($grid); $y++) {
        $current = $grid[$y][$x];
        if ($current === "#") {
            $lastSolidYPosition = $y;
        } elseif ($current === "O") {
            $newRockYPosition = $lastSolidYPosition + 1;
            $tmp = $grid[$newRockYPosition][$x];
            $grid[$newRockYPosition][$x] = $grid[$y][$x];
            $grid[$y][$x] = $tmp;
            $lastSolidYPosition = $newRockYPosition;
        }
    }
}

$totalLoad = 0;
for ($y = 0; $y < count($grid); $y++) {
    $valueCounts = array_count_values($grid[$y]);
    if (array_key_exists("O", $valueCounts)) $totalLoad += $valueCounts["O"] * (count($grid) - $y);
    if (!$visualMode) continue;
    for ($x = 0; $x < count($grid[0]); $x++) {
        echo $grid[$y][$x];
    }
    echo PHP_EOL;
}

echo $totalLoad . PHP_EOL;

<?php

$lines = file(__DIR__ . "/input.txt");

$currentX = 0;
$currentY = 0;

$shoelaceSum = 0;
$perimeterLength = 0;
foreach ($lines as $index => $line) {
    $exploded = explode(" ", $line);
    $direction = $exploded[0];
    $meters = intval($exploded[1]);
    $nextX = $currentX;
    $nextY = $currentY;
    if ($direction === "U") $nextY -= $meters;
    if ($direction === "D") $nextY += $meters;
    if ($direction === "L") $nextX -= $meters;
    if ($direction === "R") $nextX += $meters;
    $perimeterLength += $meters;
    $shoelaceSum += $currentX * $nextY - $currentY * $nextX;
    $currentX = $nextX;
    $currentY = $nextY;
}

$area = abs($shoelaceSum / 2);
echo $area + $perimeterLength / 2 + 1 . PHP_EOL;

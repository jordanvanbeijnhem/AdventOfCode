<?php

$lines = file(__DIR__ . "/input.txt");

$currentX = 0;
$currentY = 0;

$shoelaceSum = 0;
$perimeterLength = 0;
foreach ($lines as $index => $line) {
    $exploded = explode(" ", $line);
    $meters = hexdec(substr($exploded[2], 2, 5));
    $direction = $exploded[2][7];
    $nextX = $currentX;
    $nextY = $currentY;
    if ($direction === "3") $nextY -= $meters;
    if ($direction === "1") $nextY += $meters;
    if ($direction === "2") $nextX -= $meters;
    if ($direction === "0") $nextX += $meters;
    $perimeterLength += $meters;
    $shoelaceSum += $currentX * $nextY - $currentY * $nextX;
    $currentX = $nextX;
    $currentY = $nextY;
}

$area = abs($shoelaceSum / 2);
echo $area + $perimeterLength / 2 + 1 . PHP_EOL;

<?php

$lines = file(__DIR__ . "/input.txt");

$grid = [];
foreach ($lines as $line) {
    $grid[] = str_split(rtrim($line));
}

$energizedTiles = [];
emulateBeam(0, 0, 1, 0);

echo count($energizedTiles) . PHP_EOL;

function emulateBeam(int $x, int $y, int $xDirection, int $yDirection)
{
    if (isOutOfBounds($x, $y) || isAlreadyTraversed($x, $y, $xDirection, $yDirection)) return;
    traverse($x, $y, $xDirection, $yDirection);
    $newDirections = getNewDirections($x, $y, $xDirection, $yDirection);
    if ($newDirections === false) return;
    foreach ($newDirections as $newDirection) {
        emulateBeam($x + $newDirection[0], $y + $newDirection[1], $newDirection[0], $newDirection[1]);
    }
}

function isOutOfBounds(int $x, int $y)
{
    global $grid;
    return $x < 0 || $y < 0 || $x >= count($grid[0]) || $y >= count($grid);
}

function isAlreadyTraversed(int $x, int $y, int $xDirection, int $yDirection)
{
    global $energizedTiles;
    return isset($energizedTiles["$x-$y"]) && in_array("$xDirection:$yDirection", $energizedTiles["$x-$y"]);
}

function traverse(int $x, int $y, int $xDirection, int $yDirection)
{
    global $energizedTiles;
    if (!isset($energizedTiles["$x-$y"])) {
        $energizedTiles["$x-$y"] = [];
    }
    $energizedTiles["$x-$y"][] = "$xDirection:$yDirection";
}

function getNewDirections($x, $y, $currentXDirection, $currentYDirection)
{
    global $grid;
    $current = $grid[$y][$x];

    if ($current === '.' || ($current === '-' && $currentXDirection !== 0) || ($current === '|' && $currentYDirection !== 0)) {
        return [[$currentXDirection, $currentYDirection]];
    } elseif ($current === '/') {
        if ($currentXDirection !== 0) {
            return [[0, -1 * $currentXDirection]];
        } else {
            return [[-1 * $currentYDirection, 0]];
        }
    } elseif ($current === '\\') {
        if ($currentXDirection !== 0) {
            return [[0, $currentXDirection]];
        } else {
            return [[$currentYDirection, 0]];
        }
    } elseif ($current === '-') {
        return [[-1, 0], [1, 0]];
    } elseif ($current === '|') {
        return [[0, -1], [0, 1]];
    }
    return false;
}
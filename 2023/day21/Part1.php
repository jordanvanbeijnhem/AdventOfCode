<?php

$lines = file(__DIR__ . "/input.txt");

$startPos = [0, 0];
$reachedTiles = [];
$traversedTiles = [];
$grid = [];
foreach ($lines as $index => $line) {
    $line = trim($line);
    $grid[] = str_split($line);
    $sPos = strpos($line, "S");
    if ($sPos !== false) {
        $startPos = [$sPos, $index];
    }
}

stepOnto($startPos[0], $startPos[1], 0);

echo count($reachedTiles) . PHP_EOL;

function stepOnto($x, $y, $steps)
{
    global $reachedTiles;
    global $traversedTiles;
    $isInvalidTile = isInvalidTile($x, $y);
    $isTraversed = isset($traversedTiles["$x-$y"]) && in_array($steps, $traversedTiles["$x-$y"]);
    $targetStepsReached = $steps === 64;
    if ($targetStepsReached && !$isInvalidTile) {
        $reachedTiles["$x-$y"] = true;
    }
    if (!$isTraversed) $traversedTiles["$x-$y"][] = $steps;
    if ($targetStepsReached || $isInvalidTile || $isTraversed) return;
    stepOnto($x, $y + 1, $steps + 1);
    stepOnto($x + 1, $y, $steps + 1);
    stepOnto($x, $y - 1, $steps + 1);
    stepOnto($x - 1, $y, $steps + 1);
}

function isInvalidTile($x, $y)
{
    global $grid;
    if ($x < 0 || $y < 0 || $x >= count($grid[0]) || $y >= count($grid) || $grid[$y][$x] === "#") {
        return true;
    }
    return false;
}

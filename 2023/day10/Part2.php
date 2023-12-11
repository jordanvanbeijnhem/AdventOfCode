<?php

$lines = file(__DIR__ . '/input.txt');

$startPos = [0, 0];
foreach ($lines as $index => $line) {
    $pos = strpos($line, 'S');
    if ($pos !== false) {
        $startPos = [$pos, $index];
        break;
    }
}

$directionsToCheck = [[1, 0], [0, 1], [-1, 0], [0, -1]];
$loopPositions = [];
foreach ($directionsToCheck as $direction) {
    $xDirection = $direction[0];
    $yDirection = $direction[1];
    $currentPos = $startPos;
    $loopPositions = [$startPos];
    $loopFound = false;
    while (true) {
        $currentPos = [$currentPos[0] + $xDirection, $currentPos[1] + $yDirection];
        if ($currentPos === $startPos) {
            $loopFound = true;
            break;
        }
        $loopPositions[] = $currentPos;

        $x = $currentPos[0];
        $y = $currentPos[1];
        if (isOutOfBounds($x, $y) || isGround($x, $y)) break;

        $newDirections = getNewDirections($x, $y, $xDirection, $yDirection);
        if ($newDirections === false) break;
        $xDirection = $newDirections[0];
        $yDirection = $newDirections[1];
    }
    if ($loopFound) break;
}

$sum = 0;
foreach ($loopPositions as $index => $pos) {
    $nextPos = $loopPositions[($index + 1) % count($loopPositions)];
    $sum += $pos[0] * $nextPos[1] - $pos[1] * $nextPos[0];
}

$area = abs($sum / 2);
echo $area - count($loopPositions) / 2 + 1 . PHP_EOL;

function isOutOfBounds($x, $y)
{
    global $lines;
    return $x < 0 || $y < 0 || $x >= strlen($lines[0]) || $y >= count($lines);
}

function isGround($x, $y)
{
    global $lines;
    return $lines[$y][$x] === '.';
}

function getNewDirections($x, $y, $currentXDirection, $currentYDirection)
{
    global $lines;
    $current = $lines[$y][$x];
    if ($current === '-' && $currentXDirection !== 0 && $currentYDirection === 0) {
        return [$currentXDirection, $currentYDirection];
    } elseif ($current === '|' && $currentYDirection !== 0 && $currentXDirection === 0) {
        return [$currentXDirection, $currentYDirection];
    } elseif ($current === 'L') {
        if ($currentXDirection === 0 && $currentYDirection === 1) {
            return [1, 0];
        } elseif ($currentXDirection === -1 && $currentYDirection === 0) {
            return [0, -1];
        }
    } elseif ($current === 'J') {
        if ($currentXDirection === 0 && $currentYDirection === 1) {
            return [-1, 0];
        } elseif ($currentXDirection === 1 && $currentYDirection === 0) {
            return [0, -1];
        }
    } elseif ($current === '7') {
        if ($currentXDirection === 0 && $currentYDirection === -1) {
            return [-1, 0];
        } elseif ($currentXDirection === 1 && $currentYDirection === 0) {
            return [0, 1];
        }
    } elseif ($current === 'F') {
        if ($currentXDirection === 0 && $currentYDirection === -1) {
            return [1, 0];
        } elseif ($currentXDirection === -1 && $currentYDirection === 0) {
            return [0, 1];
        }
    }
    return false;
}

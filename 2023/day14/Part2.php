<?php

$lines = file(__DIR__ . "/input.txt");

$grid = [];
foreach ($lines as $line) {
    $grid[] = str_split(trim($line));
}

$cycles = 1000;
for ($i = 0; $i < $cycles; $i++) {
    cycle();
    echo $i + 1 . " " . calculateTotalLoad() . PHP_EOL;
}

// total load after cycles will start repeating after some cycles. Find a start of the cycle, length until it repeats and extrapolate the total load after 1000000000 cycles
// cycleStart and cycleLength will be different for different inputs, and have to be found manually, for now
$cycleStart = 961;
$cycleLength = 39;
echo (1000000000 - ($cycleStart - 1)) % $cycleLength . PHP_EOL;

function cycle()
{
    tiltNorth();
    tiltWest();
    tiltSouth();
    tiltEast();
}

function tiltNorth()
{
    global $grid;
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
}

function tiltWest()
{
    global $grid;
    for ($y = 0; $y < count($grid); $y++) {
        $lastSolidXPosition = -1;
        for ($x = 0; $x < count($grid[$y]); $x++) {
            $current = $grid[$y][$x];
            if ($current === "#") {
                $lastSolidXPosition = $x;
            } elseif ($current === "O") {
                $newRockXPosition = $lastSolidXPosition + 1;
                $tmp = $grid[$y][$newRockXPosition];
                $grid[$y][$newRockXPosition] = $grid[$y][$x];
                $grid[$y][$x] = $tmp;
                $lastSolidXPosition = $newRockXPosition;
            }
        }
    }

}

function tiltSouth()
{
    global $grid;
    for ($x = 0; $x < count($grid[0]); $x++) {
        $lastSolidYPosition = count($grid);
        for ($y = count($grid) - 1; $y >= 0; $y--) {
            $current = $grid[$y][$x];
            if ($current === "#") {
                $lastSolidYPosition = $y;
            } elseif ($current === "O") {
                $newRockYPosition = $lastSolidYPosition - 1;
                $tmp = $grid[$newRockYPosition][$x];
                $grid[$newRockYPosition][$x] = $grid[$y][$x];
                $grid[$y][$x] = $tmp;
                $lastSolidYPosition = $newRockYPosition;
            }
        }
    }
}

function tiltEast()
{
    global $grid;
    for ($y = 0; $y < count($grid); $y++) {
        $lastSolidXPosition = count($grid[$y]);
        for ($x = count($grid[$y]) - 1; $x >= 0; $x--) {
            $current = $grid[$y][$x];
            if ($current === "#") {
                $lastSolidXPosition = $x;
            } elseif ($current === "O") {
                $newRockXPosition = $lastSolidXPosition - 1;
                $tmp = $grid[$y][$newRockXPosition];
                $grid[$y][$newRockXPosition] = $grid[$y][$x];
                $grid[$y][$x] = $tmp;
                $lastSolidXPosition = $newRockXPosition;
            }
        }
    }
}

function calculateTotalLoad(): int
{
    global $grid;
    $totalLoad = 0;
    for ($y = 0; $y < count($grid); $y++) {
        $valueCounts = array_count_values($grid[$y]);
        if (array_key_exists("O", $valueCounts)) $totalLoad += $valueCounts["O"] * (count($grid) - $y);
    }
    return $totalLoad;
}
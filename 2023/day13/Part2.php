<?php

$lines = file(__DIR__ . "/input.txt");

$grids = [];
$currentGrid = [];
foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) {
        $grids[] = $currentGrid;
        $currentGrid = [];
        continue;
    }
    $currentGrid[] = str_split($line);
}

$totalColumnCount = 0;
$totalRowCount = 0;

foreach ($grids as $grid) {
    for ($x = 0; $x < count($grid[0]); $x++) {
        if ($x + 1 >= count($grid[0])) break;
        $columnString = columnToString($grid, $x);
        $nextColumnString = columnToString($grid, $x + 1);
        if ($columnString === $nextColumnString || findDiffCount($columnString, $nextColumnString) === 1) {
            $perfectReflection = true;
            $columnCount = 1;
            $fixedColumns = findDiffCount($columnString, $nextColumnString);
            for ($i = $x + 2; $i < count($grid[0]); $i++) {
                $columnCount++;
                $leftPosition = $x - ($i - $x) + 1;
                if ($leftPosition < 0) break;
                $leftColumnString = columnToString($grid, $leftPosition);
                $rightColumnString = columnToString($grid, $i);
                if ($leftColumnString !== $rightColumnString) {
                    if ($fixedColumns < 1 && findDiffCount($leftColumnString, $rightColumnString) === 1) {
                        $fixedColumns++;
                        continue;
                    }
                    $perfectReflection = false;
                    break;
                }
            }
            if ($perfectReflection && $fixedColumns === 1) $totalColumnCount += $x + 1;
        }
    }

    for ($y = 0; $y < count($grid); $y++) {
        if ($y + 1 >= count($grid)) break;
        $rowString = rowToString($grid, $y);
        $nextRowString = rowToString($grid, $y + 1);
        if ($rowString === $nextRowString || findDiffCount($rowString, $nextRowString) === 1) {
            $perfectReflection = true;
            $rowCount = 1;
            $fixedRows = findDiffCount($rowString, $nextRowString);
            for ($i = $y + 2; $i < count($grid); $i++) {
                $rowCount++;
                $topPosition = $y - ($i - $y) + 1;
                if ($topPosition < 0) break;
                $topRowString = rowToString($grid, $topPosition);
                $bottomRowString = rowToString($grid, $i);
                if ($topRowString !== $bottomRowString) {
                    if ($fixedRows < 1 && findDiffCount($topRowString, $bottomRowString) === 1) {
                        $fixedRows++;
                        continue;
                    }
                    $perfectReflection = false;
                    break;
                }
            }
            if ($perfectReflection && $fixedRows === 1) $totalRowCount += $y + 1;
        }
    }
}

echo $totalColumnCount + ($totalRowCount * 100) . PHP_EOL;

function columnToString($grid, $x): string
{
    $columnString = "";
    for ($y = 0; $y < count($grid); $y++) {
        $columnString .= $grid[$y][$x];
    }
    return $columnString;
}

function rowToString($grid, $y): string
{
    $rowString = "";
    for ($x = 0; $x < count($grid[$y]); $x++) {
        $rowString .= $grid[$y][$x];
    }
    return $rowString;
}

function findDiffCount($string1, $string2): int
{
    $diffCount = 0;
    for ($i = 0; $i < strlen($string1); $i++) {
        if ($string1[$i] !== $string2[$i]) $diffCount++;
    }
    return $diffCount;
}

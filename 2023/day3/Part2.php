<?php

$lines = file(__DIR__ . '/input.txt');

$gearMap = [];

foreach ($lines as $rowIndex => $line) {
    $numberStartIndex = null;
    foreach (str_split($line) as $columnIndex => $char) {
        if (is_numeric($char)) {
            if ($numberStartIndex === null) $numberStartIndex = $columnIndex;
        } else {
            if ($numberStartIndex !== null) {
                $number = intval(substr($line, $numberStartIndex, $columnIndex - $numberStartIndex));
                linkNumberToAdjacentGears($number, $rowIndex, $numberStartIndex, $columnIndex- 1);
                $numberStartIndex = null;
            }
        }
    }
}

function linkNumberToAdjacentGears($number, $rowIndex, $columnStartIndex, $columnEndIndex): void
{
    global $lines;
    global $gearMap;
    for ($i = $rowIndex - 1; $i <= $rowIndex + 1; $i++) {
        for ($j = $columnStartIndex - 1; $j <= $columnEndIndex + 1; $j++) {
            if ($i < 0 || $i >= count($lines) || $j < 0 || $j >= strlen($lines[$i])) {
                continue;
            }
            if ($i === $rowIndex && $j >= $columnStartIndex && $j <= $columnEndIndex) {
                continue;
            }
            $value = str_split($lines[$i])[$j];
            if ($value === '*') {
                $gearMap[$i . '-' . $j][] = $number;
            }
        }
    }
}

$gearRatioSum = 0;
foreach ($gearMap as $key => $value) {
    if (count($value) == 2) {
        $gearRatioSum += $value[0] * $value[1];
    }
}
echo $gearRatioSum . PHP_EOL;
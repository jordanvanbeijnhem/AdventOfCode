<?php

$lines = file(__DIR__ . '/input.txt');

$enginePartNumbers = [];
foreach ($lines as $rowIndex => $line) {
    $currentNumber = "";
    $adjacentSymbolFound = false;
    foreach (str_split($line) as $columnIndex => $char) {
        if (is_numeric($char)) {
            $currentNumber .= $char;
            if (!$adjacentSymbolFound) {
                $adjacentSymbolFound = hasAdjacentSymbol($rowIndex, $columnIndex, $lines);
            }
        } else {
            if ($currentNumber !== "") {
                if ($adjacentSymbolFound) $enginePartNumbers[] = intval($currentNumber);
                $currentNumber = "";
                $adjacentSymbolFound = false;
            }
        }
    }
}

function hasAdjacentSymbol($rowIndex, $columnIndex, $lines): bool
{
    for ($i = $rowIndex - 1; $i <= $rowIndex + 1; $i++) {
        for ($j = $columnIndex - 1; $j <= $columnIndex + 1; $j++) {
            if ($i === $rowIndex && $j === $columnIndex) {
                continue;
            }
            if (isSymbol($lines, $i, $j, $i !== $rowIndex)) {
                return true;
            }
        }
    }
    return false;

}

function isSymbol($lines, $rowIndex, $columnIndex, $allowNumeric): bool
{
    if ($rowIndex < 0 || $rowIndex >= count($lines) || $columnIndex < 0 || $columnIndex >= strlen($lines[$rowIndex])) {
        return false;
    }
    $value = str_split($lines[$rowIndex])[$columnIndex];
    return $value !== PHP_EOL && $value !== '.' && ($allowNumeric || !is_numeric($value));
}

echo array_sum($enginePartNumbers) . PHP_EOL;

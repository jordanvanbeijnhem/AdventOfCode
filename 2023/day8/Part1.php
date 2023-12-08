<?php

$lines = file(__DIR__ . '/input.txt');
$instructions = rtrim($lines[0]);

$nodes = [];
foreach (array_splice($lines, 2) as $line) {
    $nodes[substr($line,0, 3)] = [
        'L' => substr($line, 7, 3),
        'R' => substr($line, 12, 3),
    ];
}

$currentNode = 'AAA';
$steps = 0;
while ($steps < 1000000000) {
    $instruction = $instructions[$steps % strlen($instructions)];
    $currentNode = $nodes[$currentNode][$instruction];
    $steps++;
    if ($currentNode === 'ZZZ') {
        break;
    }
}

echo $steps . PHP_EOL;

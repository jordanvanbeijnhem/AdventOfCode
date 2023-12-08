<?php

$lines = file(__DIR__ . '/input.txt');
$instructions = rtrim($lines[0]);

$nodes = [];
$startingNodes = [];
foreach (array_splice($lines, 2) as $line) {
    $nodeIdentifier = substr($line, 0, 3);
    $nodes[$nodeIdentifier] = [
        'L' => substr($line, 7, 3),
        'R' => substr($line, 12, 3),
    ];
    if ($nodeIdentifier[2] === 'A') $startingNodes[] = $nodeIdentifier;
}

$allSteps = [];
foreach ($startingNodes as $startingNode) {
    $steps = 0;
    $currentNode = $startingNode;
    while ($steps < 1000000000) {
        $instruction = $instructions[$steps % strlen($instructions)];
        $currentNode = $nodes[$currentNode][$instruction];
        $steps++;
        if ($currentNode[2] === 'Z') {
            break;
        }
    }
    $allSteps[] = $steps;
}

function gcd($a, $b)
{
    if ($b == 0) return $a;
    return gcd($b, $a % $b);
}

function findlcm($arr)
{
    $ans = $arr[0];
    for ($i = 1; $i < count($arr); $i++) {
        $ans = ($arr[$i] * $ans) / (gcd($arr[$i], $ans));
    }
    return $ans;
}

echo findlcm($allSteps) . PHP_EOL;

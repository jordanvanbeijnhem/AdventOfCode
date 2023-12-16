<?php

$lines = file(__DIR__ . "/input.txt");

$strings = explode(",", rtrim($lines[0]));
$hashes = [];

foreach ($strings as $string) {
    $currentValue = 0;
    foreach (str_split($string) as $char) {
        $currentValue += ord($char);
        $currentValue *= 17;
        $currentValue %= 256;
    }
    $hashes[] = $currentValue;
}

echo array_sum($hashes) . PHP_EOL;

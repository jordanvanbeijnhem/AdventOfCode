<?php

$lines = file(__DIR__ . "/input.txt");

$strings = explode(",", rtrim($lines[0]));
$boxes = [];

foreach ($strings as $string) {
    if (str_contains($string, "=")) {
        $exploded = explode("=", $string);
        $label = $exploded[0];
        $focalLength = intval($exploded[1]);
        $boxHash = getHash($label);
        if (!array_key_exists($boxHash, $boxes)) $boxes[$boxHash] = [];
        $lensIndex = findLensIndex($boxes[$boxHash], $label);
        if ($lensIndex !== null) {
            $boxes[$boxHash][$lensIndex]['focalLength'] = $focalLength;
        } else {
            $boxes[$boxHash][] = [
                'label' => $label,
                'focalLength' => $focalLength,
            ];
        }
    } else {
        $label = explode("-", $string)[0];
        $focalLength = 0;
        $boxHash = getHash($label);
        if (!array_key_exists($boxHash, $boxes)) continue;
        $lensIndex = findLensIndex($boxes[$boxHash], $label);
        if ($lensIndex === null) continue;
        unset($boxes[$boxHash][$lensIndex]);
        $boxes[$boxHash] = array_values($boxes[$boxHash]);
    }
}

$focussingPower = 0;
foreach ($boxes as $boxIndex => $box) {
    foreach ($box as $lensIndex => $lens) {
        $focussingPower += ($boxIndex + 1) * ($lensIndex + 1) * $lens['focalLength'];
    }
}

echo $focussingPower . PHP_EOL;

function getHash(string $string): int
{
    $currentValue = 0;
    foreach (str_split($string) as $char) {
        $currentValue += ord($char);
        $currentValue *= 17;
        $currentValue %= 256;
    }
    return $currentValue;
}

function findLensIndex(array $box, string $label): int|null
{
    foreach ($box as $index => $lens) {
        if ($lens['label'] === $label) return $index;
    }
    return null;
}

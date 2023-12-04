<?php

$lines = file(__DIR__ . '/input.txt');

$scoreCards = [];

foreach ($lines as $cardIndex => $line) {
    $card = explode(' | ', explode(': ', $line)[1]);
    $winningNumbers = array_filter(explode(' ', $card[0]));
    $ourNumbers = array_filter(explode(' ', $card[1]));
    $matches = 0;
    foreach ($winningNumbers as $winningNumber) {
        if (in_array($winningNumber, $ourNumbers)) $matches++;
    }
    $scoreCards[] = [
        'matches' => $matches,
        'originalCardIndex' => $cardIndex,
    ];
}

ini_set('memory_limit', '16G');
$currentIndex = 0;
while ($currentIndex < count($scoreCards)) {
    $currentCard = $scoreCards[$currentIndex];
    for ($i = 0; $i < $currentCard['matches']; $i++) {
        $scoreCardToCopy = $scoreCards[$currentCard['originalCardIndex'] + $i + 1];
        $scoreCards[] = [
            'matches' => $scoreCardToCopy['matches'],
            'originalCardIndex' => $scoreCardToCopy['originalCardIndex'],
        ];
    }
    $currentIndex++;
}

echo count($scoreCards) . PHP_EOL;

<?php

$lines = file(__DIR__ . '/input.txt');

$cardStrengths = [
    '2' => 1,
    '3' => 2,
    '4' => 3,
    '5' => 4,
    '6' => 5,
    '7' => 6,
    '8' => 7,
    '9' => 8,
    'T' => 9,
    'J' => 0,
    'Q' => 11,
    'K' => 12,
    'A' => 13,
];
$typeStrengths = [
    '' => 0,
    'onePair' => 1,
    'twoPairs' => 2,
    'threeOfAKind' => 3,
    'fullHouse' => 4,
    'fourOfAKind' => 5,
    'fiveOfAKind' => 6,
];

$games = [];
foreach ($lines as $line) {
    $hand = substr($line, 0, 5);
    $unique = array_unique(str_split($hand));

    $counts = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
    ];
    $jokers = substr_count($hand, 'J');
    foreach ($unique as $char) {
        if ($char == 'J') continue;
        $count = substr_count($hand, $char);
        $counts[$count]++;
    }

    $type = '';
    if ($counts[5] == 1) $type = 'fiveOfAKind';
    elseif ($counts[4] == 1) $type = 'fourOfAKind';
    elseif ($counts[3] == 1 && $counts[2] == 1) $type = 'fullHouse';
    elseif ($counts[3] == 1) $type = 'threeOfAKind';
    elseif ($counts[2] == 2) $type = 'twoPairs';
    elseif ($counts[2] == 1) $type = 'onePair';

    if ($jokers == 1 && $type == '') $type = 'onePair';
    elseif ($jokers == 2 && $type == '') $type = 'threeOfAKind';
    elseif ($jokers == 3 && $type == '') $type = 'fourOfAKind';
    elseif ($jokers == 4 && $type == '') $type = 'fiveOfAKind';
    elseif ($jokers == 1 && $type == 'onePair') $type = 'threeOfAKind';
    elseif ($jokers == 2 && $type == 'onePair') $type = 'fourOfAKind';
    elseif ($jokers == 3 && $type == 'onePair') $type = 'fiveOfAKind';
    elseif ($jokers == 1 && $type == 'twoPairs') $type = 'fullHouse';
    elseif ($jokers == 1 && $type == 'threeOfAKind') $type = 'fourOfAKind';
    elseif ($jokers == 2 && $type == 'threeOfAKind') $type = 'fiveOfAKind';
    elseif ($jokers == 1 && $type == 'fourOfAKind') $type = 'fiveOfAKind';
    elseif ($jokers == 5) $type = 'fiveOfAKind';

    $games[] = [
        'hand' => $hand,
        'type' => $type,
        'bid' => intval(substr($line, 6)),
    ];
}

usort($games, function ($a, $b) use ($cardStrengths, $typeStrengths) {
    if ($a['type'] == $b['type']) {
        foreach(str_split($a['hand']) as $i => $char) {
            if ($char == $b['hand'][$i]) continue;
            return $cardStrengths[$char] < $cardStrengths[$b['hand'][$i]] ? -1 : 1;
        }
    }
    return $typeStrengths[$a['type']] < $typeStrengths[$b['type']] ? -1 : 1;
});

$totalWinnings = 0;
foreach ($games as $index=>$game) {
    $totalWinnings += $game['bid'] * ($index + 1);
}


echo $totalWinnings . PHP_EOL;

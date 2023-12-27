<?php

$lines = file(__DIR__ . "/input.txt");

$workflows = [];
$acceptedParts = [];

$parsingRules = true;
foreach ($lines as $line) {
    $line = rtrim($line);
    if (empty($line)) {
        $parsingRules = false;
        continue;
    }

    if ($parsingRules) {
        parseRule($line);
    } else {
        processPart(parsePart($line));
    }
}

$sum = 0;
foreach ($acceptedParts as $acceptedPart) {
    $sum += $acceptedPart["x"] + $acceptedPart["m"] + $acceptedPart["a"] + $acceptedPart["s"];
}
echo $sum . PHP_EOL;

function processPart($part): void
{
    applyRule($part, "in", 0);
}

function applyRule($part, $workflow, $ruleIndex)
{
    global $workflows;
    global $acceptedParts;

    $rule = $workflows[$workflow]["rules"][$ruleIndex];
    $destination = $rule["destination"];
    if ($rule["condition"] !== null) {
        $condition = $rule["condition"];
        $category = $rule["category"];
        if (($condition === "<" && $part[$category] >= $rule["value"]) || $condition === ">" && $part[$category] <= $rule["value"]) {
            $destination = null;
        }
    }

    if ($destination === "A") {
        $acceptedParts[] = $part;
    } elseif ($destination === null) {
        applyRule($part, $workflow, $ruleIndex + 1);
    } elseif ($destination !== "R") {
        applyRule($part, $destination, 0);
    }
}

function parseRule($line): void
{
    global $workflows;
    $exploded = explode("{", $line);
    $rules = [];
    foreach (explode(",", rtrim($exploded[1], "}")) as $rawRule) {
        $explodedRule = explode(":", $rawRule);
        if (count($explodedRule) === 1) {
            $rules[] = [
                "category" => null,
                "condition" => null,
                "destination" => $explodedRule[0]
            ];
        } else {
            $rules[] = [
                "category" => $explodedRule[0][0],
                "condition" => $explodedRule[0][1],
                "value" => intval(substr($explodedRule[0], 2)),
                "destination" => $explodedRule[1]
            ];
        }
    }
    $workflows[$exploded[0]] = ["rules" => $rules];
}

function parsePart($line): array
{
    $exploded = explode(",", trim($line, "{}"));
    $part = [];
    foreach ($exploded as $rawPart) {
        $explodedPart = explode("=", $rawPart);
        $part[$explodedPart[0]] = intval($explodedPart[1]);
    }
    return $part;
}
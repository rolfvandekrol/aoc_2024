<?php

$stones = array_map(fn ($v) => intval(trim($v)), explode(' ', trim(file_get_contents('input'))));

function blink($stone) {
    if ($stone === 0) {
        return [1];
    }

    $stringStone = strval($stone);
    $stringStoneLength = strlen($stringStone);
    if (($stringStoneLength % 2) === 0) {
        return [
            intval(substr($stringStone, 0, $stringStoneLength / 2)),
            intval(substr($stringStone, $stringStoneLength / 2)),
        ];
    }

    return [$stone * 2024];
}

$numberOfStones = 0;

foreach ($stones as $stone) {
    $newStones = [$stone];

    for ($i = 0; $i < 25; $i++) {
        $afterIterationStones = [];
        foreach ($newStones as $newStone) {
            $afterIterationStones = array_merge($afterIterationStones, blink($newStone));
        }

        $newStones = $afterIterationStones;
    }

    $numberOfStones += count($newStones);
}

print $numberOfStones;
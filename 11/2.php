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

$maxBlinks = 75;

$state = [];
for ($i = 0; $i <= $maxBlinks; $i++) {
    $state[$i] = [];
}

foreach ($stones as $s) {
    $state[0][$s] = ($state[0][$s] ?? 0) + 1;
}

for ($blinks = 0; $blinks < $maxBlinks; $blinks++) {
    while (!empty($state[$blinks])) {
        reset($state[$blinks]);

        $stone = key($state[$blinks]);
        $count = $state[$blinks][$stone];

        unset($state[$blinks][$stone]);

        $newStones = blink($stone);

        foreach ($newStones as $s) {
            $state[$blinks+1][$s] = ($state[$blinks+1][$s] ?? 0) + $count;
        }
    }
}

print array_sum($state[$maxBlinks]);
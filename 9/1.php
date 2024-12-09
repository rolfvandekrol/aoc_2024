<?php

$data = trim(file_get_contents('input'));

$filesystem = [];
foreach (str_split($data) as $i => $size) {
    $size = intval($size);

    $value = (($i % 2) === 0) ? ($i / 2) : null;

    for ($j = 0; $j < $size; $j++) {
        $filesystem[] = $value;
    }
}

$pastePosition = 0;
$cutPosition = count($filesystem) - 1;

while ($cutPosition > $pastePosition) {
    if ($filesystem[$cutPosition] === null) {
        $cutPosition -= 1;
        continue;
    }

    if ($filesystem[$pastePosition] !== null) {
        $pastePosition += 1;
        continue;
    }

    $filesystem[$pastePosition] = $filesystem[$cutPosition];
    $filesystem[$cutPosition] = null;
    $pastePosition += 1;
    $cutPosition -= 1;
}

$checksum = 0;
foreach ($filesystem as $i => $value) {
    if ($value !== null) {
        $checksum += $i * $value;
    }
}

print $checksum;
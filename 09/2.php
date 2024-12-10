<?php

$data = trim(file_get_contents('input'));

$files = [];
$empty = [];

$index = 0;
foreach (str_split($data) as $i => $size) {
    $size = intval($size);

    if (($i % 2) === 0) {
        $files[] = [
            $i / 2,
            $index,
            $size,
        ];
    } else {
        $empty[] = [
            $index,
            $size,
        ];
    }

    $index += $size;
}

for ($i = count($files )-1; $i >= 0; $i--) {
    [$fileIndex, $fileStart, $fileSize] = $files[$i];

    foreach ($empty as $j => [$emptyStart, $emptySize]) {
        if ($emptyStart > $fileStart) {
            break;
        }

        if ($emptySize < $fileSize) {
            continue;
        }

        $files[$i] = [
            $fileIndex,
            $emptyStart,
            $fileSize,
        ];

        $newEmptySize = $emptySize - $fileSize;
        if ($newEmptySize === 0) {
            array_splice($empty, $j, 1);
        } else {
            $empty[$j] = [
                $emptyStart + $fileSize,
                $newEmptySize,
            ];
        }

        break;
    }
}

$checksum = 0;

foreach ($files as [$fileIndex, $fileStart, $fileSize]) {
    $checksum += $fileIndex * $fileSize * ($fileStart + ($fileSize - 1) / 2);
}

print $checksum;
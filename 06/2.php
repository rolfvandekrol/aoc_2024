<?php

$data = array_map(fn ($line) => str_split(trim($line)), explode("\n", trim(file_get_contents('input'))));

function walk($data) {
    $position = null;
    $direction = '^';
    $inMap = true;

    $turnMap = [
        '^' => '>',
        '>' => 'v',
        'v' => '<',
        '<' => '^',
    ];

    foreach ($data as $row => $rowCells) {
        foreach ($rowCells as $column => $cell) {
            if ($cell === '^') {
                $position = [$row, $column];
                $data[$row][$column] = 'X';
            }

            $data[$row][$column] = [
                $data[$row][$column],
                [],
            ];
        }
    }

    while ($inMap) {
        if (in_array($direction, $data[$position[0]][$position[1]][1])) {
            return 'loop';
        }

        $data[$position[0]][$position[1]][1][] = $direction;

        $newPosition = match ($direction) {
            '^' => [$position[0] - 1, $position[1]],
            'v' => [$position[0] + 1, $position[1]],
            '<' => [$position[0], $position[1] - 1],
            '>' => [$position[0], $position[1] + 1],
        };

        if (!isset($data[$newPosition[0]][$newPosition[1]])) {
            return 'left_map';
        }

        $newPositionValue = $data[$newPosition[0]][$newPosition[1]][0];

        if ($newPositionValue === '#') {
            $direction = $turnMap[$direction];
            continue;
        }

        $position = $newPosition;
    }
}

$count = 0;

foreach ($data as $row => $rowCells) {
    foreach ($rowCells as $column => $cell) {
        if ($cell === '.') {
            $newData = $data;
            $newData[$row][$column] = '#';

            $result = walk($newData);
            if ($result === 'loop') {
                $count += 1;
            }
        }
    }
}

print $count;

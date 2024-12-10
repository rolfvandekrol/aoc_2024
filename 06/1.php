<?php

$data = array_map(fn ($line) => str_split(trim($line)), explode("\n", trim(file_get_contents('input'))));

$position = null;
$direction = 'up';
$inMap = true;
$count = 1;

$turnMap = [
    'up' => 'right',
    'right' => 'down',
    'down' => 'left',
    'left' => 'up',
];

foreach ($data as $row => $rowCells) {
    foreach ($rowCells as $column => $cell) {
        if ($cell === '^') {
            $position = [$row, $column];
            $data[$row][$column] = 'X';
            break 2;
        }
    }
}

while ($inMap) {
    $newPosition = match ($direction) {
        'up' => [$position[0] - 1, $position[1]],
        'down' => [$position[0] + 1, $position[1]],
        'left' => [$position[0], $position[1] - 1],
        'right' => [$position[0], $position[1] + 1],
    };

    if (!isset($data[$newPosition[0]][$newPosition[1]])) {
        $inMap = false;
        break;
    }

    $newPositionValue = $data[$newPosition[0]][$newPosition[1]];

    if ($newPositionValue === '#') {
        $direction = $turnMap[$direction];
        continue;
    }

    if ($newPositionValue === '.') {
        $data[$newPosition[0]][$newPosition[1]] = 'X';
        $count += 1;
    }

    $position = $newPosition;
}

//print implode("\n", array_map(fn ($row) => implode('', $row), $data));

print $count;
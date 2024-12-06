<?php

$data = array_filter(array_map(fn ($line) => str_split(trim($line)), explode("\n", trim(file_get_contents('input')))));

$checks = [
    [
        ['M', 0, 1],
        ['A', 0, 2],
        ['S', 0, 3],
    ],
    [
        ['M', 0, -1],
        ['A', 0, -2],
        ['S', 0, -3],
    ],
    [
        ['M', 1, 0],
        ['A', 2, 0],
        ['S', 3, 0],
    ],
    [
        ['M', -1, 0],
        ['A', -2, 0],
        ['S', -3, 0],
    ],
    [
        ['M', 1, 1],
        ['A', 2, 2],
        ['S', 3, 3],
    ],
    [
        ['M', -1, 1],
        ['A', -2, 2],
        ['S', -3, 3],
    ],
    [
        ['M', 1, -1],
        ['A', 2, -2],
        ['S', 3, -3],
    ],
    [
        ['M', -1, -1],
        ['A', -2, -2],
        ['S', -3, -3],
    ],
];

function check($data, $row, $column, $check) {
    foreach ($check as [$v, $row_diff, $column_diff]) {
        $new_row = $row + $row_diff;
        $new_column = $column + $column_diff;

        if (($data[$new_row][$new_column] ?? null) !== $v) {
            return false;
        }
    }

    return true;
}

$cnt = 0;
foreach ($data as $row => $line) {
    foreach ($line as $column => $l) {
        if ($l !== 'X') {
            continue;
        }

        foreach ($checks as $check) {
            if (check($data, $row, $column, $check)) {
                $cnt += 1;
            }
        }
    }
}

print($cnt);
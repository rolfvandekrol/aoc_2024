<?php

$map = array_map(fn ($line) => array_map(fn ($v) => intval($v), str_split(trim($line))), explode("\n", trim(file_get_contents('input'))));

function find_trails($map, $start, $v = 0) {
    [$row, $column] = $start;

    $trails = [];
    foreach ([[-1, 0], [0, 1], [1, 0], [0, -1]] as [$rowDiff, $columnDiff]) {
        if (!isset($map[$row + $rowDiff][$column + $columnDiff]) || $map[$row + $rowDiff][$column + $columnDiff] !== $v+1) {
            continue;
        }

        if ($v+1 === 9) {
            $trails[] = [[$row, $column], [$row + $rowDiff, $column + $columnDiff]];
        } else {
            $t = find_trails($map, [$row + $rowDiff, $column + $columnDiff], $v + 1);
            foreach ($t as $trail) {
                array_unshift($trail, [$row, $column]);

                $trails[] = $trail;
            }
        }
    }

    return $trails;
}

$sum = 0;

foreach ($map as $row => $rowCells) {
    foreach ($rowCells as $column => $cell) {
        if ($cell !== 0) {
            continue;
        }

        $trails = find_trails($map, [$row, $column]);

        $endCells = [];
        foreach ($trails as $trail) {
            $endCell = $trail[count($trail) - 1];

            if (!in_array($endCell, $endCells)) {
                $endCells[] = $endCell;
            }
        }

        $sum += count($endCells);
    }
}

print $sum;
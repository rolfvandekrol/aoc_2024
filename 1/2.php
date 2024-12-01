<?php

$data = array_filter(array_map('trim', explode("\n", trim(file_get_contents('input')))));

$left = [];
$right = [];

foreach ($data as $row) {
    $row = preg_split('/\\s+/', $row);

    $left[] = intval($row[0]);
    $right[] = intval($row[1]);
}

$right_amounts = [];

foreach ($right as $v) {
    if (!isset($right_amounts[$v])) {
        $right_amounts[$v] = 1;
    } else {
        $right_amounts[$v] += 1;
    }
}

$sum = 0;

foreach ($left as $left_value) {
    if (isset($right_amounts[$left_value])) {
        $sum += $left_value * $right_amounts[$left_value];
    }
}


print $sum;
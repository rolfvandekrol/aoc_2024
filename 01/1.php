<?php

$data = array_filter(array_map('trim', explode("\n", trim(file_get_contents('input')))));

$left = [];
$right = [];

foreach ($data as $row) {
    $row = preg_split('/\\s+/', $row);

    $left[] = intval($row[0]);
    $right[] = intval($row[1]);
}

sort($left);
sort($right);

$sum = 0;

foreach ($left as $i => $left_value) {
    $sum += abs($left_value - $right[$i]);
}

print $sum;
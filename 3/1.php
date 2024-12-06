<?php

$data = trim(file_get_contents('input'));

preg_match_all('/mul\\(([0-9]{1,3}),([0-9]{1,3})\\)/', $data, $matches);

$sum = 0;

foreach (array_keys($matches[0]) as $i) {
    $sum += intval($matches[1][$i]) * intval($matches[2][$i]);
}

print $sum;
<?php

$data = trim(file_get_contents('input'));

[$rules, $updates] = explode("\n\n", $data);

$rules = array_map(fn ($v) => array_map(fn ($x) => intval($x), explode("|", $v)), explode("\n", $rules));
$updates = array_map(fn ($v) => array_map(fn ($x) => intval($x), explode(",", $v)), explode("\n", $updates));

$sum = 0;

function validate_update($update, $rules) {
    foreach ($rules as $rule) {
        $firstIndex = array_search($rule[0], $update);
        $secondIndex = array_search($rule[1], $update);

        if ($firstIndex === false || $secondIndex === false) {
            continue;
        }

        if ($firstIndex > $secondIndex) {
            return false;
        }
    }

    return true;
}

foreach ($updates as $update) {
    if (validate_update($update, $rules)) {
        $sum += $update[(count($update) - 1) / 2];
    }
}

print $sum;
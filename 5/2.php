<?php

$data = trim(file_get_contents('input'));

[$rules, $updates] = explode("\n\n", $data);

$rules = array_map(fn ($v) => array_map(fn ($x) => intval($x), explode("|", $v)), explode("\n", $rules));
$updates = array_map(fn ($v) => array_map(fn ($x) => intval($x), explode(",", $v)), explode("\n", $updates));

$sum = 0;

function sort_update($update, $rules) {
    $sortedUpdate = $update;

    usort($sortedUpdate, function ($a, $b) use ($rules) {
        foreach ($rules as $rule) {
            if ($rule[0] == $a) {
                if ($rule[1] == $b) {
                    return -1;
                }
            }
            elseif ($rule[0] == $b) {
                if ($rule[1] == $a) {
                    return 1;
                }
            }
        }

        return 0;
    });

    return $sortedUpdate;
}

function validate_update($update, $rules) {
    $sortedUpdate = sort_update($update, $rules);

    return $update === $sortedUpdate;
}

foreach ($updates as $update) {
    $sortedUpdate = sort_update($update, $rules);

    if ($update !== $sortedUpdate) {
        $sum += $sortedUpdate[(count($sortedUpdate) - 1) / 2];
    }
}

print $sum;
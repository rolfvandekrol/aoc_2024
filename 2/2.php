<?php

$lines = array_filter(array_map('trim', explode("\n", trim(file_get_contents('input')))));

$data = array_map(fn ($line) => array_map(fn ($v) => intval($v), preg_split('/\\s+/', $line)), $lines);

$cnt = 0;

function is_safe($record) {
    for ($i = 1; $i < count($record); $i++) {
        $diff = abs($record[$i] - $record[$i-1]);
        if ($diff < 1 || $diff > 3) {
            return false;
        }

        if ($i > 1) {
            if ($record[$i - 2] < $record[$i - 1]) {
                if ($record[$i - 1] > $record[$i]) {
                    return false;
                }
            } else {
                if ($record[$i - 1] < $record[$i]) {
                    return false;
                }
            }
        }
    }

    return true;
}

foreach ($data as $record) {
    if (is_safe($record)) {
        $cnt++;
        continue;
    }

    for ($i = 0; $i < count($record); $i++) {
        $record_copy = $record;
        array_splice($record_copy, $i, 1);
        if (is_safe($record_copy)) {
            $cnt++;
            continue 2;
        }
    }
}

print $cnt;
<?php

$lines = array_filter(array_map('trim', explode("\n", trim(file_get_contents('input')))));

$data = array_map(fn ($line) => array_map(fn ($v) => intval($v), preg_split('/\\s+/', $line)), $lines);

$cnt = 0;

foreach ($data as $record) {
    for ($i = 1; $i < count($record); $i++) {
    	$diff = abs($record[$i] - $record[$i-1]);
    	if ($diff < 1 || $diff > 3) {
            continue 2;
    	}

        if ($i > 1) {
            if ($record[$i - 2] < $record[$i - 1]) {
                if ($record[$i - 1] > $record[$i]) {
                    continue 2;
                }
            } else {
                if ($record[$i - 1] < $record[$i]) {
                    continue 2;
                }
            }
        }
    }

    $cnt++;
}

print $cnt;
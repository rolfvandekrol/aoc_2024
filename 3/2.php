<?php

$data = trim(file_get_contents('input'));

preg_match_all('/((mul)\\(([0-9]{1,3}),([0-9]{1,3})\\))|((do)\\(\\))|((don\'t)\\(\\))/', $data, $matches);

$sum = 0;

$enabled = true;

foreach ($matches[0] as $i => $v) {
    switch ($v) {
        case 'do()':
            $enabled = true;
            break;
        case 'don\'t()':
            $enabled = false;
            break;
        default:
            if ($enabled) {
                $sum += intval($matches[3][$i]) * intval($matches[4][$i]);
            }
            break;
    }
}

print $sum;
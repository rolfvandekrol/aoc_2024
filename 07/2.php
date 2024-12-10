<?php

$data = array_map(function ($line) {
    $line = array_map('trim', explode(': ', $line));

    return [
        intval($line[0]),
        array_map(fn ($v) => intval($v), explode(' ', $line[1]))
    ];
}, explode("\n", trim(file_get_contents('input'))));

function solve($target, $numbers) {
    $lastNumber = $numbers[count($numbers) - 1];
    $otherNumbers = array_slice($numbers, 0, -1);

    $operators = [['+', $target - $lastNumber]];

    if ($target % $lastNumber === 0) {
        $operators[] = ['*', $target / $lastNumber];
    }

    if (str_ends_with(strval($target), strval($lastNumber))) {
        $operators[] = ['||', intval(substr($target, 0, -1 * strlen(strval($lastNumber))))];
    }

    $solutions = [];
    foreach ($operators as [$operator, $newTarget]) {
        if (count($otherNumbers) === 1) {
            if ($newTarget === $otherNumbers[0]) {
                $solutions[] = [$operator];
            }
        } else {
            $newSolutions = solve($newTarget, $otherNumbers);
            foreach ($newSolutions as $newSolution) {
                $newSolution[] = $operator;
                $solutions[] = $newSolution;
            }
        }
    }

    return $solutions;
}

$sum = 0;

foreach ($data as [$target, $numbers]) {
    $solutions = solve($target, $numbers);

    if ($solutions) {
        $sum += $target;
    }
}

print $sum;
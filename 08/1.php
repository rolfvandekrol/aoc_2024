<?php

$data = array_filter(array_map(fn ($line) => str_split(trim($line)), explode("\n", trim(file_get_contents('input')))));

$antennas = [];

$bounds = [
    count($data),
     count($data[0]),
];

foreach ($data as $row => $line) {
    foreach ($line as $column => $s) {
        if ($s === '.') {
            continue;
        }

        if (!isset($antennas[$s])) {
            $antennas[$s] = [];
        }

        $antennas[$s][] = [$row, $column];
    }
}

$antiNodes = [];

foreach ($antennas as $frequency => $antennasPerFrequency) {
    foreach ($antennasPerFrequency as $a => $antennaA) {
        foreach ($antennasPerFrequency as $b => $antennaB) {
            if ($a === $b) {
                continue;
            }

            $antiNode = [
                $antennaA[0] - ($antennaB[0] - $antennaA[0]),
                $antennaA[1] - ($antennaB[1] - $antennaA[1]),
            ];

            if ($antiNode[0] < 0 || $antiNode[0] >= $bounds[0] || $antiNode[1] < 0 || $antiNode[1] >= $bounds[1]) {
                continue;
            }

            $key = $bounds[0] * $antiNode[0] + $antiNode[1];

            if (!isset($antiNodes[$key])) {
                $antiNodes[$key] = $antiNode;
            }
        }
    }
}

print count($antiNodes);
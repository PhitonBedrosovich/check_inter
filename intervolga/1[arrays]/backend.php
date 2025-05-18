<?php
ini_set('display_errors','Off');
$data = [
    ['Иванов', 'Математика', 5],
    ['Иванов', 'Математика', 4],
    ['Иванов', 'Математика', 5],
    ['Петров', 'Математика', 5],
    ['Сидоров', 'Физика', 4],
    ['Иванов', 'Физика', 4],
    ['Петров', 'ОБЖ', 4],
];
$summary = [];
$subjects = [];
foreach ($data as $entry) {
    $subjects[$entry[1]] = true;
    $summary[$entry[0]][$entry[1]] += $entry[2];
}
ksort($summary);
$subjects = array_keys($subjects);
sort($subjects);
include 'frontend.html';

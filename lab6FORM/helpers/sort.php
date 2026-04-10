<?php

$sortField = $_GET['sort'] ?? 'created_at';
$sortOrder = $_GET['order'] ?? 'asc';

function sortCars(&$cars, $sortField, $sortOrder) {
    usort($cars, function($a, $b) use ($sortField, $sortOrder) {
        $result = ($a[$sortField] ?? '') <=> ($b[$sortField] ?? '');
        return $sortOrder === 'asc' ? $result : -$result;
    });
}

/**
 * Генерация ссылки сортировки
 */
function sortLink($field, $label, $currentField, $currentOrder) {
    $order = ($currentField === $field && $currentOrder === 'asc') ? 'desc' : 'asc';

    $arrow = '';
    if ($currentField === $field) {
        $arrow = $currentOrder === 'asc' ? ' ↑' : ' ↓';
    }

    return "<a href='?sort=$field&order=$order'>$label$arrow</a>";
}
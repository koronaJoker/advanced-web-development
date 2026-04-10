<?php

if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $file = __DIR__ . '/../storage/data.json';

    $cars = file_exists($file)
        ? json_decode(file_get_contents($file), true) ?: []
        : [];

    $cars = array_filter($cars, fn($car) => $car['id'] !== $idToDelete);

    file_put_contents($file, json_encode(array_values($cars), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: ../index.php");
    exit;
}
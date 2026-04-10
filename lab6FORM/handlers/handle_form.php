<?php
require_once __DIR__ . '/../classes/CarForm.php';

$errorMessages = [];
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form = new CarForm($_POST);

    if ($form->validate()) {
        $form->save();
        header("Location: index.php?success=1");
        exit;
    } else {
        $errorMessages = $form->getErrors();
    }
}

if (isset($_GET['success'])) {
    $successMessage = "Data saved successfully!";
}
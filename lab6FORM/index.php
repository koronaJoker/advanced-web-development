<?php
require_once 'handlers/handle_form.php';
require_once 'handlers/handle_delete.php';
require_once 'helpers/sort.php';

$file = __DIR__ . '/storage/data.json';

$cars = file_exists($file)
    ? json_decode(file_get_contents($file), true)
    : [];

if (!empty($cars)) {
    sortCars($cars, $sortField, $sortOrder);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>AutoPark</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Добавление автомобиля</h2>

<?php if ($successMessage): ?>
<div class="success"><?= $successMessage ?></div>
<?php endif; ?>

<?php if (!empty($errorMessages)): ?>
<div class="error">
<ul>
<?php foreach ($errorMessages as $error): ?>
<li><?= $error ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<form method="post">
    <input type="text" name="car-model" placeholder="Model" required>
    <input type="text" name="car-brand" placeholder="Brand" required>
    <input type="date" name="car-data" required>
    <input type="color" name="car-color" required>

<label><input type="radio" name="car-fuel" value="Petrol"> Petrol</label>
<label><input type="radio" name="car-fuel" value="Diesel"> Diesel</label>
<label><input type="radio" name="car-fuel" value="Electric"> Electric</label>

<textarea name="car-description" placeholder="Description"></textarea>
<input type="submit" value="Добавить">
</form>

<?php if (!empty($cars)): ?>
<h2>Список</h2>
<table>
<tr>
<tr>
<th><?= sortLink('brand', 'Brand', $sortField, $sortOrder) ?></th>
<th><?= sortLink('model', 'Model', $sortField, $sortOrder) ?></th>
<th><?= sortLink('release_date', 'Release', $sortField, $sortOrder) ?></th>
<th>Color</th>
<th><?= sortLink('fuel', 'Fuel', $sortField, $sortOrder) ?></th>
<th>Description</th>
<th><?= sortLink('created_at', 'Created', $sortField, $sortOrder) ?></th>
<th>Action</th>
</tr>

<?php foreach ($cars as $car): ?>
<tr>
<td><?= htmlspecialchars($car['brand']) ?></td>
<td><?= htmlspecialchars($car['model']) ?></td>
<td><?= htmlspecialchars($car['release_date']) ?></td>
<td style="background: <?= htmlspecialchars($car['color']) ?>"></td>
<td><?= htmlspecialchars($car['fuel']) ?></td>
<td><?= htmlspecialchars($car['description']) ?></td>
<td><?= htmlspecialchars($car['created_at']) ?></td>
<td>
<a href="?delete=<?= htmlspecialchars($car['id']) ?>" onclick="return confirm('Удалить?')">❌</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</body>
</html>
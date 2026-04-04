<?php
// -------------------- Validators --------------------

/**
 * Interface for all validators
 */
interface ValidatorInterface {
    /**
     * Validate given value
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool;

    /**
     * Get validation error message
     * @return string
     */
    public function getError(): string;
}

/**
 * Validator for required fields
 */
class RequiredValidator implements ValidatorInterface {
    private $error = '';
    private $fieldName;

    /**
     * @param string $fieldName
     */
    public function __construct($fieldName) {
        $this->fieldName = $fieldName;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value): bool {
        if (empty(trim($value))) {
            $this->error = "{$this->fieldName} is required";
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getError(): string {
        return $this->error;
    }
}

/**
 * Validator to prevent numbers in string
 */
class NoNumbersValidator implements ValidatorInterface {
    private $error = '';
    private $fieldName;

    /**
     * @param string $fieldName
     */
    public function __construct($fieldName) {
        $this->fieldName = $fieldName;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function validate($value): bool {
        if (preg_match('/\d/', $value)) {
            $this->error = "{$this->fieldName} must not contain numbers";
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getError(): string {
        return $this->error;
    }
}

// -------------------- Form class --------------------

/**
 * Handles car form data, validation and storage
 */
class CarForm {
    private $data = [];
    private $errors = [];
    private $validators = [];

    /**
     * @param array $postData
     */
    public function __construct($postData) {
        $this->data = $postData;
        $this->setupValidators();
    }

    /**
     * Initialize validators for each field
     * @return void
     */
    private function setupValidators() {
        $this->validators = [
            'car-model' => [new RequiredValidator("Model"), new NoNumbersValidator("Model")],
            'car-brand' => [new RequiredValidator("Brand")],
            'car-data' => [new RequiredValidator("Release Date")],
            'car-color' => [new RequiredValidator("Color")],
            'car-fuel' => [new RequiredValidator("Fuel")],
            'car-description' => [new RequiredValidator("Description")]
        ];
    }

    /**
     * Validate all form fields
     * @return bool
     */
    public function validate(): bool {
        $valid = true;

        foreach ($this->validators as $field => $fieldValidators) {
            foreach ($fieldValidators as $validator) {
                if (!$validator->validate($this->data[$field] ?? '')) {
                    $this->errors[$field] = $validator->getError();
                    $valid = false;
                    break;
                }
            }
        }

        return $valid;
    }

    /**
     * Get validation errors
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * Save form data to JSON file
     * @param string $filename
     * @return void
     */
    public function save($filename = "data.json") {
        $existing = [];

        if (file_exists($filename)) {
            $existing = json_decode(file_get_contents($filename), true) ?: [];
        }

        $existing[] = [
            'id' => uniqid(),
            'model' => $this->data['car-model'],
            'brand' => $this->data['car-brand'],
            'release_date' => $this->data['car-data'],
            'color' => $this->data['car-color'],
            'fuel' => $this->data['car-fuel'],
            'description' => $this->data['car-description'],
            'created_at' => date("Y-m-d")
        ];

        file_put_contents($filename, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

// -------------------- Delete --------------------

/**
 * Delete car by ID from JSON storage
 * @return void
 */
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];

    $cars = [];
    if (file_exists("data.json")) {
        $cars = json_decode(file_get_contents("data.json"), true) ?: [];
    }

    $cars = array_filter($cars, function($car) use ($idToDelete) {
        return $car['id'] !== $idToDelete;
    });

    file_put_contents("data.json", json_encode(array_values($cars), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// -------------------- Form processing --------------------

$errorMessages = [];

/**
 * Handle form submission
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form = new CarForm($_POST);

    if ($form->validate()) {
        $form->save();
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
    } else {
        $errorMessages = $form->getErrors();
    }
}

// -------------------- Messages --------------------

/**
 * Success message
 * @var string
 */
$successMessage = '';

if (isset($_GET['success'])) {
    $successMessage = "Data saved successfully!";
}

// -------------------- Load data --------------------

/**
 * @var array
 */
$cars = [];

if (file_exists("data.json")) {
    $cars = json_decode(file_get_contents("data.json"), true);
}

// -------------------- Sorting --------------------

/**
 * @var string
 */
$sortField = $_GET['sort'] ?? 'created_at';

/**
 * @var string
 */
$sortOrder = $_GET['order'] ?? 'asc';

/**
 * Sort cars array by field and order
 */
if (!empty($cars)) {
    usort($cars, function($a, $b) use ($sortField, $sortOrder) {
        $result = ($a[$sortField] ?? '') <=> ($b[$sortField] ?? '');
        return $sortOrder === 'asc' ? $result : -$result;
    });
}

/**
 * Get sort arrow for UI
 * @param string $field
 * @param string $sortField
 * @param string $sortOrder
 * @return string
 */
function sortClass($field, $sortField, $sortOrder) {
    if ($field !== $sortField) return '';
    return $sortOrder === 'asc' ? '↑' : '↓';
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
<th>Brand</th>
<th>Model</th>
<th>Release</th>
<th>Color</th>
<th>Fuel</th>
<th>Description</th>
<th>Created</th>
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
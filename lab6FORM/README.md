# Лабораторная работа №6. Обработка и валидация форм

## Цель работы
Освоить основные принципы работы с HTML-формами в PHP, включая отправку данных на сервер и их обработку, включая валидацию данных.

## Условие
Студенты должны выбрать тему проекта для лабораторной работы, которая будет развиваться на протяжении курса.

### Например:

- Управление рецептами (добавление, редактирование, удаление рецептов);
- Дневник настроения;
- Трекер привычек;
- Мини-система “тайных признаний”;
- Каталог “странных фактов”;
- Менеджер личных “анти-целей”;

# Шаг 1. Определение модели данных
Для выбранной темы определите, какие данные будут храниться.  
 Например, для “Управления рецептами” это может быть:

- title (название рецепта);
- ingredients (список ингредиентов);
- instructions (пошаговое описание);
- category (категория блюда);
- prep_time (время приготовления);
- difficulty (сложность).
- created_at (дата создания);
- updated_at (дата последнего обновления).
- author (автор рецепта).

*Примечание: при определение модели данных обязательно должно быть:*

- минимум 6 полей;
- хотя бы 1 поле с типом string (текст);
- хотя бы 1 поле с типом date (дата);
- хотя бы 1 поле с типом enum (ограниченный набор значений) (checkbox);
- хотя бы 1 поле с типом text (длинный текст).

## Автопарк
- id авто
- бренд
- название авто
- тип топлива
- дата изготовления
- цвет
- описание




# Шаг 2. Создание HTML-формы
Разработайте **HTML-форму** для создания новой записи (например, нового рецепта). Форма должна содержать все необходимые поля, соответствующие модели данных.
Форма должна использовать метод **POST** и отправлять данные на сервер для обработки.
Добавьте базовую валидацию на стороне клиента (**например, с помощью атрибутов required, minlength, maxlength и т.д.**) для улучшения пользовательского опыта.
Убедитесь, что форма корректно отображается и работает в браузере.


```html
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
```

# Шаг 3. Обработка данных на сервере
Создайте PHP-скрипт для обработки данных, отправленных из формы. Этот скрипт должен:
1. принимать данные из $_POST;
2. выполнять базовую валидацию данных (например, проверять, что `обязательные поля заполнены`, что `дата имеет правильный формат` и т.д.);

Класс Валидатор что введенные значения не пусты.

```php
class RequiredValidator implements ValidatorInterface {
    private $error = '';
    private $fieldName;
    public function __construct($fieldName) { $this->fieldName = $fieldName; }
    public function validate($value): bool {
        if (empty(trim($value))) {
            $this->error = "{$this->fieldName} обязательно для заполнения";
            return false;
        }
        return true;
    }
    public function getError(): string { return $this->error; }
}

```

Валидатор названий - обязательно отсутствие чисел в названии марки.

```php

class NoNumbersValidator implements ValidatorInterface {
    private $error = '';
    private $fieldName;
    public function __construct($fieldName) { 
        $this->fieldName = $fieldName; 
    }

    public function validate($value): bool {
        if (preg_match('/\d/', $value)) {
            $this->error = "{$this->fieldName} не должна содержать цифры";
            return false;
        }
        return true;
    }
    public function getError(): string {
        return $this->error;
        }
}

```

Валидация при отправке формы - создание обьекта класса **CAR**

```php

$errorMessages = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form = new CarForm($_POST);

    if ($form->validate()) {
        $form->save();
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit;
    } 
    
    else {
        $errorMessages = $form->getErrors();
    }
}

```

3. сохранять данные в файл *(например, data.txt)*;
возвращать пользователю сообщение об **успешной** отправке или об **ошибках** валидации.
```php
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
```

### Сообщение об успешном сохранении
```php
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = "Данные успешно сохранены!";
}
```


4. Убедитесь, что данные сохраняются в читаемом формате (например, JSON или CSV) для удобства последующего использования.


# Шаг 4. Вывод данных
Создайте PHP-скрипт для чтения данных из файла и отображения их в виде **HTML-таблицы**.

Таблица должна отображать все записи, сохранённые в файле, и быть отформатирована для удобства чтения (например, с помощью CSS).

```css
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f7f7f7;
    font-family: JetBrains Mono, monospace;
}

form {
    width: 60%;
    margin: 50px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 18px;
}

input[type="text"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

textarea {
    resize: vertical;
}

input[type="color"] {
    width: 100%;
    height: 40px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
}

input[type="radio"] {
    margin-right: 5px;
    margin-left: 10px;
}

input[type="radio"]:first-child {
    margin-left: 0;
}

input[type="submit"] {
    transition: all 0.2s ease;
    background-color: #fff;
    color: #000;
    padding: 10px 30px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #2057fa;
    color: #fff;
}

input[type="submit"]:active {
    background-color: #2057fa;
    color: #fff;
    transform: scale(0.95);
}

.error {
    background: #ffe5e5;
    color: #cc0000;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ffb3b3;
    border-radius: 4px;
}

.input-error {
    border: 1px solid red;
}

/* Стили для таблицы автопарка */
table {
    width: 60%;
    margin: 30px auto;
    border-collapse: collapse;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden; /* чтобы закругления работали */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
    font-size: 16px;
}

th {
    background-color: #f0f0f0;
    font-weight: 600;
}

tr:hover {
    background-color: #f5faff;
}

td:first-child, th:first-child {
    border-left: none;
}

td:last-child, th:last-child {
    border-right: none;
}

/* Цвет ячейки для цвета авто */
td[style*="background"] {
    width: 50px;
    text-align: center;
}

th a {
    text-decoration: none;
    color: #000;
}

th a::after {
    content: '';
    display: inline-block;
    margin-left: 5px;
}

th a.asc::after {
    content: '▲';
    font-size: 0.7em;
    color: #2057fa;
}

th a.desc::after {
    content: '▼';
    font-size: 0.7em;
    color: #2057fa;
}

h2 {
    text-align: center;
    margin-top: 30px;
}
```


```php
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
<td><?= $car['brand'] ?></td>
<td><?= $car['model'] ?></td>
<td><?= $car['release_date'] ?></td>
<td style="background: <?= $car['color'] ?>"></td>
<td><?= $car['fuel'] ?></td>
<td><?= $car['description'] ?></td>
<td><?= $car['created_at'] ?></td>
<td>
<a href="?delete=<?= $car['id'] ?>" onclick="return confirm('Удалить?')">❌</a>
</td>
</tr>
<?php endforeach; ?>

</table>
<?php endif; ?>


```

Добавьте возможность сортировки данных по различным полям (например, по дате создания, по категории и т.д.) для улучшения пользовательского опыта.
# Шаг 5. Дополнительные функции

Сортировка:

```php
$sortField = $_GET['sort'] ?? 'created_at';
$sortOrder = $_GET['order'] ?? 'asc';

if (!empty($cars)) {
usort($cars, function($a, $b) use ($sortField, $sortOrder) {
    $result = ($a[$sortField] ?? '') <=> ($b[$sortField] ?? '');
    return $sortOrder === 'asc' ? $result : -$result;
});
}
```

```php
function sortClass($field, $sortField, $sortOrder) {
    if ($field !== $sortField) return '';
    return $sortOrder === 'asc' ? '↑' : '↓';
}
```


Удаление полей из таблицы:

```php
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
```

[!TIP]
При выполнении всех предыдущих шагов максимальная оценка составляет 9 баллов. Для получения 10 баллов необходимо реализовать одно из следующих дополнительных функций.

# Задание 1. Добавление интерфейса
Проанализируйте существующий код, представленный в примере лекции: код.

Модифицируйте систему валидации, добавив интерфейс для валидаторов. Это позволит унифицировать работу отдельных валидаторов и сделать архитектуру приложения более расширяемой.

```php
interface ValidatorInterface {
    public function validate($value): bool;
    public function getError(): string;
}
```

# Задание 2. ООП-реализация
Реализуйте решение задачи с использованием объектно-ориентированного программирования. Для этого необходимо разработать классы, отвечающие за управление формой, валидацию данных и их сохранение. Такой подход способствует лучшей организации кода, повышает его читаемость и облегчает сопровождение приложения.

Главный класс:

```php
class CarForm {
    private $data = [];
    private $errors = [];
    private $validators = [];

    public function __construct($postData) {
        $this->data = $postData;
        $this->setupValidators();
    }

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

    public function getErrors(): array { return $this->errors; }

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
```

```php
header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
exit;
```


# Документация кода
Код должен быть корректно задокументирован, используя стандарт PHPDoc. Каждая функция и метод должны быть описаны с указанием их входных параметров, выходных данных и описанием функционала. Комментарии должны быть понятными, четкими и информативными, чтобы обеспечить понимание работы кода другим разработчикам.

# Контрольные вопросы

1. Какие существуют методы отправки данных из формы на сервер? Какие методы поддерживает HTML-форма?

GET — данные в URL (видны)
POST — данные в теле запроса (скрыты)

HTML поддерживает: GET и POST

2. Какие глобальные переменные используются для доступа к данным формы в PHP?

$_GET — для GET
$_POST — для POST
$_REQUEST — всё вместе

$_REQUEST = $_GET + $_POST + $_COOKIE

3. Как обеспечить безопасность при обработке данных из формы например, защититься от XSS?

XSS (Cross-Site Scripting) — это уязвимость в веб-сайтах, когда злоумышленник может вставить свой JavaScript-код на страницу, который потом выполнится у других пользователей.
Необходимо использовать экранирование:

```php
htmlspecialchars($value)
```

### Пример:
```php
echo htmlspecialchars($_POST['name']);
```

```php
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

```
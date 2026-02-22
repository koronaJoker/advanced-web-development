<?php
$John_working_days = [1,3,5];
$jane_working_days = [2,4,6];

$months = [
    1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
    'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
];

$current_date = date('d') . ' ' . $months[date('n')] . ' ' . date('Y') . ' года';
$today = date("N");
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>График работы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>График работы сотрудников<br>
        <span><?= $current_date ?></span>
    </h1>

    <table>
        <tr>
            <th>№</th>
            <th>Сотрудник</th>
            <th>График</th>
        </tr>

        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td class="schedule">
                <?= in_array($today, $John_working_days) ? "8:00-12:00" : "Нерабочий день" ?>
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td class="schedule">
                <?= in_array($today, $jane_working_days) ? "12:00-16:00" : "Нерабочий день" ?>
            </td>
        </tr>

    </table>
</div>

</body>
</html>


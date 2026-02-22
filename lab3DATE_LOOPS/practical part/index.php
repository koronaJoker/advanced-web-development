<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Циклы PHP</title>
    <link rel="stylesheet" href="style.css  ">
</head>
<body>

<div class="wrapper">

    <!-- FOR -->
    <div class="card">
        <h1>Цикл For</h1>
            <?php
            $a = 0;
            $b = 0;
        echo "<div class = values>";
            for ($i = 0; $i < 5; $i++) {
                $a += 10;
                $b += 5;
                echo "<li>
                        <span class='num'>".($i+1)."</span>
                        <span class='text'>a = {$a}, b = {$b}</span>
                    </li>";
            }
        echo "</div>";

            echo "<div class='result'>Итог: a = $a, b = $b</div>";
            ?>
    </div>

    <!-- WHILE -->
    <div class="card">
        <h1>Цикл While</h1>

            <?php
            $a = 0;
            $b = 0;
            $i = 0;
        echo "<div class='values'>";
            while ($i < 5) {
                $a += 10;
                $b += 5;
                echo "<li>
                        <span class='num'>".($i+1)."</span>
                        <span class='text'>a = {$a}, b = {$b}</span>
                    </li>";
                $i++;
            }
            echo "</div>";

            echo "<div class='result'>Итог: a = $a, b = $b</div>";
            ?>
    </div>

    <!-- DO WHILE -->
    <div class="card">
        <h1>Цикл Do-While</h1>
            <?php
            $a = 0;
            $b = 0;
            $i = 0;
        echo "<div class='values'>";
            do {
                $a += 10;
                $b += 5;
                echo "<li>
                        <span class='num'>".($i+1)."</span>
                        <span class='text'>a = {$a}, b = {$b}</span>
                    </li>";
                $i++;
            } while ($i < 5);
        echo "</div>";

            echo "<div class='result'>Итог: a = {$a}, b = {$b}</div>";
            ?>
    </div>

</div>

</body>
</html>
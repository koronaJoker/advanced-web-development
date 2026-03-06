<!doctype html>
<html lang=ru>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header></header>
    <nav class="menu">
        <ul>
            <li><a href="#">images</a></li>
            <li><a href="#">buy us a coffee</a></li>
            <li><a href="#">contacts</a></li>
            <li><a href="#">Поставьте 10 пожалуйста</a></li>
        </ul>
    </nav>
    <div class="content">
        <?php
        $dir = "image/";
        $files = scandir($dir);

        if ($files === false) return;
        for ($i = 0; $i < count($files); $i++) {
        if (($files[$i] != ".") && ($files[$i] != "..")) {
                $path = $dir . $files[$i];
                echo '<div class = "image" style = "background-image: url(' . $path . ')"></div>';
            }
        }
        ?>
    </div>
    <footer></footer>

</body>
</html>

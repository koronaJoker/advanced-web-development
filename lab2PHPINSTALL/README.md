# **Лабораторная работа №2**
## Установка и первая программа на PHP
Открываем XAMPP , запускаем **Apache**, **MySQL** **phpMyAdmin**
![alt text](image-1.png)
![alt text](image.png)

## Сервер работает корректно
![alt text](image-3.png)

## Первая программа
```php
<?php
    echo "Hello world!";
```

![alt text](image-4.png)


```php
<?php
    echo "Hello, World with echo!";
    print "Hello, World with print!";
```
![alt text](image-5.png)

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myLab2</title>
</head>
<body>
    <h2>Лаба 2</h2>
</body>
</html>

<?php


    $days = 288;
    $message = "Все возвращаются на работу!";

    echo $days . $message;

    echo "Дней до события: " . $days . "<br>";
    echo "Сообщение: " . $message . "<br>";

    echo "Дней до события: {$days}<br>";
    echo "Дней до события: {$message}<br>";

```

![alt text](image-6.png)

## Контрольные вопросы
- Какие способы установки PHP существуют?
Существуют 2 способа :
    - прямой Неоюходимо перейти на официальный сайт PHP: https://www.php.net/downloads.  
    - Загрузить актуальную версию PHP для вашей операционной системы.
    - Распаковать архив в удобное место, например: C:\Program Files\php.
    - Добавить путь к PHP в переменные среды (Path):
    - Открыть Параметры системы (Win + R → sysdm.cpl).
    - Перейти в Дополнительно → Переменные среды.
    - В разделе Системные переменные выбрать Path и добавьте путь C:\Program Files\php.
    - Сохранить изменения.
    - Проверить установку, выполнив в командной строке: php -v.

- Или - установить XAMPP:

  - Перейдите на сайт: https://www.apachefriends.org.
  - Скачайте и установите XAMPP, выбрав компоненты:
    - Apache
    - PHP
    - phpMyAdmin
Запустите XAMPP Control Panel и включите Apache.  



- Как проверить, что PHP установлен и работает?
Проверьте работу сервера, открыв http://localhost в браузере.
написать пробный код на php например :
` echo "Hello World!"; `

- Чем отличается оператор echo от print?
Оператор echo выводит сообщения, и имеет неограниченное количество параметров, а print - выводит сообщение, и может принимать только 1 параметр, а также всегда возвращает 1. Пользы немного, но оно так и есть. а также он работает медленнее чем echo.
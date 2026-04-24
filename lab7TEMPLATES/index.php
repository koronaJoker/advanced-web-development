<?php
require_once 'vendor/autoload.php';
require_once 'src/functions.php';


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$twig->addFunction(new \Twig\TwigFunction('delete_text', function () {
    return '✖ удалить ✖';
}));

echo $twig->render('index.twig', [
    'title' => 'Лабораторная №7 PHP',
    'caption' => 'Список транзакций',
    'transactions' => getTransactions()
]);


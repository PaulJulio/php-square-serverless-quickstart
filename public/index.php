<?php
if (!file_exists(__DIR__ . '/../vendor/')) {
    header('Location: /install.php');
    die();
}
require_once __DIR__ . '/../vendor/autoload.php';
$m = new Mustache_Engine();
$values = [];
$template = file_get_contents(__DIR__ . '/home.html');
echo $m->render($template, $values);
//SquareServerlessQuickstart\Foo::output();

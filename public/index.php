<?php
if (!file_exists(__DIR__ . '/../vendor/')) {
    header('Location: /install.php');
    die();
}
require_once __DIR__ . '/../vendor/autoload.php';
$m = new Mustache_Engine();
$values = [
    'name' => 'fellow human',
    'value' => 7.11,
    'in_ca' => true,
    'taxed_value' => 7
];
$template = file_get_contents(__DIR__ . '/home.html');
echo $m->render($template, $values);
//SquareServerlessQuickstart\Foo::output();

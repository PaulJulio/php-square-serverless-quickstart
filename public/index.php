<?php
if (!file_exists(__DIR__ . '/../vendor/')) {
    header('Location: /install.php');
    die();
}
require_once __DIR__ . '/../vendor/autoload.php';
SquareServerlessQuickstart\Foo::output();

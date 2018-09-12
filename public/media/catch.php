<?php
require_once __DIR__ . '/../../vendor/autoload.php';
/*
 * This file maps requests to the public service to vendor-provided files
 */
$dirmap = [
    'jquery' => realpath(__DIR__ . '/../../vendor/components/jquery'),
    'bootstrap-css' => realpath(__DIR__ . '/../../vendor/twbs/bootstrap/dist/css'),
    'bootstrap-js' => realpath(__DIR__ . '/../../vendor/twbs/bootstrap/dist/js'),
];
$path = explode('/', $_SERVER['REQUEST_URI']);
if ($path[1] !== 'media') {
    die('404 File Not Found [exception when processing path]]');
}
if (count($path) !== 4) {
    die('404 File Not Found [bad path]');
}
$filename = $dirmap[$path[2]] . '/' . $path[3];
if (file_exists($filename)) {
    $mimes = new \Mimey\MimeTypes();
    $pathinfo = pathinfo($filename);
    $mime = $mimes->getMimeType($pathinfo['extension']);
    header("HTTP/1.1 200 OK");
    header('Content-type: ' . $mime);
    die(file_get_contents($filename));
}
die('404 File Not Found');

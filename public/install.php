<?php
error_reporting(E_ALL | E_NOTICE | E_WARNING);
echo "Checking for install directory... ";
if (checkForInstallDir()) {
    echo "found<br>";
} else {
    echo "not found. Creating.<br>";
    createInstallDir();
    echo "Checking for install directory... ";
    if (checkForInstallDir()) {
        echo "found<br>";
    } else {
        echo "not found. Exiting.<br>";
        die();
    }
}
echo "Checking for composer.phar... ";
if (checkForComposer()) {
    echo "found<br>";
} else {
    echo "not found, installing.<br>";
    register_shutdown_function('afterInstallComposer');
    installComposer();
}

echo "Installing composer dependencies...<br><pre>";
$composer_dir = realpath(__DIR__ . '/../install/');
putenv('COMPOSER_HOME=' . $composer_dir);
$command = "php $composer_dir/composer.phar install --no-interaction 2>&1";
//ob_start();
chdir(__DIR__ . '/../');
system($command);
//ob_clean();
echo '</pre><br>Done<br><a href="/index.php">Back to home.</a>';

function checkForInstallDir() {
    return file_exists(__DIR__ . '/../install');
}
function createInstallDir() {
    mkdir(__DIR__ . '/../install');
}
function checkForComposer() {
    return file_exists(__DIR__ . '/../install/composer.phar');
}
function installComposer() {
    file_put_contents(__DIR__ . '/../install/composer-setup.php',
        file_get_contents('https://getcomposer.org/installer')
    );
    global $argv;
    $argv = ['composer-setup.php', '--install-dir', realpath(__DIR__ . '/../install/'), '--quiet'];
    putenv('COMPOSER_HOME=' . realpath(__DIR__ . '/../install/'));
    ob_start();
    require_once __DIR__ . '/../install/composer-setup.php';
    ob_clean();
    unlink(__DIR__ . '/../install/composer-setup.php');
}
function afterInstallComposer() {
    if (file_exists(__DIR__ . '/../install/composer-setup.php')) {
        unlink(__DIR__ . '/../install/composer-setup.php');
    }
    if (checkForComposer()) {
        echo 'Composer found, please <a href="/install.php"> refresh<br>';
    } else {
        echo 'Composer not found. Exiting';
    }
}
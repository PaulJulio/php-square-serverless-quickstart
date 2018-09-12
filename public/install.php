<?php
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
    echo "not found, installing.<br><pre>";
    installComposer();
    afterInstallComposer();
}

echo "Installing composer dependencies...<br><pre>";
$composer_dir = realpath(__DIR__ . '/../install/');
putenv('COMPOSER_HOME=' . $composer_dir);
$command = "php $composer_dir/composer.phar install --no-interaction 2>&1";
chdir(__DIR__ . '/../');
system($command);
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
    $composer_dir = realpath(__DIR__ . '/../install');
    putenv('COMPOSER_HOME=' . $composer_dir);
    $command = "php $composer_dir/composer-setup.php --install-dir $composer_dir 2>&1";
    chdir(__DIR__ . '/../');
    system($command);
}
function afterInstallComposer() {
    if (file_exists(__DIR__ . '/../install/composer-setup.php')) {
        unlink(__DIR__ . '/../install/composer-setup.php');
    }
    if (checkForComposer()) {
        echo '</pre><br>Composer installed.<br>';
    } else {
        echo '</pre><br>Composer not found. Exiting';
        die();
    }
}
<?php

// find the autoload file
// copied from https://github.com/sebastianbergmann/phpunit/blob/5.5/phpunit
// with minor modifications
foreach (array(__DIR__ . '/../../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        define('PHPUNIT_COMPOSER_INSTALL', $file);

        break;
    }
}

unset($file);

if (!defined('PHPUNIT_COMPOSER_INSTALL')) {
    fwrite(STDERR,
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'wget http://getcomposer.org/composer.phar' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );

    die(1);
}

require PHPUNIT_COMPOSER_INSTALL;

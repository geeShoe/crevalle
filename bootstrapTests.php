<?php

require __DIR__ . '/vendor/autoload.php';

$dotFile = __DIR__ . '/.env.testing.local';

if (!is_file($dotFile) || !is_readable($dotFile)) {
    throw new RuntimeException(
        'The functional test suite requires a .env.testing.local file.'
    );
}

$env = new Symfony\Component\Dotenv\Dotenv();
$env->load($dotFile);

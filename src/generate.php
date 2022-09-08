<?php

namespace Ictools\EnvGenerator;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Ictools\EnvGenerator\Generator;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

if (!array_key_exists('ENV_GENERATOR_PROJECT_NAME', $_ENV)
    || !array_key_exists('ENV_GENERATOR_APP_ENV', $_ENV)
    || !array_key_exists('ENV_GENERATOR_AWS_USER_KEY', $_ENV)
    || !array_key_exists('ENV_GENERATOR_AWS_USER_SECRET', $_ENV)
    || !array_key_exists('ENV_GENERATOR_AWS_REGION', $_ENV)
){
    echo "\e[0;31mWe did not find all the necessary environment variables.\e[0m\n";
} else {
    $generator = new Generator();
    $generator->create($_ENV['ENV_GENERATOR_PROJECT_NAME'], $_ENV['ENV_GENERATOR_APP_ENV']);
}


<?php

namespace Ictools\EnvGenerator;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Ictools\EnvGenerator\Generator;

try {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 4));
    $dotenv->load();
} catch (\Exception $exception){}

if (!getenv("ENV_GENERATOR_PROJECT_NAME")
    || !getenv("ENV_GENERATOR_APP_ENV")
    || !getenv("ENV_GENERATOR_AWS_USER_KEY")
    || !getenv("ENV_GENERATOR_AWS_USER_SECRET")
    || !getenv("ENV_GENERATOR_AWS_REGION")
){
    echo "\e[0;31mWe did not find all the necessary environment variables.\e[0m\n";
} else {
    $generator = new Generator();
    $generator->create(getenv("ENV_GENERATOR_PROJECT_NAME"), getenv("ENV_GENERATOR_APP_ENV"));
}
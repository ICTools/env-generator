<?php

namespace Ictools\EnvGenerator;

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Ictools\EnvGenerator\Generator;

$generator = new Generator();

$path = dirname(__DIR__, 4);
$file = '.env';

if($generator->isFileExist($path, $file)){
    $dotenv = Dotenv::createImmutable($path);
    $dotenv->load();
}

if (!$_SERVER["ENV_GENERATOR_PROJECT_NAME"]
    || !$_SERVER["ENV_GENERATOR_APP_ENV"]
    || !$_SERVER["ENV_GENERATOR_AWS_USER_KEY"]
    || !$_SERVER["ENV_GENERATOR_AWS_USER_SECRET"]
    || !$_SERVER["ENV_GENERATOR_AWS_REGION"]
){
    echo "\e[0;31mWe did not find all the necessary environment variables.\e[0m\n";
} else {
    $generator->create($_SERVER["ENV_GENERATOR_PROJECT_NAME"], $_SERVER["ENV_GENERATOR_APP_ENV"]);
}
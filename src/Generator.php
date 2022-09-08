<?php

namespace Ictools\EnvGenerator;

use Aws\Exception\AwsException;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class Generator
{
    public function create(): void
    {
        $rootPath = dirname(__DIR__, 2);

        $secretsList = $this->getSecretsList();

        $componentsList = $this->getComponentsList($secretsList, $_ENV['ENV_GENERATOR_PROJECT_NAME']);

        if (empty($componentsList)) {
            echo "\e[0;31mOops, we have not found a secret for this project.\e[0m\n";
        } else {
            foreach ($componentsList as $component) {

                $secretsArr = $this->getSecretArr(
                    $secretsList,
                    $_ENV['ENV_GENERATOR_PROJECT_NAME'],
                    $_ENV['ENV_GENERATOR_APP_ENV'],
                    $component
                );

                $content = "### This file is generated by env-generator ###\n\n";
                foreach ($secretsArr as $key => $value) {
                    $content .= "$key=$value\n";
                }

                $specificPath = '';
                if (array_key_exists('ENV_GENERATOR_SPECIFIC_PATH', $_ENV)){
                    $specificPath = $_ENV['ENV_GENERATOR_SPECIFIC_PATH'];
                }

                $adapter = new LocalFilesystemAdapter("$rootPath/$component/$specificPath");
                $filesystem = new Filesystem($adapter);

                $env = $_ENV['ENV_GENERATOR_APP_ENV'];
                $filesystem->write("$env.env", $content);
            }
            echo "\e[0;32mCongratulations, your files are generated! Coffee time!\e[0m\n";
        }
    }

    private function getSecretsList(): array
    {
        $AwsSecretManager = new AwsSecretManager();
        try {
            return $AwsSecretManager->getListSecrets()?->get('SecretList');
        } catch (AwsException $exception){
            echo $exception->getMessage();
        }
    }

    private function getSecretValue($secretName): array
    {
        $AwsSecretManager = new AwsSecretManager();
        try {
            return $AwsSecretManager->getSecretValue($secretName);
        } catch (AwsException $exception){
            echo $exception->getMessage();
        }
    }

    private function getSecretArr(array $secretsList, string $projectName, string $env, string $component): array
    {
        $secretsArr = [];
        foreach ($secretsList as $secret) {
            //$schema = [0 => projectName, 2 => env, 3 => component, 4 => secretName]
            $schema = explode('/', $secret['Name']);

            if (in_array($projectName, $schema, true)
                && in_array($env, $schema, true)
                && in_array($component, $schema, true)
            ){
                $secretValues = $this->getSecretValue($secret['Name']);

                foreach ($secretValues as $key => $value) {
                    $secretsArr[$key] = $value;
                }
            }
        }

        return $secretsArr;
    }

    private function getComponentsList($secretsList, $projectName): array
    {
        $componentsList = [];
        foreach ($secretsList as $secret) {
            $schema = explode('/', $secret['Name']);

            if (in_array($projectName, $schema, true)){
                $componentsList[] = $schema[2];
            }
        }
        return $componentsList;
    }
}
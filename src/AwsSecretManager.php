<?php

namespace Ictools\EnvGenerator;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

class AwsSecretManager
{
    public function __construct(){
        $this->client = $this->client();
    }

    public function client(): SecretsManagerClient
    {
        return new SecretsManagerClient([
            'version' => '2017-10-17',
            'region' => $_SERVER["ENV_GENERATOR_AWS_REGION"],
            'credentials' => [
                'key' => $_SERVER["ENV_GENERATOR_AWS_USER_KEY"],
                'secret' => $_SERVER["ENV_GENERATOR_AWS_USER_SECRET"],
            ]
        ]);
    }

    public function getSecretValue($secretName): array
    {
        $result = $this->client->getSecretValue([
            'SecretId' => $secretName,
        ]);

        $secret = $result['SecretString'] ?? base64_decode($result['SecretBinary']);
        $secret = (array)json_decode($secret, false, 512, JSON_THROW_ON_ERROR);

        return $secret;
    }

    public function getListSecrets()
    {
        try {
            return $this->client->listSecrets([]);
        }  catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }
}
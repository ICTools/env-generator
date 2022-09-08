# ENV GENERATOR

This tool allows you to download environment variables from AWS Secrets Manager and add them to your environment files.
It is useful if you have several components. A use case is to deploy a [monorepository](https://github.com/enspirit/makefile-for-monorepos) project on an EC2 instance.


Run this in the root of your project:
```bash
composer require ictools/env-generator  
```

## 1. Create a secret

- Create a secret in [AWS Secrets Manager](https://eu-west-3.console.aws.amazon.com/secretsmanager) :
- You can have several keys/values in a secret
- Secret name: '**projectName/env/component/secretName**' ⚠️ 

## 2. .Env

Add this to the root of your project

```
ENV_GENERATOR_PROJECT_NAME=
ENV_GENERATOR_APP_ENV=
ENV_GENERATOR_AWS_USER_KEY=
ENV_GENERATOR_AWS_USER_SECRET=
ENV_GENERATOR_AWS_REGION=

# Optional
ENV_GENERATOR_SPECIFIC_PATH=
```

## 3. Run

```bash
php vendor/ictools/env-generator/src/generate.php
```
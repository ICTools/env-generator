# ENV GENERATOR


The architecture imagined to use this component is a [monorepo](https://en.wikipedia.org/wiki/Monorepo).

This tool allows you to download environment variables from AWS Secrets Manager and add them to your environment files.
It is useful if you have several components.

Run this in the root of your project:
```bash
composer require ictools/env-generator  
```

## Install

### 1. Create a secret

- Create a secret in [AWS Secrets Manager](https://eu-west-3.console.aws.amazon.com/secretsmanager) :
- You can have several keys/values in a secret
- Secret name: '**projectName/env/component/secretName**' ⚠️ 

### 2. .Env

Add this to the root of your project

```
ENV_GENERATOR_PROJECT_NAME=
ENV_GENERATOR_APP_ENV=
ENV_GENERATOR_AWS_USER_KEY=
ENV_GENERATOR_AWS_USER_SECRET=
ENV_GENERATOR_AWS_REGION=


### Optional ###
# This variable allows you to define a specific path for your .env files
ENV_GENERATOR_SPECIFIC_PATH=
```

## Getting started

### Generate .env files

```
monorepo
├── api                 # An api component
│   ├── env             # If ENV_GENERATOR_SPECIFIC_PATH=env
│   │   └── prod.env    # env-generator will generate this file
│   └── ...             
├── redis               
│   ├── env             # If ENV_GENERATOR_SPECIFIC_PATH=env  
│   │   └── prod.env    # env-generator will generate this file
│   └── ... 
├── ... 
└── .env                # Specify here the environment variables for env-generator
```

To generate the prod.env files, run this command in production

```bash
php vendor/ictools/env-generator/src/generate.php
```

> Don't forget : ENV_GENERATOR_APP_ENV=prod

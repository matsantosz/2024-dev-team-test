# Buzzvel 2024 Dev TeamTest

# Set up

## Clone the Project

```
git clone git@github.com:matsantosz/2024-dev-team-test.git

cd 2024-dev-team-test

cp .env.example .env

composer install

php artisan key:gen
```

## Serve using Docker

```
docker compose up -d
```

## Run migrations

```
docker compose run --rm web php artisan migrate --seed
```

## Run tests

```
docker compose run --rm web php artisan test --parallel
```

# Endpoints

Documentation for all endpoints are stored inside the `docs` folder, you can either import the `postman.json` file into your Postman or import the whole folder into [Bruno](https://www.usebruno.com/).

Consider `base_url` as the base URL of your project, it should be something like `http://localhost:8000`

### Auth Endpoints

|method|endpoint|description|
|---|---|---|
|POST|{{base_url}}/api/auth/register|Creates a user|
|POST|{{base_url}}/api/auth/login|Generate a Bearer Token for Authentication|
|POST|{{base_url}}/api/auth/logout|Revoke all active tokens of the user|

### Holiday Plan Endpoints

|method|endpoint|description|
|---|---|---|
|GET|{{base_url}}/api/holiday_plans|Retrieve the user's holiday plans|
|POST|{{base_url}}/api/holiday_plans|Create a new holiday plan|
|GET|{{base_url}}/api/holiday_plans/{id}|Retrieve aspecific holiday plan by ID|
|PATCH|{{base_url}}/api/holiday_plans/{id}|Updateanexisting holiday plan|
|DELETE|{{base_url}}/api/holiday_plans/{id}|Delete a holiday plan|
|POST|{{base_url}}/api/holiday_plans/{id}/generate|Trigger PDF generation for a specific holiday plan|

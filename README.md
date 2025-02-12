# Ecommerce API application

This is a Ecommerce API application ready out of the box (after instaliation)  

The entire application is contained within the `app.rb` file.

`config.ru` is a minimal Rack configuration for unicorn.

`run-tests.sh` runs a simplistic test and generates the API
documentation below.

It uses `run-curl-tests.rb` which runs each command defined in
`commands.yml`.

## Clone Repo

    git clone https://github.com/garbox/RESTful-API-Ecom

## Composer install

    composer install

## Run migrations

    php artisan migrate

# Test Application

    php artisan test

## Get Users

### Request

`GET /user/`

### Response


## Get single user

### Request


`GET /user/{user_id}`

### Response



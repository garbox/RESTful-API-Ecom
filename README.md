# Ecommerce API application

This is a Ecommerce API application ready out of the box (after instaliation).

## Clone Repo

    git clone https://github.com/garbox/RESTful-API-Ecom

## Composer install

    composer install

## Run migrations

    php artisan migrate

## Test Application

    php artisan test

## Get First API Key

    php artisan app:first-api-token   

# API Endpoints 

## Get Users

#### Request

`GET /user/`

#### Response
    json object with all users in following format
    [
        { 
            "id": int, 
            "name": string, 
            "email": string, 
            "email_verified_at": date, 
            "created_at": date 
        }
        { 
            "id": int, 
            "name": string, 
            "email": string, 
            "email_verified_at": date, 
            "created_at": date 
        }
    ]   

## Get single user

#### Request

`GET /user/{user_id}`

#### Response
        json object with single user 
        { 
            "id": int, 
            "name": string, 
            "email": string, 
            "email_verified_at": date, 
            "created_at": date 
        }



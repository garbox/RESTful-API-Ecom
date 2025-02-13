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

## Get admins

### Request

`GET /admin/`

### Response
[
    { 
        "id": int, 
        "name": string, 
        "email": string, 
        "role_id": int, 
        "permissions": int, 
        "created_at": date, 
        "updated_at": date
    }
    { 
        "id": int, 
        "name": string, 
        "email": string, 
        "role_id": int, 
        "permissions": int, 
        "created_at": date, 
        "updated_at": date 
    }
]   

## Get single admin

### Request

`GET /admin/{admin_id}`

### Response
{ 
    "id": int, 
    "name": string, 
    "email": string, 
    "role_id": int, 
    "permissions": int, 
    "created_at": date, 
    "updated_at": date
}



## Create an admin

### Request

`POST /admin
{
    name: string,
    email: string,
    role_id: int,
    permissions: int
}

### Response
{ 
    "id": int, 
    "name": string, 
    "email": string, 
    "role_id": int, 
    "permissions": int, 
    "created_at": date, 
    "updated_at": date
}

## Delete an admin

### Request

`DELETE /admin/{admin_id}

### Response
404 
'message' => 'Admin user cannot be found.'

200
'message' => 'Admin user deleted successfully.'

500
'message' => 'Failed to delete admin.'
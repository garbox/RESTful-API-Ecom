<h5 data-toggle="collapse" href="#productMain" role="button" aria-expanded="false" aria-controls="productMain" style="cursor: pointer;">Product</h5>
<ul class="collapse" id="productMain">
    <!-- GET /product -->
    <li>
        <span data-toggle="collapse" href="#productAll" role="button" aria-expanded="false" aria-controls="productAll" style="cursor: pointer;">
        GET {{parse_url(route('product.all'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="productAll">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "data": [<br>
                {<br>
                "id": 0,<br>
                "name": "string",<br>
                "price": 0,<br>
                "short_description": "string",<br>
                "long_description": "string",<br>
                "category_id": "string",<br>
                "featured": 0,<br>
                "available": 0,<br>
                "category": {<br>
                    "id": 0,<br>
                    "name": "string"<br>
                },<br>
                "photos": [<br>
                    {<br>
                    "id": 0,<br>
                    "product_id": 0,<br>
                    "file_name": "string"<br>
                    }
                ]
                }
            ]
            }
            </code>
        </div>
    </li>
    
    <!-- GET /product/{product_id} -->
    <li>
        <span data-toggle="collapse" href="#productShow" role="button" aria-expanded="false" aria-controls="productShow" style="cursor: pointer;">
        GET api/product/{product_id}
        </span>
        <div class="collapse codeAera" id="productShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "id": integer,<br>
            "name": "string",<br>
            "short_description": "string",<br>
            "price": integer,<br>
            "category_id": integer,<br>
            "long_description": "string",<br>
            "featured": integer,<br>
            "available": integer,<br>
            "created_at": "2019-08-24T14:15:22Z",<br>
            "updated_at": "2019-08-24T14:15:22Z"<br>
            }<br>
            </code>
        </div>
    </li>
    
    <!-- GET /product/search/{search} -->
    <li>
        <span data-toggle="collapse" href="#productSearch" role="button" aria-expanded="false" aria-controls="productSearch" style="cursor: pointer;">
        GET api/product/search/{search}
        </span>
        <div class="collapse codeAera" id="productSearch">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "data": [<br>
                {<br>
                "id": integer,<br>
                "name": "string",<br>
                "price": integer,<br>
                "short_description": "string",<br>
                "long_description": "string",<br>
                "category_id": "string",<br>
                "featured": integer,<br>
                "available": integer,<br>
                "category": {<br>
                    "id": integer,<br>
                    "name": "string"<br>
                },<br>
                "photos": [<br>
                    {<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name": "string"<br>
                    }<br>
                ]
                }
            ]
            }
            </code>
        </div>
    </li>
    
    <!-- GET /product/available -->
    <li>
        <span data-toggle="collapse" href="#productAvailable" role="button" aria-expanded="false" aria-controls="productAvailable" style="cursor: pointer;">
        GET {{parse_url(route('product.avaliable'),PHP_URL_PATH)}}

        </span>
        <div class="collapse codeAera" id="productAvailable">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "data": [<br>
                {<br>
                "id": integer,<br>
                "name": "string",<br>
                "price": integer,<br>
                "short_description": "string",<br>
                "long_description": "string",<br>
                "category_id": "string",<br>
                "featured": integer,<br>
                "available": integer,<br>
                "category": {<br>
                    "id": integer,<br>
                    "name": "string"<br>
                },<br>
                "photos": [<br>
                    {<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name": "string"<br>
                    }<br>
                ]
                }
            ]
            }
            </code>
        </div>
    </li>    
    
    <!-- GET /product/featured -->
    <li>
        <span data-toggle="collapse" href="#productAvailable" role="button" aria-expanded="false" aria-controls="productAvailable" style="cursor: pointer;">
        GET {{parse_url(route('product.featured'),PHP_URL_PATH)}}

        </span>
        <div class="collapse codeAera" id="productAvailable">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "data": [<br>
                {<br>
                "id": integer,<br>
                "name": "string",<br>
                "price": integer,<br>
                "short_description": "string",<br>
                "long_description": "string",<br>
                "category_id": "string",<br>
                "featured": integer,<br>
                "available": integer,<br>
                "category": {<br>
                    "id": integer,<br>
                    "name": "string"<br>
                },<br>
                "photos": [<br>
                    {<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name": "string"<br>
                    }<br>
                ]
                }
            ]
            }
            </code>
        </div>
    </li>        
    
    <!-- POST /product-->
    <li>
        <span data-toggle="collapse" href="#productShow" role="button" aria-expanded="false" aria-controls="productShow" style="cursor: pointer;">
        POST {{parse_url(route('product.create'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="productShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }<br>
            body : {<br>
                "name": "string",<br>
                "price": integer,<br>
                "category_id" : integer,<br>
                "short_description": "string",<br>
                "long_description": "string",<br>
                "product_type_id": integer,<br>
                "featured": bool,<br>
                "available": bool<br>
                }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "id": integer,<br>
            "name": "string",<br>
            "short_description": "string",<br>
            "price": integer,<br>
            "category_id": integer,<br>
            "long_description": "string",<br>
            "featured": integer,<br>
            "available": integer,<br>
            "created_at": date,<br>
            "updated_at": date<br>
            }<br>
            </code>
        </div>
    </li>    
    
    <!-- PUT /product/{product_id} -->
    <li>
        <span data-toggle="collapse" href="#productShow" role="button" aria-expanded="false" aria-controls="productShow" style="cursor: pointer;">
        PUT /api/product/{product_id}
        </span>
        <div class="collapse codeAera" id="productShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }<br>
            body : {<br>
                "name": "string|nullable",<br>
                "price": integer|nullable,<br>
                "category_id" : integer|nullable,<br>
                "short_description": "string"|nullable,<br>
                "long_description": "string"|nullable,<br>
                "product_type_id": integer|nullable,<br>
                "featured": bool|nullable,<br>
                "available": bool|nullable<br>
                }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
            "id": integer,<br>
            "name": "string",<br>
            "short_description": "string",<br>
            "price": integer,<br>
            "category_id": integer,<br>
            "long_description": "string",<br>
            "featured": integer,<br>
            "available": integer,<br>
            "created_at": date,<br>
            "updated_at": date<br>
            }<br>
            </code>
        </div>
    </li>  
    
    <!-- DELETE /product/{product_id} -->
    <li>
        <span data-toggle="collapse" href="#productShow" role="button" aria-expanded="false" aria-controls="productShow" style="cursor: pointer;">
        DELETE /api/product/{product_id}
        </span>
        <div class="collapse codeAera" id="productShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }<br>
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                "message" : 'Product deleted successfully'<br>
            }<br>
            </code>
        </div>
    </li>  
</ul>
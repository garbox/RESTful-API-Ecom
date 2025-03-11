<h5 data-toggle="collapse" href="#shippingMain" role="button" aria-expanded="false" aria-controls="shippingMain" style="cursor: pointer;">Shipping</h5>
<ul class="collapse" id="shippingMain">
    <!-- GET /shipping -->
    <li>
        <span data-toggle="collapse" href="#shippingAll" role="button" aria-expanded="false" aria-controls="shippingAll" style="cursor: pointer;">
        GET {{parse_url(route('shipping.all'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="shippingAll">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            [
                {<br>
                    "id": integer,<br>
                    "user_id": integer,<br>
                    "order_id": integer,<br>
                    "name": "string",<br>
                    "email": "string",<br>
                    "phone": "string",<br>
                    "address": "string",<br>
                    "zip": integer,<br>
                    "city": "string",<br>
                    "state": "string",<br>
                    "created_at": date,<br>
                    "updated_at": date<br>
                }
                ]
            </code>
        </div>
    </li>

    <!-- GET /shipping/{shipping_id} -->
    <li>
        <span data-toggle="collapse" href="#shippingShow" role="button" aria-expanded="false" aria-controls="shippingShow" style="cursor: pointer;">
        GET /api/shipping/{shipping_id}
        </span>
        <div class="collapse codeAera" id="shippingShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
                {<br>
                    "id": integer,<br>
                    "user_id": integer,<br>
                    "order_id": integer,<br>
                    "name": "string",<br>
                    "email": "string",<br>
                    "phone": "string",<br>
                    "address": "string",<br>
                    "zip": integer,<br>
                    "city": "string",<br>
                    "state": "string",<br>
                    "created_at": date,<br>
                    "updated_at": date<br>
                }
            </code>
        </div>
    </li>

    <!-- POST /shipping -->
    <li>
        <span data-toggle="collapse" href="#shippingStore" role="button" aria-expanded="false" aria-controls="shippingStore" style="cursor: pointer;">
        GET {{parse_url(route('shipping.store'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="shippingStore">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                "name": "string",<br>
                "email": "string",<br>
                "address": "string",<br>
                "city": "string",<br>
                "zip": 0,<br>
                "state": "string",<br>
                "phone": "string",<br>
                "user_id": integer,<br>
                "order_id": integer<br>
            }
            </code>
        </div>
    </li>

    <!-- PUT /shipping/{shipping_id} -->
    <li>
        <span data-toggle="collapse" href="#shippingUpdate" role="button" aria-expanded="false" aria-controls="shippingUpdate" style="cursor: pointer;">
        PUT /api/shipping/{shipping_id}
        </span>
        <div class="collapse codeAera" id="shippingUpdate">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            body :<br>{<br>
                "name": "string"|nullable,<br>
                "email": "string"|nullable,<br>
                "address": "string"|nullable,<br>
                "city": "string"|nullable,<br>
                "zip": 0|nullable,<br>
                "state": "string"|nullable,<br>
                "phone": "string"|nullable,<br>
                "user_id": integer|nullable,<br>
                "order_id": integer|nullable<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                "name": "string",<br>
                "email": "string",<br>
                "address": "string",<br>
                "city": "string",<br>
                "zip": integer,<br>
                "state": "string",<br>
                "phone": "string",<br>
                "user_id": integer,<br>
                "order_id": integer<br>
            }
            </code>
        </div>
    </li>

    <!-- DELETE /shipping/{shipping_id} -->
    <li>
        <span data-toggle="collapse" href="#shippingDestory" role="button" aria-expanded="false" aria-controls="shippingDestory" style="cursor: pointer;">
        DELETE /api/shipping/{shipping_id}
        </span>
        <div class="collapse codeAera" id="shippingDestory">
            <code>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                "message": "Shipping info deleted successfully"<br>
            }
            </code>
        </div>
    </li>
</ul>
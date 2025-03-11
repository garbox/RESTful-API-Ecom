<h5 data-toggle="collapse" href="#userMain" role="button" aria-expanded="false" aria-controls="userMain" style="cursor: pointer;">User</h5>
<ul class="collapse" id="userMain">


    <!-- GET /user/all -->
    <li>
        <span data-toggle="collapse" href="#adminGETId" role="button" aria-expanded="false" aria-controls="adminGETId" style="cursor: pointer;">
        GET {{parse_url(route('user.all'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="adminGETId">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            <hr>
            <p>RESPONSE:<br> </p>
            array[<br>
            {<br>
                "id": 0,<br>
                "name": "string",<br>
                "email": "string",<br>
                "address": "string",<br>
                "city": "string",<br>
                "state": "string",<br>
                "zip": "string",<br>
                "api_token": "string"<br>
            }
            ]
            </code>
        </div>
    </li>


    <!-- GET /user/{user_id} -->
    <li>
        <span data-toggle="collapse" href="#adminGETId" role="button" aria-expanded="false" aria-controls="adminGETId" style="cursor: pointer;">
        GET /user/{user_id}
        </span>
        <div class="collapse codeAera" id="adminGETId">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/admin<br>
            }
            <hr>
            <p>RESPONSE:<br> </p>
            {<br>
                "id": integer,<br>
                "name": "string",<br>
                "email": "string",<br>
                "address": "string",<br>
                "city": "string",<br>
                "state": "string",<br>
                "zip": "string",<br>
                "api_token": "string"<br>
            }
            </code>
        </div>
    </li>

    <!-- GET /user/{user_id}/cart -->
    <li>
        <span data-toggle="collapse" href="#adminGETId" role="button" aria-expanded="false" aria-controls="adminGETId" style="cursor: pointer;">
        GET /user/{user_id}
        </span>
        <div class="collapse codeAera" id="adminGETId">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br> </p>
            {<br>
                "id": integer,<br>
                "name": "string",<br>
                "email": "string",<br>
                "address": "string",<br>
                "city": "string",<br>
                "state": "string",<br>
                "zip": "string",<br>
                "api_token": "string"<br>
            }
            </code>
        </div>
    </li>

    <!-- GET /user/{user_id}/orders -->


    <!-- GET /user/{user_id}/shipping-->


    <!-- GET /user/{user_id}/totalSale -->


    <!-- POST /user -->


    <!-- PUT /user/{user_id} -->


    <!-- DELETE /user/{user_id} -->
</ul>
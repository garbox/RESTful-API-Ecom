<div>
    <h5 data-toggle="collapse" href="#adminMain" role="button" aria-expanded="false" aria-controls="adminMain" style="cursor: pointer;">Admin</h5>
    <ul class="collapse" id="adminMain">
        
        <!-- POST api/admin/login -->
        <li>
            <span data-toggle="collapse" href="#adminLogin" role="button" aria-expanded="false" aria-controls="adminLogin" style="cursor: pointer;">
            POST api/admin/login
            </span>

            <div class="collapse codeAera" id="adminLogin" >
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }<br>
                body: {<br>
                "email": string, <br>
                "password": string <br>
                }
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                'id' : integer,<br>
                'name' : string,<br>
                'email' : string,<br>
                'api_token' : string<br>
                }
                </code>
            </div>
        </li>
        
        <!-- GET api/admin -->
        <li>
            <span data-toggle="collapse" href="#adminGET" role="button" aria-expanded="false" aria-controls="adminGET" style="cursor: pointer;">
            GET api/admin
            </span>
            <div class="collapse codeAera" id="adminGET">
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                'id' : integer,<br>
                'name' : string,<br>
                'email' : string,<br>
                'api_token' : string<br>
                }
                </code>
            </div>
        </li>
        
        <!-- GET api/admin/all -->
        <li>
            <span data-toggle="collapse" href="#adminGETId" role="button" aria-expanded="false" aria-controls="adminGETId" style="cursor: pointer;">
            GET api/admin/all
            </span>
            <div class="collapse codeAera" id="adminGETId">
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }
                <hr>
                <p>RESPONSE:<br> array</p>
                [{<br>
                'id' : integer,<br>
                'name' : string,<br>
                'email' : string,<br>
                'api_token' : string<br>
                }]
                </code>
            </div>
        </li>
       
        <!-- POST api/admin -->
        <li>
            <span data-toggle="collapse" href="#adminPOST" role="button" aria-expanded="false" aria-controls="adminPOST" style="cursor: pointer;">
            POST api/admin
            </span>
            <div class="collapse codeAera" id="adminPOST">
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }<br>
                body: {<br>
                "name": string, <br>
                "email": string, <br>
                "role_id": int, <br>
                "permissions": int, <br>
                "password": string, <br>
                "password_confirmation": string<br>
                }
                <hr>
                <p>RESPONSE:<br> json</p>
                {<br>
                'id' : integer,<br>
                'name' : string,<br>
                'email' : string,<br>
                'api_token' : string<br>
                }
                </code>
            </div>
        </li>
        
        <!-- PUT api/admin/ -->
        <li>
            <span data-toggle="collapse" href="#adminPUT" role="button" aria-expanded="false" aria-controls="adminPUT" style="cursor: pointer;">
            PUT api/admin/
            </span>
            <div class="collapse codeAera" id="adminPUT">
            <p>To update admim information</p>
                <code>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }<br>
                body: {<br>
                "name": string,<br>
                "email": string, <br>
                }
                </code>
            </div>
        </li>
        
        <!-- DELETE api/admin/ -->
        <li>
            <span data-toggle="collapse" href="#adminDELETE" role="button" aria-expanded="false" aria-controls="adminDELETE" style="cursor: pointer;">
            DELETE api/admin/
            </span>
            <div class="collapse codeAera" id="adminDELETE">
                <code>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }
                </code>
            </div>
        </li>
        
        <!-- GET api/admin/cart/all -->
        <li>
            <span data-toggle="collapse" href="#adminCartAll" role="button" aria-expanded="false" aria-controls="adminCartAll" style="cursor: pointer;">
            GET api/admin/cart/all
            </span>
            <div class="collapse codeAera" id="adminCartAll">
                <code>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string<br>
                }
                </code>
            </div>
        </li>

        <!-- GET api/order/all -->
        <li>
            <span data-toggle="collapse" href="#adminOrderAll" role="button" aria-expanded="false" aria-controls="adminOrderAll" style="cursor: pointer;">
                GET api/order/all
            </span>
            <div class="collapse codeAera" id="adminOrderAll">
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
                    "total_price": integer,<br>
                    "user_id": integer,<br>
                    "stripe_payment_intent_id": string,<br>
                    "created_at": date,<br>
                    "updated_at": date,<br>
                    <b>"user"</b>:{<br>
                        "id": integer,<br>
                        "name": string,<br>
                        "email": string,<br>
                        "address": string,<br>
                        "city": string,<br>
                        "state": string,<br>
                        "zip": string,<br>
                        "email_verified_at": bool,<br>
                        "api_token": string,<br>
                        "created_at": date,<br>
                        "updated_at": date,<br>
                        <b>"shipping"</b>:[<br>
                            {<br>
                            "id": integer,<br>
                            "name": string,<br>
                            "email": string,<br>
                            "phone": string,<br>
                            "address": string,<br>
                            "zip": string,<br>
                            "city": string,<br>
                            "state": string,<br>
                            "created_at": date,<br>
                            "updated_at": date<br>
                            }]}}
                </code>
            </div>
        </li>
    </ul>
</div>
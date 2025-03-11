<h5 data-toggle="collapse" href="#ApiTokenMain" role="button" aria-expanded="false" aria-controls="ApiTokenMain" style="cursor: pointer;">API Token</h5>
<ul class="collapse" id="ApiTokenMain">

    <!-- GET /token -->    
    <li>
        <span data-toggle="collapse" href="#tokenAll" role="button" aria-expanded="false" aria-controls="tokenAll" style="cursor: pointer;">
        GET {{parse_url(route('token.all'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="tokenAll">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            [
                {<br>
                    "id": 0,<br>
                    "api_token": "string",<br>
                    "app_name": "string"<br>
                }
                ]
            </code>
        </div>
    </li>    

    <!-- GET /token/{token}-->    
    <li>
        <span data-toggle="collapse" href="#tokenShow" role="button" aria-expanded="false" aria-controls="tokenShow" style="cursor: pointer;">
        GET /api/token/{token}        </span>
        <div class="collapse codeAera" id="tokenShow">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                    "id": 0,<br>
                    "api_token": "string",<br>
                    "app_name": "string"<br>
                }
            </code>
        </div>
    </li>    

    <!-- POST /token -->    
    <li>
        <span data-toggle="collapse" href="#tokenStore" role="button" aria-expanded="false" aria-controls="tokenStore" style="cursor: pointer;">
        POST {{parse_url(route('token.store'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="tokenStore">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }<br>
            body: 
                {<br>
                    "app_name": "string"<br>
                }
            <hr>
            <p>RESPONSE:<br>json</p>
                {<br>
                    "id": 0,<br>
                    "api_token": "string",<br>
                    "app_name": "string"<br>
                }
            </code>
        </div>
    </li>    

    <!-- PUT /token/{token}-->    
    <li>
        <span data-toggle="collapse" href="#tokenUpdate" role="button" aria-expanded="false" aria-controls="tokenUpdate" style="cursor: pointer;">
        PUT /api/token/{token}        </span>
        <div class="collapse codeAera" id="tokenUpdate">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }<br>
            body: 
                {<br>
                    "app_name": "string"<br>
                }
            <hr>
            <p>RESPONSE:<br>json</p>
                {<br>
                    "id": 0,<br>
                    "api_token": "string",<br>
                    "app_name": "string"<br>
                }
            </code>
        </div>
    </li>    

    <!-- DELETE /token/{token}-->    
    <li>
        <span data-toggle="collapse" href="#tokenDelete" role="button" aria-expanded="false" aria-controls="tokenDelete" style="cursor: pointer;">
        DELETE /api/token/{token}
        </span>
        <div class="collapse codeAera" id="tokenDelete">
            <code>
            <p>REQUEST:<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string<br>
            }
            <hr>
            <p>RESPONSE:<br>json</p>
            {<br>
                'message' : 'Application token deleted successfully.'<br>
            }
            </code>
        </div>
    </li>    
</ul>
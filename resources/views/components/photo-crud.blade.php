<h5 data-toggle="collapse" href="#photoMain" role="button" aria-expanded="false" aria-controls="photoMain" style="cursor: pointer;">Photo</h5>
    <ul class="collapse" id="photoMain">
        <!-- Get all photos -->
        <li>
            <span data-toggle="collapse" href="#photoIndex" role="button" aria-expanded="false" aria-controls="photoIndex" style="cursor: pointer;">
            GET {{parse_url(route('photo.index'),PHP_URL_PATH)}}
            </span>

            <div class="collapse codeAera" id="photoIndex" >    
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string/Admin<br>
                }<br>
                <hr>
                <p>RESPONSE:<br>json</p>
                [
                    {<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name":"photos/xxxxxxx.xxxxx",<br>
                    "created_at": date,<br>
                    "updated_at": date<br>
                    }
                ]
                </code>
            </div>
        </li>

        <!-- Get a photo by ID -->
        <li>
            <span data-toggle="collapse" href="#photoShow" role="button" aria-expanded="false" aria-controls="photoShow" style="cursor: pointer;">
            GET api/photo/{photo_id}
            </span>

            <div class="collapse codeAera" id="photoShow" >    
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string/Admin<br>
                }<br>
                <hr>
                <p>RESPONSE:<br>json</p>
                    {<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name":"photos/xxxxxxx.xxxxx",<br>
                    "created_at": date,<br>
                    "updated_at": date<br>
                    }
                </code>
            </div>
        </li>

        <!-- Store Photo -->
        <li>
            <span data-toggle="collapse" href="#photoStore" role="button" aria-expanded="false" aria-controls="photoStore" style="cursor: pointer;">
            POST {{parse_url(route('photo.store'),PHP_URL_PATH)}}
            </span>

            <div class="collapse codeAera" id="photoStore" >    
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string/Admin<br>
                }<br>
                body: {<br>
                    "product_id" : integer,<br>
                    "file_name" : array <br>
                    }
                <hr>
                <p>RESPONSE:<br>json</p>
                    [{<br>
                    "id": integer,<br>
                    "product_id": integer,<br>
                    "file_name":"photos/xxxxxxx.xxxxx",<br>
                    "created_at": date,<br>
                    "updated_at": date<br>
                    }]
                </code>
            </div>
        </li>

        <!-- Update a photo by ID -->
        <li>
            <span data-toggle="collapse" href="#photoDelete" role="button" aria-expanded="false" aria-controls="photoDelete" style="cursor: pointer;">
            DELETE api/photo/{photo_id}
            </span>

            <div class="collapse codeAera" id="photoDelete" >    
                <code>
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER_API_KEY": string/Admin<br>
                }<br>
                <hr>
                <p>RESPONSE:<br>json</p>
                    {<br>
                        "message" : "Photo deleted successfully."<br>
                    }
                </code>
            </div>
        </li>
    </ul>
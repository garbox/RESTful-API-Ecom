<h5 data-toggle="collapse" href="#CategoryMain" role="button" aria-expanded="false" aria-controls="CategoryMain" style="cursor: pointer;">Category Type</h5>
<ul class="collapse" id="CategoryMain">
    <!-- GET /category -->
    <li>
        <span data-toggle="collapse" href="#categoryIndex" role="button" aria-expanded="false" aria-controls="categoryIndex" style="cursor: pointer;">
        GET {{parse_url(route('category.index'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="categoryIndex">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }
            <hr>
            <p>Response<br>json</p>
            [
            {<br>
                "id": integer,<br>
                "name":string,<br>
                "created_at":date ,<br>
                "updated_at": date<br>
            }]
            </code>
        </div>
    </li>
    <!-- GET /category/{category_id} -->
    <li>
        <span data-toggle="collapse" href="#categoryShow" role="button" aria-expanded="false" aria-controls="categoryShow" style="cursor: pointer;">
        GET api/category/{category_id}
        </span>
        <div class="collapse codeAera" id="categoryShow">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }
            <hr>
            <p>Response<br>json</p>
            {<br>
                "id": integer,<br>
                "name":string,<br>
                "created_at":date ,<br>
                "updated_at": date<br>
            }
            </code>
        </div>
    </li>
    <!-- GET /category/{category_id}/products -->
    <li>
        <span data-toggle="collapse" href="#categoryProducts" role="button" aria-expanded="false" aria-controls="categoryProducts" style="cursor: pointer;">
        GET api/category/{categoryId}/products
        </span>
        <div class="collapse codeAera" id="categoryProducts">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }
            <hr>
            <p>Response<br>json</p>
            [{ <br>
                "id": integer, <br>
                "name": string, <br>
                "short_description": string, <br>
                "price": integer, <br>
                "category_id": integer, <br>
                "long_description": string, <br>
                "featured": integer, <br>
                "available": integer, <br>
                "created_at": date, <br>
                "updated_at": date <br>
            }]
            </code>
        </div>
    </li>
    <!-- PUT /category/{category_id} -->
    <li>
        <span data-toggle="collapse" href="#categoryUpdate" role="button" aria-expanded="false" aria-controls="categoryUpdate" style="cursor: pointer;">
        PUT api/category/{category_id}
        </span>
        <div class="collapse codeAera" id="categoryUpdate">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }<br>
            body: {<br>
            "name":string<br>
            }
            <hr>
            <p>Response<br>json</p>
            {<br>
                "id": integer,<br>
                "name":string,<br>
                "created_at":date ,<br>
                "updated_at": date<br>
            }
            </code>
        </div>
    </li>
    <!-- POST /category -->
    <li>
        <span data-toggle="collapse" href="#categoryStore" role="button" aria-expanded="false" aria-controls="categoryStore" style="cursor: pointer;">
        POST {{parse_url(route('category.store'),PHP_URL_PATH)}}
        </span>
        <div class="collapse codeAera" id="categoryStore">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }<br>
            body: {<br>
            "name":string<br>
            }
            <hr>
            <p>Response<br>json</p>
            {<br>
                "id": integer,<br>
                "name":string,<br>
                "created_at":date ,<br>
                "updated_at": date<br>
            }
            </code>
        </div>
    </li>
    <!-- DELETE /category/{category_id} -->
    <li>
        <span data-toggle="collapse" href="#categoryDestroy" role="button" aria-expanded="false" aria-controls="categoryDestroy" style="cursor: pointer;">
        DELETE /category/{category_id}
        </span>
        <div class="collapse codeAera" id="categoryDestroy">
            <code>
            <p>Request<br>json</p>
            headers: {<br>
            "GLOBAL-API-KEY" : string,<br>
            "USER_API_KEY": string/Admin<br>
            }<br>
            body: {<br>
            "id": integer<br>
            }
            <hr>
            <p>Response<br>json</p>
            {<br>
                'message' : 'Category was deleted successfully.'
            }
            </code>
        </div>
    </li>
</ul>
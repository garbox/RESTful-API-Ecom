<h5 data-toggle="collapse" href="#cartMain" role="button" aria-expanded="false" aria-controls="cartMain" style="cursor: pointer;">Cart</h5>
                <ul class="collapse" id="cartMain">
                  
                <!-- GET api/cart/session/{session_id} -->
                  <li>
                    <span data-toggle="collapse" href="#cartSession" role="button" aria-expanded="false" aria-controls="cartSession" style="cursor: pointer;">
                      GET api/cart/session/{session_id}
                    </span>
                    <div class="collapse codeAera" id="cartSession">
                      <code>
                        <p>REQUEST:<br>json</p>
                        headers: {<br>
                          "GLOBAL-API-KEY" : string,<br>
                          "USER_API_KEY": string<br>
                        }<br>
                        body:{<br>
                          "session_id" : string<br>
                        }                      <hr>
                        <p>RESPONSE:<br> json</p>
                        {<br>
                          "id" : integer,<br>
                          "user_id" : id|nullable,<br>
                          "product_id" : id,<br>
                          "session_id" : string,<br>
                          "quantity" : int<br>
                        }<br><br>
                        user_id will be null untill an accound has been created. 
                      </code>
                    </div>
                  </li>

                  <!-- GET api/cart/user -->
                  <li>
                    <span data-toggle="collapse" href="#cartUser" role="button" aria-expanded="false" aria-controls="cartUser" style="cursor: pointer;">
                      GET api/cart/user
                    </span>
                    <div class="collapse codeAera" id="cartUser">
                      <code>
                        <p>REQUEST:<br>json</p>
                        headers: {<br>
                          "GLOBAL-API-KEY" : string,<br>
                          "USER_API_KEY": string<br>
                        }<br>
                        <hr>
                        <p>RESPONSE:<br> json</p>
                        {<br>
                        "id":2,<br>
                        "name": string,<br>
                        "email": string,<br>
                        "address": string,<br>
                        "city": string,<br>
                        "state": string,<br>
                        "zip": int,<br>
                        "api_token": string,<br>
                        <b>"carts"</b>: array[<br></span> 
                          "id": int,<br> 
                          "session_id": string,<br> 
                          "quantity": int,<br> 
                          <b>"product"</b>:{<br> 
                              "id": int,<br> 
                              "name": string,<br> 
                              "price": int,<br> 
                              "featured": int,<br> 
                              "available": int,<br> 
                              "category":{<br> 
                                "id": int,<br> 
                                "name": string <br> 
                              }<br>]<br>}<br>}
                      </code>
                    </div>
                  </li>

                  <!-- POST api/cart -->
                  <li>
                    <span data-toggle="collapse" href="#adminPOST" role="button" aria-expanded="false" aria-controls="adminPOST" style="cursor: pointer;">
                      POST api/cart
                    </span>
                    <div class="collapse codeAera" id="adminPOST">
                    <code>
                      <p>REQUEST:<br>json</p>
                      headers: {<br>
                        "GLOBAL-API-KEY" : string,<br>
                        "USER_API_KEY": string<br>
                      }<br>
                      body:{<br>
                          "product_id" : int,<br>
                          "quantity" : int,<br>
                          "session_id" : string|nullable<br>
                      }<br><br>
                      if no session_id provided, one will be created and returned to client side.

                      <hr>
                      <p>RESPONSE:<br> json</p>
                      {<br>
                        'id' : integer,<br>
                        'user_id' : id|nullable,<br>
                        'product_id' : id,<br>
                        'session_id' : string<br>
                        'quantity' : int<br>
                      }<br><br>
                      user_id will be null untill an account has been created. 
                    </code>
                    </div>
                  </li>

                  <!-- PUT api/cart -->
                  <li>
                    <span data-toggle="collapse" href="#cartUpdate" role="button" aria-expanded="false" aria-controls="cartUpdate" style="cursor: pointer;">
                      PUT api/cart
                    </span>
                    <div class="collapse codeAera" id="cartUpdate">
                    <code>
                      <p>REQUEST:<br>json</p>
                      headers: {<br>
                        "GLOBAL-API-KEY" : string,<br>
                        "USER_API_KEY": string<br>
                      }<br>
                      body:{<br>
                          "cart_id" : int,<br>
                          "quantity" : int,<br>
                      }                      <hr>
                      <p>RESPONSE:<br> json</p>
                      {<br>
                        'id' : integer,<br>
                        'user_id' : id|nullable,<br>
                        'product_id' : id,<br>
                        'session_id' : string<br>
                        'quantity' : int<br>
                      }<br><br>
                      user_id will be null untill an accound has been created. 
                    </code>
                    </div>
                  </li>

                  <!-- DELETE api/cart/{cart_id} -->
                  <li>
                    <span data-toggle="collapse" href="#cartDelete" role="button" aria-expanded="false" aria-controls="cartDelete" style="cursor: pointer;">
                      DELETE api/cart/{cart_id}
                    </span>
                    <div class="collapse codeAera" id="cartDelete">
                    <code>
                      <p>REQUEST:<br>json</p>
                      headers: {<br>
                        "GLOBAL-API-KEY" : string,<br>
                        "USER_API_KEY": string<br>
                      }<br>
                      <hr>
                      <p>RESPONSE:<br> json</p>
                      {<br>
                        "message" => 'Cart has been deleted successfully.'
                      }
                    </code>
                    </div>
                  </li>
                
                </ul>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce API Sandbox</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .result-section {
      margin-top: 30px;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f8f9fa;
    }
    .api-url-list {
      margin-top: 30px;
      max-height: 400px; /* Set a max height */
      overflow-y: auto;  /* Enable vertical scrolling */
      padding-right: 15px; /* Add space for scrollbar */
    }
    .api-url-list ul {
      list-style-type: none;
      padding-left: 0;
    }
    .api-url-list ul li {
      padding: 5px 0;
    }
   code {
      font-family: Consolas, "Courier New", monospace;
      font-size: 14px;
      color: black;
  }
  .codeAera {
    background-color:rgb(240, 240, 240);
  }
  </style>
</head>
<body>

  <div class="container my-5">
    <div class="row">

      <!-- Left Column (API URL List) -->
      <div class="col-md-6">
        <div class="api-url-list">
          <h3>Available API URLs</h3>
          <div class="row">

            <!-- Column 1 -->
            <div class="col-md-6">

              <!-- Admin -->
              <h5 data-toggle="collapse" href="#adminMain" role="button" aria-expanded="false" aria-controls="adminMain" style="cursor: pointer;">Admin</h5>
                <ul class="collapse" id="adminMain">
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
                </ul>

              <!-- Cart -->
              <h5 data-toggle="collapse" href="#cartMain" role="button" aria-expanded="false" aria-controls="cartMain" style="cursor: pointer;">Cart</h5>
                <ul class="collapse" id="cartMain">
                  
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
                  <li>
                    <span data-toggle="collapse" href="#cartUpdate" role="button" aria-expanded="false" aria-controls="cartUpdate" style="cursor: pointer;">
                      PUT api/cart/{cart_id}
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
              
              <!-- Order -->
              <h5 data-toggle="collapse" href="#orderMain" role="button" aria-expanded="false" aria-controls="orderMain" style="cursor: pointer;">Order</h5>
                <ul class="collapse" id="orderMain">
                  <li>GET /order</li>
                  <li>GET /order/{order}</li>
                  <li>GET /order/user/{user_id}</li>
                  <li>POST /order</li>
                  <li>PUT /order/{order_id}</li>
                  <li>DELETE /order/{order_id}</li>
                </ul>

              <!-- PRoduct Type -->
              <h5 data-toggle="collapse" href="#prodTypeMain" role="button" aria-expanded="false" aria-controls="prodTypeMain" style="cursor: pointer;">Product Type</h5>
                  <ul class="collapse" id="prodTypeMain">
                    <li>GET /prodType</li>
                    <li>GET /prodType/{prodType_id}</li>
                    <li>GET /prodtype/{prodTypeId}/products</li>
                    <li>PUT /prodType/{prodType_id}</li>
                    <li>POST /prodType</li>
                    <li>DELETE /prodType/{prodType_id}</li>
                  </ul>
              
              <!-- Photo -->
              <h5 data-toggle="collapse" href="#photoMain" role="button" aria-expanded="false" aria-controls="photoMain" style="cursor: pointer;">Photo</h5>
                <ul class="collapse" id="photoMain">
                  <li>GET /photo</li>
                  <li>GET /photo/{photo_id}</li>
                  <li>POST /photo</li>
                  <li>DELETE /photo/{photo_id}</li>
                </ul>
            </div>

            <!-- Column 2 -->
            <div class="col-md-6">
              <!-- Product -->
              <h5 data-toggle="collapse" href="#productMain" role="button" aria-expanded="false" aria-controls="productMain" style="cursor: pointer;">Product</h5>
                <ul class="collapse" id="productMain">
                    <li>GET /product</li>
                    <li>GET /product/{product_id}</li>
                    <li>GET /product/search/{search}</li>
                    <li>GET /product/available</li>
                    <li>GET /product/featured</li>
                    <li>GET /product/{productId}/productType</li>
                    <li>POST /product</li>
                    <li>PUT /product/{product_id}</li>
                    <li>DELETE /product/{product_id}</li>
                </ul>

              <!-- Shipping -->
              <h5 data-toggle="collapse" href="#shippingMain" role="button" aria-expanded="false" aria-controls="shippingMain" style="cursor: pointer;">Shipping</h5>
                <ul class="collapse" id="shippingMain">
                  <li>GET /shipping</li>
                  <li>GET /shipping/{shipping_id}</li>
                  <li>POST /shipping</li>
                  <li>PUT /shipping/{shipping_id}</li>
                  <li>DELETE /shipping/{shipping_id}</li>
                </ul>
              
              <!-- API Token -->
              <h5 data-toggle="collapse" href="#ApiTokenMain" role="button" aria-expanded="false" aria-controls="ApiTokenMain" style="cursor: pointer;">API Token</h5>
                <ul class="collapse" id="ApiTokenMain">
                  <li>GET /token</li>
                  <li>GET /token/{token}</li>
                  <li>POST /token</li>
                  <li>PUT /token/{token}</li>
                  <li>DELETE /token/{token}</li>
                </ul>
                
              <!-- User -->
              <h5 data-toggle="collapse" href="#userMain" role="button" aria-expanded="false" aria-controls="userMain" style="cursor: pointer;">User</h5>
                <ul class="collapse" id="userMain">
                  <li>GET /user</li>
                  <li>GET /user/{user_id}</li>
                  <li>GET /user/{user_id}/cart</li>
                  <li>GET /user/{user_id}/orders</li>
                  <li>GET /user/{user_id}/shipping</li>
                  <li>GET /user/{user_id}/totalSale</li>
                  <li>POST /user</li>
                  <li>PUT /user/{user_id}</li>
                  <li>DELETE /user/{user_id}</li>
                </ul>
            </div>

          </div>
        </div>
      </div>

      <!-- Right Column (Form) -->
      <div class="col-md-6">
        <h2>Submit Your Data</h2>

        <!-- Form -->
        <form id="dataForm">
          <div class="mb-3">
            <label for="method" class="form-label">Method</label>
            <select class="form-select" id="method" required>
              <option value="" disabled selected>Select Method</option>
              <option value="GET">GET</option>
              <option value="POST">POST</option>
              <option value="PUT">PUT</option>
              <option value="DELETE">DELETE</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="app_token" class="form-label">Global API Token</label>
            <input type="text" class="form-control" id="app_token">
          </div>

          <div class="mb-3">
            <label for="user_token" class="form-label">User API Token</label>
            <input type="text" class="form-control" id="user_token">
          </div>

          <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" rows="4"></textarea>
          </div>

          <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="text" class="form-control" id="url" placeholder="Enter URL" required>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

    <!-- Data Display Section -->
    <div id="resultSection" class="result-section mt-5" style="display: none;">
      <h4>Submitted Data</h4>
      <p><strong>Method:</strong> <span id="resultMethod"></span></p>
      <p><strong>URL:</strong> <span id="resultURL"></span></p>
      <p><strong>Body:</strong> <span id="resultBody"></span></p>
    </div>

  </div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
document.getElementById('dataForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const method = document.getElementById('method').value;
  const bodyInput = document.getElementById('body').value; // Get the body input
  const url = '{{url('')}}/' + document.getElementById('url').value;
  const token = document.getElementById('app_token').value;
  const userToken = document.getElementById('user_token').value;

  // Show the selected method and URL in the result section
  document.getElementById('resultMethod').textContent = method;
  document.getElementById('resultURL').textContent = url;

  let headers = {
    'Content-Type': 'application/json',
    'GLOBAL-API-KEY': token,
    'USER-API-KEY': userToken,
  };

  const fetchOptions = {
    method: method,
    headers: headers,
  };

  // Handle the body for POST or PUT methods
  if (method === 'POST' || method === 'PUT') {
    try {
      // Try parsing the body input to ensure it's valid JSON
      fetchOptions.body = JSON.stringify(JSON.parse(bodyInput));
    } catch (error) {
      alert("Error parsing the body content. Please ensure it's valid JSON.");
      return;
    }
  } else {
    // For GET or other methods, make sure no body is sent
    delete fetchOptions.body;
  }

  // Fetch the API data
  fetch(url, fetchOptions)
    .then(response => {
      // Check if the response is not ok (status code other than 200-299)
      if (!response.ok) {
        return response.json().then(errorData => {
          // Throw an error with details from the server response
          throw new Error(`Error ${response.status}: ${errorData.message || 'Unknown error'}`);
        });
      }
      return response.json(); // If the response is OK, parse it as JSON
    })
    .then(data => {
      document.getElementById('resultSection').style.display = 'block';
      document.getElementById('resultBody').textContent = JSON.stringify(data, null, 2);
    })
    .catch(error => {
      // Show detailed error message
      document.getElementById('resultSection').style.display = 'block';
      document.getElementById('resultBody').textContent = `Error fetching data: ${error.message}`;

      // Log the full error in the console for debugging
      console.error('Full error details:', error);
    });
});

  </script>

</body>
</html>

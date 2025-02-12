<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel API Form</title>
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
              <h5>Admin</h5>
              <ul>
                <li>GET /admin</li>
                <li>GET /admin/{admin_id}</li>
                <li>POST /admin</li>
                <li>PUT /admin/{admin_id}</li>
                <li>DELETE /admin/{admin_id}</li>
              </ul>
              <h5>Cart</h5>
              <ul>
                <li>GET /cart</li>
                <li>GET /cart/session/{session_id}</li>
                <li>GET /cart/user/{user_id}</li>
                <li>POST /cart</li>
                <li>PUT /cart/{cart_id}</li>
                <li>DELETE /cart/{cart_id}</li>
              </ul>
              <h5>Order</h5>
              <ul>
                <li>GET /order</li>
                <li>GET /order/{order}</li>
                <li>GET /order/user/{user_id}</li>
                <li>POST /order</li>
                <li>PUT /order/{order_id}</li>
                <li>DELETE /order/{order_id}</li>
              </ul>
              <h5>Product Type</h5>
              <ul>
                <li>GET /prodType</li>
                <li>GET /prodType/{prodType_id}</li>
                <li>GET /prodtype/{prodTypeId}/products</li>
                <li>PUT /prodType/{prodType_id}</li>
                <li>POST /prodType</li>
                <li>DELETE /prodType/{prodType_id}</li>
              </ul>
              <h5>Photo</h5>
              <ul>
                <li>GET /photo</li>
                <li>GET /photo/{photo_id}</li>
                <li>POST /photo</li>
                <li>DELETE /photo/{cart_id}</li>
              </ul>
            </div>
            <!-- Column 2 -->
            <div class="col-md-6">
              <h5>Product</h5>
              <ul>
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
              <h5>Shipping</h5>
              <ul>
                <li>GET /shipping</li>
                <li>GET /shipping/{shipping_id}</li>
                <li>POST /shipping</li>
                <li>PUT /shipping/{shipping_id}</li>
                <li>DELETE /shipping/{shipping_id}</li>
              </ul>
              <h5>API Tokens</h5>
              <ul>
                <li>GET /token</li>
                <li>GET /token/{token}</li>
                <li>POST /token</li>
                <li>PUT /token/{token}</li>
                <li>DELETE /token/{token}</li>
              </ul>
              <h5>User</h5>
              <ul>
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
            <label for="token" class="form-label">API Token</label>
            <input type="text" class="form-control" id="token">
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

  <!-- Bootstrap JS and Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

  <script>
    // Handle form submission
    document.getElementById('dataForm').addEventListener('submit', function(event) {
      event.preventDefault();

      // Get the form data
      const method = document.getElementById('method').value;
      const bodyInput = document.getElementById('body').value; // Get the body input
      const url = '{{url('')}}/api/' + document.getElementById('url').value;
      const token = document.getElementById('token').value;
      

      // Display the submitted method and URL
      document.getElementById('resultMethod').textContent = method;
      document.getElementById('resultURL').textContent = url;

      // Initialize the headers with prefilled values
      let headers = {
        'Content-Type': 'application/json',
        'X-API-KEY': token,
      };

      // Prepare the fetch options
      const fetchOptions = {
        method: method,
        headers: headers,
      };

      // If method is POST or PUT, include the body from the textarea
      if (method === 'POST' || method === 'PUT') {
        try {
          // Attempt to parse and add the body content as JSON
          fetchOptions.body = JSON.stringify(JSON.parse(bodyInput)); // Convert body to JSON
        } catch (error) {
          // If JSON parsing fails, alert the user and stop the process
          alert("Error parsing the body content. Please ensure it's valid JSON.");
          return;
        }
      }

      // Fetch data from the provided URL
      fetch(url, fetchOptions)
        .then(response => response.json()) // Assuming the API returns JSON data
        .then(data => {
          // Display the response in the result section
          document.getElementById('resultSection').style.display = 'block';
          document.getElementById('resultBody').textContent = JSON.stringify(data, null, 2); // Beautify the JSON data
        })
        .catch(error => {
          // Display an error message in case of failure
          document.getElementById('resultSection').style.display = 'block';
          document.getElementById('resultBody').textContent = "Error fetching data: " + error.message;
        });
    });
  </script>

</body>
</html>

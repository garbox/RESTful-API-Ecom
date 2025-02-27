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
  <p><b>App API Key:</b> {{$appToken->api_token}}</p>
  <p><b>Admin API Key:</b> {{$adminToken->api_token}}</p>
  <p><b>User API Key:</b> {{$userToken->api_token}}</p>
</div>
    <div class="row">

      <!-- Left Column (API URL List) -->
      <div class="col-md-6">
        <div class="api-url-list">
          <h3>Available API URLs</h3>
          <div class="row">

            <!-- Column 1 -->
            <div class="col-md-6">

              <!-- Admin -->
              <x-AdminCrud/>

              <!-- Cart -->
              <x-CartCrud/>
              
              <!-- Order -->
              <x-OrderCrud/>

              <!-- Category  -->
              <x-CategoryCrud/>
              
              <!-- Photo -->
              <x-PhotoCrud/>

            </div>

            <!-- Column 2 -->
            <div class="col-md-6">

              <!-- Product -->
              <x-ProductCrud/>

              <!-- Shipping -->
              <x-ShippingCrud/>
              
              <!-- API Token -->
              <x-TokenCrud/>
                
              <!-- User -->
              <x-UserCrud/>

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

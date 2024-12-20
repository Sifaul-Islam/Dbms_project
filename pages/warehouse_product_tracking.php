<?php 

include "./db.php";

$sql = "SELECT 
    p.name AS Product_Name,
    f.farmname AS Farm_Name,
    w.warehousename AS Warehouse_Name,
    f.location AS Farm_Location,
    w.location AS Warehouse_Location,
    d.address AS Distributor_Address,
    bt.transferdate AS Transfer_Date
FROM 
    batchtransfer bt
JOIN 
    harvestbatch hb ON bt.lotnumber = hb.lotnumber
JOIN 
    farm f ON hb.farmID = f.farmID
JOIN 
    product p ON hb.productID = p.productID
JOIN 
    warehouse w ON bt.warehouseID = w.warehouseID
JOIN 
    distributor d ON w.distributorID = d.distributorID;
";

$result = $conn->query($sql);

?>


<!--delete -->
<?php
if (isset($_GET['Product_Name'])) {
    $Product_Name = $_GET['Product_Name'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'safe_food_traceability');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete the record
    $sql = "DELETE FROM batchpackagedetails WHERE Product_Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Product_Name);

    if ($stmt->execute()) {
        header("Location: https://localhost/Dbms_project/pages/warehouse_product_tracking.php?success=1");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>পণ্য ট্র্যাকিং - Product Tracking</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <!-- Leaflet CSS (for the map) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            background-color: #f5f5f5;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        .container {
            margin: 20px;
        }
    </style>  
  



  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" target="_blank">
                <img src="../Know Your Grass/kng1.png" class="navbar-brand-img h-100" alt="main_logo">
                
            </a>
        </div>
    
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: auto;">
            <ul class="navbar-nav">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="../Know Your Grass/warehouse_manager_dashboard.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tachometer-alt text-primary"></i>
                        </div>
                        <span class="nav-link-text ms-1">ড্যাশবোর্ড</span>
                    </a>
                </li>
    
                <!-- Inventory Management -->
                 <li class="nav-item">
                    <a class="nav-link" href="warehouse_management.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-warehouse text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুদাম ব্যবস্থাপনা</span>
                    </a>
                </li> 
    
                <!-- Storage Conditions -->
                <li class="nav-item">
                    <a class="nav-link" href="warehouse_storage.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-thermometer-half text-primary"></i>
                        </div>
                        <span class="nav-link-text ms-1">সংরক্ষণ অবস্থা</span>
                    </a>
                </li>
    
                <!-- Quality Control -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="warehouse_quality_verification.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-check-circle text-danger"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুণমান যাচাইকরণ</span>
                    </a>
                </li> -->

                <!-- Product Tracking -->
                <li class="nav-item">
                    <a class="nav-link active" href="warehouse_product_tracking.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-route text-warning"></i>
                        </div>
                        <span class="nav-link-text ms-1">পণ্য ট্র্যাকিং</span>
                    </a>
                </li>
    
                <!-- Data Reports -->
                <li class="nav-item">
                    <a class="nav-link" href="warehouse_report.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-chart-bar text-secondary"></i>
                        </div>
                        <span class="nav-link-text ms-1">প্রতিবেদন এবং বিশ্লেষণ</span>
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../Know Your Grass/login.html">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                           <i class="fas fa-sign-out-alt text-danger"></i>
                      </div>
                      <span class="nav-link-text ms-1">লগ আউট</span>                        
                  </a>    
              </li>
            </ul>
        </div>
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">পৃষ্ঠা</a></li>
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">ড্যাশবোর্ড</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">পণ্য ট্র্যাকিং</h6>
              </nav>
              <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                  <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="এখানে টাইপ করুন...">
                  </div>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid py-4">
            <!-- Product Tracking Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>পণ্যের তালিকা</h6>
                            <a class="btn btn-sm btn-success" href="addwpt.php">নতুন পণ্য যোগ করুন</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">পণ্যের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">খামারের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">গুদামের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">উৎস</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">বর্তমান অবস্থান</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">গন্তব্য</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">তারিখ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Farm_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Warehouse_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Farm_Location']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Warehouse_Location']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Distributor_Address']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Transfer_Date']; ?></td>

        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
        
        

        <a class="btn btn-sm btn-primary edit-btn" href="updatwpt.php?Product_Name=<?php echo $row['Product_Name']; ?>">
            সম্পাদনা
        </a>
        <button 
            class="btn btn-danger btn-sm text-center" 
             
            onclick="confirmDelete('<?php echo $row['Product_Name']; ?>')">
            মুছে ফেলুন
        </button>
    

        </td>


        </tr>                       

<?php   }
}
$conn->close();

?>
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Pie Chart and Map for Product Tracking Summary -->
<!-- Row for Product Tracking Summary with Map -->
<div class="container-fluid py-4">
            <!-- Product Tracking Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4"></div> 
    <div class="row mt-4">
        <!-- Pie Chart for Product Tracking Summary -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>পণ্য ট্র্যাকিং সারাংশ</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="productTrackingChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Map beside the Pie Chart -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>পণ্য ট্র্যাকিং মানচিত্র</h6>
                </div>
                <div class="card-body p-3">
                    <div id="map" style="height: 500; "></div>
                </div>
            </div>
        </div>
    </div>

<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">পণ্য মুছে ফেলুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>আপনি কি নিশ্চিত যে আপনি এই আইটেমটি মুছে ফেলতে চান?</p>
                <p id="deleteProductMessage" class="text-danger"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <a id="confirmDeleteButton" class="btn btn-sm btn-danger" href="#">মুছে ফেলুন</a>
            </div>
        </div>
    </div>
</div>

<!-- Script to handle deletion -->
<script>
    // Function to set up delete confirmation
    function confirmDelete(Product_Name, productName) {
        // Set the confirmation message
        // document.getElementById('deleteProductMessage').textContent = `আইটেম: ${productName} (বারকোড: ${Product_Name})`;
        
        // Set the delete link with the correct Product_Name
        const deleteUrl = `https://localhost/Dbms_project/pages/warehouse_report.php?Product_Name=${Product_Name}`;
        document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        deleteModal.show();
    }
</script>



<script>
        var map = ap('map').setView([37.7749, -122.4194], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([37.7749, -122.4194]).addTo(map)
            .bindPopup('San Francisco')
            .openPopup();
    </script>

    <!-- Leaflet JS and Map Initialization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([23.685, 90.3563], 6); // Centered on Bangladesh
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add markers for cities
        var locations = [
            { name: "ঢাকা", coords: [23.8103, 90.4125] },
            { name: "চট্টগ্রাম", coords: [22.3569, 91.7832] },
            { name: "খুলনা", coords: [22.8456, 89.5403] },
            { name: "বরিশাল", coords: [22.7010, 90.3535] }
        ];

        locations.forEach(location => {
            L.marker(location.coords).addTo(map)
                .bindPopup(location.name);
        });
    </script>


    </main>

    
    <!-- JS Scripts -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    <script>
        function populateEditModal(name, rfid, status, source, date) {
            document.getElementById('editTrackingProductName').value = name;
            document.getElementById('editTrackingRFID').value = rfid;
            document.getElementById('editTrackingStatus').value = status;
            document.getElementById('editTrackingSource').value = source;
            document.getElementById('editTrackingDate').value = date;
        }

        // Product Tracking Pie Chart
        var ctxProductTrackingChart = document.getElementById('productTrackingChart').getContext('2d');
        new Chart(ctxProductTrackingChart, {
          type: 'pie',
          data: {
            labels: ['আসন্ন', 'গুদামে', 'বিতরণ করা হয়েছে'],
            datasets: [{
              data: [30, 50, 20],
              backgroundColor: [
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true
          }
        });
    </script>
    
</body>

</html>
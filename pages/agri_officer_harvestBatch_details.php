<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
   SELECT 
    p.name AS `Product Name`,
    f.farmname AS `Farm Name`,
    hb.lotnumber AS `Lot Number`,
    hb.`harvest date` AS `Harvest Date`,
    hb.`productiondate` AS `Production Date`
FROM 
    harvestbatch hb
JOIN 
    farm f ON hb.farmID = f.farmID
JOIN 
    product p ON hb.productID = p.productID;


";

$result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ড্যাশবোর্ড - Agri Officer </title>

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
              <img src="kng1.png" class="navbar-brand-img h-100" alt="main_logo">
          </a>
      </div>
  
      <hr class="horizontal dark mt-0">
      <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" href="../Know Your Grass/agri_officer_dashboard.html">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="fas fa-tachometer-alt text-primary"></i>
                      </div>
                      <span class="nav-link-text ms-1">কৃষি অফিসার ড্যাশবোর্ড</span>
                  </a>
              </li>
  
              <li class="nav-item">
                  <a class="nav-link" href="../pages/agri_officer_add_product.php">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="fas fa-seedling text-warning"></i>
                      </div>
                      <span class="nav-link-text ms-1">পণ্যের তথ্য যোগ</span>
                  </a>
              </li>
  
              <li class="nav-item">
                  <a class="nav-link" href="../pages/track_product_update.html">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="fas fa-truck text-info"></i>
                      </div>
                      <span class="nav-link-text ms-1">পণ্য ট্র্যাক</span>
                  </a>
              </li>

              <li class="nav-item">
                <a class="nav-link active" href="../pages/agri_officer_harvestBatch_details.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <span class="nav-link-text ms-1">ব্যাচের বিবরণ যোগ</span>
                </a>
            </li>
  
              <li class="nav-item">
                  <a class="nav-link" href="../pages/agri_add_affected_batches_details.php">
                      <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                          <i class="fas fa-exclamation-triangle text-danger"></i>
                      </div>
                      <span class="nav-link-text ms-1">প্রভাবিত ব্যাচের বিবরণ যোগ</span>
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
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">কৃষি অফিসার</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">ব্যাচের বিবরণ যোগ</h6>
              </nav>
            </div>
        </nav>
        
        <div class="container-fluid py-4">
            <!-- Inventory Management Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>ব্যাচের তালিকা</h6>
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">নতুন পণ্য যোগ করুন</button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্যের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">খামারের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">লট নম্বর</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">আগমনের তারিখ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">প্যাকেজিং তারিখ</th>
                                            <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th> -->
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ব্যাচের বিবরণ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Farm Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Lot Number']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Harvest Date']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Production Date']; ?></td>
        <td class="align-middle">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewdetail" onclick="">বিবরণ</button>
        </td>

        

        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;"></div>

        <td>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" >সম্পাদনা</button>
          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal" >মুছে ফেলুন</button>
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
        </div>


        <script>
            var map = L.map('map').setView([37.7749, -122.4194], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker([37.7749, -122.4194]).addTo(map)
                .bindPopup('San Francisco')
                .openPopup();
        </script>
                <!-- Pie Chart and Map for Product Tracking Summary -->
        <!-- Row for Product Tracking Summary with Map -->
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

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">নতুন ব্যাচ যোগ করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="productName" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">খামারের নাম</label>
                            <input type="text" class="form-control" id="productStock">
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">লট নম্বর</label>
                            <input type="text" class="form-control" id="productStock">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="productCondition" class="form-label">লট নম্বর</label>
                            <select class="form-control" id="productCondition">
                                <option value="ভাল">ভাল</option>
                                <option value="মধ্যম">মধ্যম</option>
                                <option value="খারাপ">খারাপ</option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="productHumidity" class="form-label">আগমনের তারিখ</label>
                            <input type="date" class="form-control" id="productHumidity">
                        </div>
                        <div class="mb-3">
                            <label for="productTemperature" class="form-label">প্যাকেজিং তারিখ</label>
                            <input type="date" class="form-control" id="productTemperature">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">ব্যাচ সম্পাদনা করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="productName" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">খামারের নাম</label>
                            <input type="text" class="form-control" id="productStock">
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">লট নম্বর</label>
                            <input type="text" class="form-control" id="productStock">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="productCondition" class="form-label">লট নম্বর</label>
                            <select class="form-control" id="productCondition">
                                <option value="ভাল">ভাল</option>
                                <option value="মধ্যম">মধ্যম</option>
                                <option value="খারাপ">খারাপ</option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="productHumidity" class="form-label">আগমনের তারিখ</label>
                            <input type="date" class="form-control" id="productHumidity">
                        </div>
                        <div class="mb-3">
                            <label for="productTemperature" class="form-label">প্যাকেজিং তারিখ</label>
                            <input type="date" class="form-control" id="productTemperature">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">ব্যাচ মুছে ফেলুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteProductMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-danger">মুছে ফেলুন</button>
                </div>
            </div>
        </div>
    </div>




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
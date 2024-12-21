<?php

include "./db.php";

$sql = "
    SELECT 
        s.roomNo AS `Storage_Room`,
        GROUP_CONCAT(DISTINCT p.name ORDER BY p.name ASC) AS `Products`,
        s.temperature AS `Temperature`,
        s.humidity AS `Humidity`,
        s.timestamp AS `Time_Stamp`,
        CONCAT(
            'Oxygen: ', IFNULL(s.oxygen, 'N/A'), '<br>',
            'Light Intensity: ', IFNULL(s.`light intensity`, 'N/A')
        ) AS `Details`
    FROM 
        sensor s
    JOIN 
        warehouse w ON s.warehouseID = w.warehouseID
    JOIN 
        harvestbatch hb ON w.lotnumber = hb.lotnumber
    JOIN 
        product p ON hb.productID = p.productID
    GROUP BY 
        s.roomNo
    LIMIT 25
";

$result = $conn->query($sql);

?>

<!--delete -->
<?php
if (isset($_GET['Storage_Room'])) {
    $Storage_Room = $_GET['Storage_Room'];

    // Sanitize the input
    $Storage_Room = htmlspecialchars($Storage_Room);

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'safe_food_traceability');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete the record from the 'sensor' table (based on roomNo)
    $sql = "DELETE FROM sensor WHERE roomNo = ?";
    
    // Prepare the query
    $stmt = $conn->prepare($sql);
    
    // Bind the parameter
    $stmt->bind_param("s", $Storage_Room);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: warehouse_storage.php");
        exit;
    } else {
        // Error deleting the record
        echo "Error deleting record: " . $conn->error;
    }

    // Close the statement and connection
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
  <title>সংরক্ষণ অবস্থা - Warehouse Status</title>

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
                    <a class="nav-link" href="warehouse_management.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-warehouse text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুদাম ব্যবস্থাপনা</span>
                    </a>
                </li>
    
                <!-- Storage Conditions -->
                <li class="nav-item">
                    <a class="nav-link active" href="warehouse_storage.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-thermometer-half text-primary"></i>
                        </div>
                        <span class="nav-link-text ms-1">সংরক্ষণ অবস্থা</span>
                    </a>
                </li>
    
                

                <!-- Product Tracking -->
                <li class="nav-item">
                    <a class="nav-link" href="warehouse_product_tracking.php">
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
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">সংরক্ষণ অবস্থা</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">সংরক্ষণ অবস্থা</h6>
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
                            <a class="btn btn-sm btn-success" href="addstorage.php">নতুন পণ্য যোগ করুন</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">সংরক্ষণ কক্ষ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">পণ্যসমূহ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">তাপমাত্রা (°C)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">আর্দ্রতা (%)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">সময় স্ট্যাম্প</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">বিবরণ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder align-middle text-center">অবস্থা পরিবর্তন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Storage_Room']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Products']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Temperature']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Humidity']; ?></td>

        
        
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Time_Stamp']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Details']; ?></td>
        <td class="text-center">

        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
        
        

        <a class="btn btn-sm btn-primary edit-btn" href="updatestorage.php?Storage_Room=<?php echo $row['Storage_Room']; ?>">
            সম্পাদনা
        </a>
        <button 
            class="btn btn-danger btn-sm text-center" 
             
            onclick="confirmDelete('<?php echo $row['Storage_Room']; ?>')">
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
    function confirmDelete(Storage_Room, productName) {
        // Set the confirmation message
        // const message = `আপনি কি নিশ্চিত যে আপনি ${productName} (স্টোরেজ রুম: ${Storage_Room}) মুছে ফেলতে চান?`;
        // document.getElementById('deleteProductMessage').textContent = message;

        // Set the delete link with the correct Storage_Room
        const deleteUrl = `warehouse_storage.php?Storage_Room=${Storage_Room}`;
        document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        deleteModal.show();
    }
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

   

    <!-- JS Scripts -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    <script>
        function populateEditModal(name, temperature, humidity, products) {
            document.getElementById('editStorageRoomName').value = name;
            document.getElementById('editStorageTemperature').value = temperature;
            document.getElementById('editStorageHumidity').value = humidity;
            const productSelect = document.getElementById('editStorageProducts');
            for (let i = 0; i < productSelect.options.length; i++) {
                productSelect.options[i].selected = products.includes(productSelect.options[i].value);
            }
        }

        function deleteStorageRoom(name) {
            if (confirm(`Are you sure you want to delete the Storage_Room: ${name}?`)) {
                // Logic to delete the Storage_Room
                alert(`${name} has been deleted.`);
            }
        }

        // Product Tracking Pie Chart
        var ctxProductTrackingChart = document.getElementById('productTrackingChart').getContext('2d');
        new Chart(ctxProductTrackingChart, {
          type: 'pie',
          data: {
            labels: ['খামার থেকে উৎপাদিত পণ্য', 'ট্রানজিটে', 'বিতরণ করা হয়েছে'],
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
<?php

include "./db.php";

// First query to get the product, farm, and harvestbatch data
$sql1 = "
    SELECT 
        p.name AS `Product_Name`,         
        f.farmname AS `Farm_Name`,         
        hb.lotnumber AS `lotnumber`,         
        DATE(hb.productiondate) AS `Production_Date`,  
        DATE(hb.expirydate) AS `Expiry_Date`          
    FROM 
        harvestbatch hb
    JOIN 
        product p ON hb.productID = p.productID
    JOIN 
        farm f ON hb.farmID = f.farmID;
";

$result1 = $conn->query($sql1);



// Second query to get product, package, and batchpackagedetails data
$sql2 = "
    SELECT 
        p.name AS `ProductName`, 
        pb.barcode, 
        pb.quantity AS `Amount`, 
        bpd.number_of_total_package AS `Total_Amount`, 
        bpd.packagingdate AS `Date_of_Packaging`
    FROM 
        product p
    JOIN 
        harvestbatch hb ON p.productID = hb.productID
    JOIN 
        batchpackagedetails bpd ON hb.lotnumber = bpd.lotnumber
    JOIN 
        package pb ON bpd.barcode = pb.barcode
    LIMIT 0, 25;
";

$result2 = $conn->query($sql2);



?>

<?php
// Check if a barcode or lotnumber is set in the URL for deletion
if (isset($_GET['barcode']) || isset($_GET['lotnumber'])) {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'safe_food_traceability');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['barcode'])) {
        // Get barcode and sanitize it
        $barcodeToDelete = htmlspecialchars($_GET['barcode']);

        // SQL query to delete the record from the 'batchpackagedetails' and 'package' tables based on barcode
        $deletePackageSQL = "DELETE FROM package WHERE barcode = ?";
        $deleteBatchSQL = "DELETE FROM batchpackagedetails WHERE barcode = ?";

        // Prepare and execute the package delete query
        $stmt = $conn->prepare($deletePackageSQL);
        $stmt->bind_param("s", $barcodeToDelete);
        if (!$stmt->execute()) {
            echo "Error deleting package: " . $conn->error;
        }
        $stmt->close();

        // Prepare and execute the batch delete query
        $stmt = $conn->prepare($deleteBatchSQL);
        $stmt->bind_param("s", $barcodeToDelete);
        if (!$stmt->execute()) {
            echo "Error deleting batch package details: " . $conn->error;
        }
        $stmt->close();
    }

    if (isset($_GET['lotnumber'])) {
        // Get lotnumber and sanitize it
        $lotnumberToDelete = htmlspecialchars($_GET['lotnumber']);

        // SQL query to delete the record from the 'harvestbatch' table based on lotnumber
        $deleteHarvestSQL = "DELETE FROM harvestbatch WHERE lotnumber = ?";

        // Prepare and execute the harvest batch delete query
        $stmt = $conn->prepare($deleteHarvestSQL);
        $stmt->bind_param("s", $lotnumberToDelete);
        if (!$stmt->execute()) {
            echo "Error deleting harvest batch: " . $conn->error;
        }
        $stmt->close();
    }

    // Redirect back to the management page after deletion
    header("Location: /Dbms_project/pages/warehouse_management.php");
    exit;
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>গুদাম ব্যবস্থাপনা - Warehouse Management</title>

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
                    <a class="nav-link active" href="warehouse_management.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-warehouse text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুদাম ব্যবস্থাপনা</span>
                    </a>
                </li>
    
                <!-- Storage Conditions -->
                <li class="nav-item">
                    <a class="nav-link" href="warehouse_storage.php">
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
                <!-- Logout -->
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
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">গুদাম ব্যবস্থাপনা</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">গুদাম ব্যবস্থাপনা</h6>
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
            <!-- Inventory Management Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <h6>ব্যাচ পণ্য তালিকা</h6>
                            <a class="btn btn-sm btn-success" href="addmanagement.php">নতুন পণ্য যোগ করুন</a>                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">পণ্যের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">খামারের নাম</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">লট নম্বর</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">উৎপাদন তারিখ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">মেয়াদ</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Farm_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['lotnumber']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Production_Date']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Expiry_Date']; ?></td>
        
        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <a class="btn btn-sm btn-primary edit-btn" href="updatemanagement.php?lotnumber=<?php echo $row['lotnumber']; ?>">
                সম্পাদনা
            </a>
            <button 
                class="btn btn-danger btn-sm text-center" 
                onclick="confirmDelete('warehouse_management.php?lotnumber=<?php echo $row['lotnumber']; ?>')">
                মুছে ফেলুন
            </button>
        </div>
        </td>

        </tr>                       

<?php } } ?>

</tbody>
</table>
</div>
</div>
</div>
</div>

<div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
        <h6>প্যাকেজ  পণ্য তালিকা</h6>
        <a class="btn btn-sm btn-success" href="addmanagement2.php">নতুন পণ্য যোগ করুন</a>     
     </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">পণ্যের নাম</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">বারকোড</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">পরিমাণ</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">মোট পরিমাণ</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">প্যাকেজিং তারিখ</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                ?>

                    <tr>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['ProductName']; ?></td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['barcode']; ?></td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Amount']; ?></td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Total_Amount']; ?></td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Date_of_Packaging']; ?></td>
                        <td class="text-center">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                            <a class="btn btn-sm btn-primary edit-btn" href="updatemanagement2.php?barcode=<?php echo $row['barcode']; ?>">
                                সম্পাদনা
                            </a>
                            <button 
                                class="btn btn-danger btn-sm text-center" 
                                onclick="confirmDelete('warehouse_management.php?barcode=<?php echo $row['barcode']; ?>')">
                                মুছে ফেলুন
                            </button>
                        </div>
                        </td>
                    </tr>

                <?php } } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $conn->close(); ?>

            </div>
            </div>
        </div>
    </main>

 <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>আপনি কি নিশ্চিত যে আপনি এই আইটেমটি মুছে ফেলতে চান?</p>
                <p id="deleteModalMessage" class="text-danger"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <a id="deleteConfirmButton" class="btn btn-danger" href="#">মুছে ফেলুন</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to show the delete confirmation modal
    function confirmDelete(deleteUrl) {
        // Set the delete link in the modal
        document.getElementById('deleteConfirmButton').setAttribute('href', deleteUrl);

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>

    <!-- JS Scripts -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    <script>
        function populateEditModal(name, stock, condition, humidity, temperature) {
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductStock').value = stock;
            document.getElementById('editProductCondition').value = condition;
            document.getElementById('editProductHumidity').value = humidity;
            document.getElementById('editProductTemperature').value = temperature;
        }

        function populateDeleteModal(name) {
            document.getElementById('deleteProductMessage').textContent = `আপনি কি নিশ্চিত যে আপনি "${name}" পণ্যটি মুছে ফেলতে চান?`;
        }
    </script>
</body>

</html>
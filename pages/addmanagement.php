<?php
// Database connection
include "db.php";

// Handle form submission for inserting new harvestbatch data
if (isset($_POST['insert'])) {
    // Sanitize form input
    $lotnumber = $conn->real_escape_string($_POST['lotnumber']);
    $Production_Date = $conn->real_escape_string($_POST['Production_Date']);
    $Expiry_Date = $conn->real_escape_string($_POST['Expiry_Date']);
    $Product_Name = $conn->real_escape_string($_POST['Product_Name']);
    $Farm_Name = $conn->real_escape_string($_POST['Farm_Name']);

    // Get the productID and farmID based on the product name and farm name
    $get_product_sql = "SELECT productID FROM product WHERE name = '$Product_Name' LIMIT 1";
    $get_farm_sql = "SELECT farmID FROM farm WHERE farmname = '$Farm_Name' LIMIT 1";
    
    // Execute to fetch the productID and farmID
    $product_result = $conn->query($get_product_sql);
    $farm_result = $conn->query($get_farm_sql);

    if ($product_result && $farm_result && $product_result->num_rows > 0 && $farm_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $farm_row = $farm_result->fetch_assoc();

        $productID = $product_row['productID'];
        $farmID = $farm_row['farmID'];

        // Debugging: Output the productID and farmID
        echo "ProductID: $productID<br>";
        echo "FarmID: $farmID<br>";

        // Insert query to add new harvest batch
        $insert_sql = "
            INSERT INTO harvestbatch (lotnumber, productiondate, expirydate, productID, farmID)
            VALUES ('$lotnumber', '$Production_Date', '$Expiry_Date', '$productID', '$farmID')
        ";

        // Execute the insert query
        if ($conn->query($insert_sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">New harvest batch inserted successfully.</div>';
            header("refresh:0; url=/Dbms_project/pages/warehouse_management.php"); // Redirect after success
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Error inserting harvest batch data: ' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid Product Name or Farm Name.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Harvest Batch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Insert Harvest Batch</h2>
    </div>

    <!-- Bootstrap Modal for Insert Form -->
    <div class="modal fade" id="insertHarvestBatchModal" tabindex="-1" aria-labelledby="insertHarvestBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertHarvestBatchModalLabel">Insert Harvest Batch Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="lotnumber" class="form-label">Lot Number</label>
                            <input type="text" class="form-control" name="lotnumber" id="lotnumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="Product_Name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="Product_Name" id="Product_Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="Farm_Name" class="form-label">Farm Name</label>
                            <input type="text" class="form-control" name="Farm_Name" id="Farm_Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="Production_Date" class="form-label">Production Date</label>
                            <input type="date" class="form-control" name="Production_Date" id="Production_Date" required>
                        </div>
                        <div class="mb-3">
                            <label for="Expiry_Date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" name="Expiry_Date" id="Expiry_Date" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">সংরক্ষণ করুন</button>
                            <button type="submit" class="btn btn-primary" name="insert">সংরক্ষণ করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-open Modal -->
    <script>
        const insertModal = new bootstrap.Modal(document.getElementById('insertHarvestBatchModal'));
        insertModal.show();
    </script>
</body>
</html>

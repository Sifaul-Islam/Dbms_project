<?php
// Database connection
include "db.php";

// Check if 'lotnumber' is passed in the URL and fetch the data from the database
if (isset($_GET['lotnumber'])) {
    $lotnumber = $conn->real_escape_string($_GET['lotnumber']); // Sanitize input to prevent SQL injection

    // SQL query to fetch data for the specified lotnumber
    $sql = "
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
            farm f ON hb.farmID = f.farmID
        WHERE 
            hb.lotnumber = '$lotnumber'
        LIMIT 1
    ";

    // Execute the query and fetch data
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Product_Name = htmlspecialchars($row['Product_Name']);
        $Farm_Name = htmlspecialchars($row['Farm_Name']);
        $lotnumber = htmlspecialchars($row['lotnumber']);
        $Production_Date = htmlspecialchars($row['Production_Date']);
        $Expiry_Date = htmlspecialchars($row['Expiry_Date']);
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found for the specified lot number.</div>';
        exit;
    }
}

// Handle form submission for updating harvestbatch data
if (isset($_POST['update'])) {
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

        // Update query
        $update_sql = "
            UPDATE harvestbatch hb
            SET 
                hb.productiondate = '$Production_Date', 
                hb.expirydate = '$Expiry_Date',
                hb.productID = '$productID',
                hb.farmID = '$farmID'
            WHERE 
                hb.lotnumber = '$lotnumber'
        ";

        // Execute the update query
        if ($conn->query($update_sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Harvestbatch data updated successfully.</div>';
            header("refresh:0; url=/Dbms_project/pages/warehouse_management.php"); // Redirect after 2 seconds
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating harvestbatch data: ' . $conn->error . '</div>';
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
    <title>Harvest Batch Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Harvest Batch Update Form</h2>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editHarvestBatchModal" tabindex="-1" aria-labelledby="editHarvestBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHarvestBatchModalLabel">Update Harvest Batch Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="lotnumber" class="form-label">লট নম্বর</label>
                            <input type="text" class="form-control" name="lotnumber" id="lotnumber" value="<?php echo $lotnumber; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="Product_Name" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" name="Product_Name" id="Product_Name" value="<?php echo $Product_Name; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Farm_Name" class="form-label">খামারের নাম</label>
                            <input type="text" class="form-control" name="Farm_Name" id="Farm_Name" value="<?php echo $Farm_Name; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Production_Date" class="form-label">উৎপাদন তারিখ</label>
                            <input type="date" class="form-control" name="Production_Date" id="Production_Date" value="<?php echo $Production_Date; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Expiry_Date" class="form-label">মেয়াদ</label>
                            <input type="date" class="form-control" name="Expiry_Date" id="Expiry_Date" value="<?php echo $Expiry_Date; ?>" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                            <button type="submit" class="btn btn-primary" name="update">সংরক্ষণ করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-open Modal -->
    <?php if (isset($_GET['lotnumber'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editHarvestBatchModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>

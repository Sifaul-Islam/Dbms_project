<?php
// Database connection
include "db.php";

// Check if 'barcode' is passed in the URL and fetch the data from the database
if (isset($_GET['barcode'])) {
    $barcode = $conn->real_escape_string($_GET['barcode']); // Sanitize input to prevent SQL injection

    // SQL query to fetch data for the specified barcode
    $sql = "
        SELECT 
            p.name AS `Product_Name`,
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
        WHERE 
            pb.barcode = '$barcode'
        LIMIT 1
    ";

    // Execute the query and fetch data
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Product_Name = htmlspecialchars($row['Product_Name']);
        $barcode = htmlspecialchars($row['barcode']);
        $Amount = htmlspecialchars($row['Amount']);
        $Total_Amount = htmlspecialchars($row['Total_Amount']);
        $Date_of_Packaging = htmlspecialchars($row['Date_of_Packaging']);
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found for the specified barcode.</div>';
        exit;
    }
}

// Handle form submission for updating package data
if (isset($_POST['update'])) {
    // Sanitize form input
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $Amount = $conn->real_escape_string($_POST['Amount']);
    $Total_Amount = $conn->real_escape_string($_POST['Total_Amount']);
    $Date_of_Packaging = $conn->real_escape_string($_POST['Date_of_Packaging']);
    $Product_Name = $conn->real_escape_string($_POST['Product_Name']);

    // Get the productID based on the product name
    $get_product_sql = "SELECT productID FROM product WHERE name = '$Product_Name' LIMIT 1";
    
    // Execute to fetch the productID
    $product_result = $conn->query($get_product_sql);

    if ($product_result && $product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $productID = $product_row['productID'];

        // Update query
        $update_sql = "
            UPDATE package pb
            JOIN batchpackagedetails bpd ON pb.barcode = bpd.barcode
            JOIN harvestbatch hb ON bpd.lotnumber = hb.lotnumber
            SET 
                pb.quantity = '$Amount', 
                bpd.number_of_total_package = '$Total_Amount',
                bpd.packagingdate = '$Date_of_Packaging',
                hb.productID = '$productID'
            WHERE 
                pb.barcode = '$barcode'
        ";

        // Execute the update query
        if ($conn->query($update_sql) === TRUE) {
            echo '<div class="alert alert-success" role="alert">Package data updated successfully.</div>';
            header("refresh:2; url=/Dbms_project/pages/warehouse_management.php"); // Redirect after 2 seconds
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating package data: ' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid Product Name.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Update</title>
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
        <h2 class="text-center">Package Update Form</h2>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editPackageModal" tabindex="-1" aria-labelledby="editPackageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageModalLabel">Update Package Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="barcode" class="form-label">বারকোড</label>
                            <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo $barcode; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Product_Name" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" name="Product_Name" id="Product_Name" value="<?php echo $Product_Name; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Amount" class="form-label">পরিমাণ</label>
                            <input type="number" class="form-control" name="Amount" id="Amount" value="<?php echo $Amount; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Total_Amount" class="form-label">মোট পরিমাণ</label>
                            <input type="number" class="form-control" name="Total_Amount" id="Total_Amount" value="<?php echo $Total_Amount; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Date_of_Packaging" class="form-label">প্যাকেজিং তারিখ</label>
                            <input type="date" class="form-control" name="Date_of_Packaging" id="Date_of_Packaging" value="<?php echo $Date_of_Packaging; ?>" required>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-open Modal for Edit -->
    <?php if (isset($_GET['barcode'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editPackageModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>

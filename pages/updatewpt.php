<?php
// Database connection
include "db.php";


// Handle form submission for updating a record
if (isset($_POST['update'])) {
    // Capture data from the form
    $Product_Name = $_POST['Product_Name'];
    $Farm_Name = $_POST['Farm_Name'];
    $Warehouse_Name = $_POST['Warehouse_Name'];
    $Farm_Location = $_POST['Farm_Location'];
    $Warehouse_Location = $_POST['Warehouse_Location'];
    $Distributor_Address = $_POST['Distributor_Address'];
    $Transfer_Date = $_POST['Transfer_Date'];

    // SQL query to update the record (Notice the use of ? placeholders)
    $sql = "UPDATE batchtransfer bt
            JOIN harvestbatch hb ON bt.lotnumber = hb.lotnumber
            JOIN farm f ON hb.farmID = f.farmID
            JOIN product p ON hb.productID = p.productID
            JOIN warehouse w ON bt.warehouseID = w.warehouseID
            JOIN distributor d ON w.distributorID = d.distributorID
            SET 
                f.farmname = ?, 
                w.warehousename = ?, 
                f.location = ?, 
                w.location = ?, 
                d.address = ?, 
                bt.transferdate = ?
            WHERE p.name = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check for errors in preparing the SQL query
    if ($stmt === false) {
        echo '<div class="alert alert-danger" role="alert">SQL preparation failed: ' . $conn->error . '</div>';
        exit;
    }

    // Bind parameters to the prepared statement
    // "sssssss" means seven string parameters (all the form fields we are binding)
    $stmt->bind_param("sssssss", $Farm_Name, $Warehouse_Name, $Farm_Location, $Warehouse_Location, $Distributor_Address, $Transfer_Date, $Product_Name);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully.</div>';
        header("Location:/Dbms_project/pages/warehouse_product_tracking.php?"); // Redirect after success
        exit;
    } else {
        // If query fails, show error message
        echo '<div class="alert alert-danger" role="alert">Error updating record: ' . $stmt->error . '</div>';
    }

    // Close the statement
    $stmt->close();
}





// Fetch data for the form based on Product Name
if (isset($_GET['Product_Name'])) {
    $Product_Name = $_GET['Product_Name'];

    // SQL query to fetch data based on Product Name
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
                distributor d ON w.distributorID = d.distributorID
            WHERE p.name = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo '<div class="alert alert-danger" role="alert">SQL preparation failed: ' . $conn->error . '</div>';
        exit;
    }

    // Bind the Product Name parameter
    $stmt->bind_param("s", $Product_Name);

    // Execute the query and fetch the result
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Farm_Name = $row['Farm_Name'];
        $Warehouse_Name = $row['Warehouse_Name'];
        $Farm_Location = $row['Farm_Location'];
        $Warehouse_Location = $row['Warehouse_Location'];
        $Distributor_Address = $row['Distributor_Address'];
        $Transfer_Date = $row['Transfer_Date'];
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found for the specified product name.</div>';
        exit;
    }

    // Close the statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Transfer Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Batch Transfer Update Form</h2>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">পণ্য সম্পাদনা করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="Product_Name" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" name="Product_Name" id="Product_Name" value="<?php echo $Product_Name; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="Farm_Name" class="form-label">খামারের নাম</label>
                            <input type="text" class="form-control" name="Farm_Name" id="Farm_Name" value="<?php echo $Farm_Name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Warehouse_Name" class="form-label">গুদামের নাম</label>
                            <input type="text" class="form-control" name="Warehouse_Name" id="Warehouse_Name" value="<?php echo $Warehouse_Name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Farm_Location" class="form-label">খামারের অবস্থান</label>
                            <input type="text" class="form-control" name="Farm_Location" id="Farm_Location" value="<?php echo $Farm_Location; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Warehouse_Location" class="form-label">গুদামের অবস্থান</label>
                            <input type="text" class="form-control" name="Warehouse_Location" id="Warehouse_Location" value="<?php echo $Warehouse_Location; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Distributor_Address" class="form-label">বিতরণকারীর ঠিকানা</label>
                            <input type="text" class="form-control" name="Distributor_Address" id="Distributor_Address" value="<?php echo $Distributor_Address; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Transfer_Date" class="form-label">স্থানান্তর তারিখ</label>
                            <input type="date" class="form-control" name="Transfer_Date" id="Transfer_Date" value="<?php echo $Transfer_Date; ?>">
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
    <?php if (isset($_GET['Product_Name'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>

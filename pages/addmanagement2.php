<?php
// Database connection
include "db.php";

// Handle form submission for inserting new data
if (isset($_POST['add_product'])) {
    // Sanitize form input
    $product_name = $conn->real_escape_string($_POST['product_name']);
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $lotnumber = $conn->real_escape_string($_POST['lotnumber']); // From dropdown

    // Check if required fields are not empty
    if (empty($product_name) || empty($barcode) || empty($quantity) || empty($lotnumber)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
        exit; // Stop execution if any required field is empty
    }

    // Get the warehouseID, production_date, and farmID values (assuming these are predefined or from the form)
    $warehouseID = 1;  // Default or selected warehouseID
    $production_date = NULL; // Optional, can be NULL
    $expiry_date = NULL; // Optional, can be NULL
    $farmID = 1; // Default or selected farmID

    // 1. Insert Product into the product table
    $insert_product_sql = "
        INSERT INTO product (name) 
        VALUES ('$product_name')
    ";
    
    if ($conn->query($insert_product_sql) === TRUE) {
        $productID = $conn->insert_id;  // Get the last inserted productID
        
        // 2. Insert into Package table
        $insert_package_sql = "
            INSERT INTO package (barcode, warehouseID, quantity) 
            VALUES ('$barcode', NULL, '$quantity')
        ";

        if ($conn->query($insert_package_sql) === TRUE) {
            // 3. Insert into Batch Package Details table
            $insert_batch_sql = "
                INSERT INTO batchpackagedetails (barcode, lotnumber, packagingdate, number_of_total_package) 
                VALUES ('$barcode', '$lotnumber', NULL, NULL)
            ";

            if ($conn->query($insert_batch_sql) === TRUE) {
                // 4. Insert into Harvest Batch table
                $insert_harvestbatch_sql = "
                    INSERT INTO harvestbatch (lotnumber, productID, farmID, productiondate, expirydate) 
                    VALUES ('$lotnumber', '$productID', '$farmID', NULL, NULL)
                ";

                if ($conn->query($insert_harvestbatch_sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">New product, package, batch, and harvest batch inserted successfully.</div>';
                    header("refresh:0; url=/Dbms_project/pages/warehouse_management.php");
                    exit;
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error inserting harvest batch data: ' . $conn->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Error inserting batch package details: ' . $conn->error . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Error inserting package data: ' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Error inserting product data: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product, Package, and Batch</title>
</head>
<body>
    <div class="container">
        <h2>Add a New Product, Package, and Batch Details</h2>
        <form method="post" action="">
            <!-- Product Name -->
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" required><br>

            <!-- Barcode -->
            <label for="barcode">Barcode:</label>
            <input type="text" name="barcode" id="barcode" required><br>

            <!-- Quantity -->
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br>

            <!-- Lot Number (Dropdown) -->
            <label for="lotnumber">Lot Number:</label>
            <select name="lotnumber" id="lotnumber" required>
                <option value="">Select Lot Number</option>
                <?php
                // Fetch all existing lotnumbers from harvestbatch table
                $lot_sql = "SELECT lotnumber FROM harvestbatch";
                $lot_result = $conn->query($lot_sql);

                if ($lot_result->num_rows > 0) {
                    while ($lot_row = $lot_result->fetch_assoc()) {
                        echo "<option value='" . $lot_row['lotnumber'] . "'>" . $lot_row['lotnumber'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No Lot Numbers Available</option>";
                }
                ?>
            </select><br>

            <!-- Submit Button -->
            <input type="submit" name="add_product" value="Add Product, Package, and Batch">
        </form>
    </div>
</body>
</html>

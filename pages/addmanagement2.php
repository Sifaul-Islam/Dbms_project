<?php
// Include the database connection
include "./db.php"; // Adjust the path based on your file structure

// Check if form is submitted
if (isset($_POST['addPackage'])) {
    // Step 1: Sanitize input data
    $ProductName = $conn->real_escape_string($_POST['ProductName']);
    $Barcode = $conn->real_escape_string($_POST['Barcode']);
    $Amount = intval($_POST['Amount']);
    $TotalAmount = intval($_POST['TotalAmount']);
    $PackagingDate = $conn->real_escape_string($_POST['PackagingDate']);

    // Step 2: Ensure the product exists
    $productCheckSQL = "SELECT productID FROM product WHERE name = '$ProductName' LIMIT 1";
    $productResult = $conn->query($productCheckSQL);

    if ($productResult && $productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        $productID = $productRow['productID'];
    } else {
        $insertProductSQL = "INSERT INTO product (name) VALUES ('$ProductName')";
        if ($conn->query($insertProductSQL) === TRUE) {
            $productID = $conn->insert_id; // Get the auto-generated productID
        } else {
            echo '<div class="alert alert-danger">Error adding product: ' . $conn->error . '</div>';
            exit;
        }
    }

    // Step 3: Ensure the warehouse exists (use a default ID or add one if missing)
    $warehouseID = 1; // Default warehouse ID (adjust as needed)
    $warehouseCheckSQL = "SELECT warehouseID FROM warehouse WHERE warehouseID = '$warehouseID' LIMIT 1";
    $warehouseResult = $conn->query($warehouseCheckSQL);

    if (!$warehouseResult || $warehouseResult->num_rows === 0) {
        $insertWarehouseSQL = "
            INSERT INTO warehouse (warehouseID, warehousename, location) 
            VALUES ('$warehouseID', 'Default Warehouse', 'Default Location')
        ";
        if (!$conn->query($insertWarehouseSQL)) {
            echo '<div class="alert alert-danger">Error adding warehouse: ' . $conn->error . '</div>';
            exit;
        }
    }

    // Step 4: Insert into harvestbatch
    $lotnumber = rand(10000, 99999); // Generate a random lot number
    $insertHarvestSQL = "
        INSERT INTO harvestbatch (lotnumber, productID) 
        VALUES ('$lotnumber', '$productID')
    ";
    if (!$conn->query($insertHarvestSQL)) {
        echo '<div class="alert alert-danger">Error adding harvest batch: ' . $conn->error . '</div>';
        exit;
    }

    // Step 5: Insert into batchpackagedetails
    $insertBatchDetailsSQL = "
        INSERT INTO batchpackagedetails (barcode, lotnumber, packagingdate, number_of_total_package) 
        VALUES ('$Barcode', '$lotnumber', '$PackagingDate', '$TotalAmount')
    ";
    if (!$conn->query($insertBatchDetailsSQL)) {
        echo '<div class="alert alert-danger">Error adding batch package details: ' . $conn->error . '</div>';
        exit;
    }

    // Step 6: Insert into package
    $insertPackageSQL = "
        INSERT INTO package (barcode, warehouseID, quantity) 
        VALUES ('$Barcode', '$warehouseID', '$Amount')
    ";
    if ($conn->query($insertPackageSQL)) {
        // Redirect to warehouse_management.php on success
        header("Location: warehouse_management.php");
        exit; // Stop further script execution after redirect
    } else {
        echo '<div class="alert alert-danger">Error adding package: ' . $conn->error . '</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input, button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Package</h1>
        <form action="" method="POST">
            <div>
                <label for="ProductName">Product Name:</label>
                <input type="text" name="ProductName" id="ProductName" required>
            </div>
            <div>
                <label for="Barcode">Barcode:</label>
                <input type="text" name="Barcode" id="Barcode" required>
            </div>
            <div>
                <label for="Amount">Amount:</label>
                <input type="number" name="Amount" id="Amount" required>
            </div>
            <div>
                <label for="TotalAmount">Total Amount:</label>
                <input type="number" name="TotalAmount" id="TotalAmount" required>
            </div>
            <div>
                <label for="PackagingDate">Date of Packaging:</label>
                <input type="date" name="PackagingDate" id="PackagingDate" required>
            </div>
            <button type="submit" name="addPackage">Add Package</button>
        </form>
    </div>
</body>
</html>

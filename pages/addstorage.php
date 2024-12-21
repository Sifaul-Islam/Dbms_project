<?php
// addstorage.php - Backend logic to insert and update sensor data

include "db.php"; // Include the database connection

// Handle form submission for adding or updating sensor data
if (isset($_POST['submit'])) {
    // Fetch the input values
    $Storage_Room = $conn->real_escape_string($_POST['Storage_Room']);
    $Temperature = $conn->real_escape_string($_POST['Temperature']);
    $Humidity = $conn->real_escape_string($_POST['Humidity']);
    $WarehouseID = $conn->real_escape_string($_POST['WarehouseID']);
    $Oxygen = $conn->real_escape_string($_POST['Oxygen']);
    $LightIntensity = $conn->real_escape_string($_POST['LightIntensity']);
    $ProductID = $conn->real_escape_string($_POST['ProductName']); // Get selected product ID
    $Time_Stamp = $conn->real_escape_string($_POST['Time_Stamp']); // This will be the datetime input

    // Check if the record already exists in the sensor table
    $check_sql = "SELECT * FROM sensor WHERE warehouseID = '$WarehouseID' AND roomNo = '$Storage_Room'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Record exists, so update the existing record
        $update_sql = "
            UPDATE sensor 
            SET temperature = '$Temperature', 
                humidity = '$Humidity', 
                oxygen = '$Oxygen', 
                `light intensity` = '$LightIntensity', 
                timeStamp = '$Time_Stamp' 
            WHERE warehouseID = '$WarehouseID' AND roomNo = '$Storage_Room'";

        if ($conn->query($update_sql) === TRUE) {
            // After update, refresh page
            header("Location: warehouse_storage.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating sensor data: ' . $conn->error . '</div>';
        }
    } else {
        // If no existing record, proceed with insertion into sensor table
        $insert_sql = "
            INSERT INTO sensor (roomNo, temperature, humidity, oxygen, `light intensity`, timeStamp, warehouseID) 
            VALUES ('$Storage_Room', '$Temperature', '$Humidity', '$Oxygen', '$LightIntensity', '$Time_Stamp', '$WarehouseID')";

        if ($conn->query($insert_sql) === TRUE) {
            // Insert associated product into harvestbatch table
            $lotnumber_sql = "SELECT lotnumber FROM warehouse WHERE warehouseID = '$WarehouseID'";
            $lotnumber_result = $conn->query($lotnumber_sql);
            $lotnumber_row = $lotnumber_result->fetch_assoc();
            $lotnumber = $lotnumber_row['lotnumber'];

            // Check if the product already exists in harvestbatch for the given lotnumber
            $check_harvest_sql = "SELECT * FROM harvestbatch WHERE lotnumber = '$lotnumber' AND productID = '$ProductID'";
            $check_harvest_result = $conn->query($check_harvest_sql);

            // If record exists, skip the insert and refresh page
            if ($check_harvest_result->num_rows > 0) {
                header("Location: warehouse_storage.php");
                exit();
            } else {
                // If the record doesn't exist, insert it into harvestbatch
                $insert_harvest_sql = "INSERT INTO harvestbatch (lotnumber, productID) VALUES ('$lotnumber', '$ProductID')";
                if ($conn->query($insert_harvest_sql) === TRUE) {
                    // After insertion, refresh the page
                    header("Location: warehouse_storage.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error inserting product into harvestbatch: ' . $conn->error . '</div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding sensor data: ' . $conn->error . '</div>';
        }
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Storage Sensor Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Add or Update Storage Sensor Data</h2>
        
        <!-- Form for adding/updating sensor data -->
        <form action="" method="POST">
            <!-- Storage Room -->
            <div class="form-group">
                <label for="Storage_Room">Storage Room:</label>
                <input type="text" class="form-control" id="Storage_Room" name="Storage_Room" required>
            </div>

            <!-- Temperature -->
            <div class="form-group">
                <label for="Temperature">Temperature:</label>
                <input type="number" class="form-control" id="Temperature" name="Temperature" step="0.01" required>
            </div>

            <!-- Humidity -->
            <div class="form-group">
                <label for="Humidity">Humidity:</label>
                <input type="number" class="form-control" id="Humidity" name="Humidity" step="0.01" required>
            </div>

            <!-- Oxygen -->
            <div class="form-group">
                <label for="Oxygen">Oxygen:</label>
                <input type="number" class="form-control" id="Oxygen" name="Oxygen" step="0.01" required>
            </div>

            <!-- Light Intensity -->
            <div class="form-group">
                <label for="LightIntensity">Light Intensity:</label>
                <input type="number" class="form-control" id="LightIntensity" name="LightIntensity" step="0.01" required>
            </div>

            <!-- Product Name -->
            <div class="form-group">
                <label for="ProductName">Product Name:</label>
                <select class="form-control" id="ProductName" name="ProductName" required>
                    <option value="">Select Product</option>
                    <?php
                    // Fetch all product names
                    $product_sql = "SELECT productID, name FROM product";
                    $product_result = $conn->query($product_sql);

                    if ($product_result->num_rows > 0) {
                        while ($row = $product_result->fetch_assoc()) {
                            echo '<option value="' . $row['productID'] . '">' . $row['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Warehouse ID -->
            <div class="form-group">
                <label for="WarehouseID">Warehouse ID:</label>
                <select class="form-control" id="WarehouseID" name="WarehouseID" required>
                    <option value="">Select Warehouse</option>
                    <?php
                    // Fetch all warehouse IDs
                    $warehouse_sql = "SELECT warehouseID FROM warehouse";
                    $warehouse_result = $conn->query($warehouse_sql);

                    if ($warehouse_result->num_rows > 0) {
                        while ($row = $warehouse_result->fetch_assoc()) {
                            echo '<option value="' . $row['warehouseID'] . '">' . $row['warehouseID'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Timestamp -->
            <div class="form-group">
                <label for="Time_Stamp">Time Stamp:</label>
                <input type="datetime-local" class="form-control" id="Time_Stamp" name="Time_Stamp" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
